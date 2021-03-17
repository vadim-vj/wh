import json
import os
import re
import sys
from time import sleep
from typing import List, Dict, Any

from bs4 import BeautifulSoup, element
import requests

# Limit for pages to process
limit: int = -1
# Timeout between requests
pause: float = 1.0  # in seconds

# pylint: disable=line-too-long


def log(*argv) -> None:
    """Simple wrapper."""
    print(*argv, sep=', ')


if len(sys.argv) < 3:
    raise Exception('Please define year and month')

try:
    month: int = int(sys.argv[1])
    year: int = int(sys.argv[2])
except ValueError:
    raise Exception('Wrong format for year or month')

# Main page URL
page: str = 'https://tenders.mts.ru/'

# JSON to compose
result: List[Dict[str, Any]] = []

# Texts to search
patterns: Dict[str, Any] = {
    'respPerson': r'Ответственное\s+лицо',
    'number': r'Номер\s+торгов',
    'publishDate': r'Дата\s+публикации\s+на\s+сайте',
    'finishDate': r'Дата\s+окончания'
}
for key, pattern in patterns.items():
    patterns[key] = re.compile(r'^\s*' + pattern + r'\s*:\s+')

# Retrieve `__VIEWSTATE` value from main page
soap: BeautifulSoup = BeautifulSoup(requests.get(page).text, 'html.parser')
viewstate: str = soap.find(id='__VIEWSTATE').get('value')

if not viewstate:
    raise Exception('No `__VIEWSTATE` retrieved, aborting')

event_target: str = str(year) + '_' + str(month)
log('Fetch list from main page (' + event_target + ')', page)

body: str = requests.post(page + 'Default.aspx', headers={
    # For some reasons this POST request requires the 'User-Agent' header. Use some random one
    'User-Agent': 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:81.0) Gecko/20100101 Firefox/81.0',
}, data={
    '__EVENTTARGET': 'ctl00$ContentPlaceHolderBody$calendarNavigation$' + event_target,
    '__VIEWSTATE': viewstate,
    '__VIEWSTATEENCRYPTED': '',
    '__ASYNCPOST': 'true',
    'RadAJAXControlID': 'ctl00_radAjaxManager'
}).text

soap = BeautifulSoup(body, 'html.parser')
tenders_list: List[element.ResultSet] = soap.find_all('div', {'class': 'm-purchases-list-row'})
log('Found ' + str(len(tenders_list)) + ' tenders' + (', limit ' + str(limit) if limit > -1 else ''))

# Create file for writing
file_name = str(month) + '_' + str(year) + '.txt'
with open(os.path.join(os.path.dirname(__file__), file_name), 'w') as fout:

    # Process main page list
    for index, row in enumerate(tenders_list):
        # For testing
        if -1 < limit <= index:
            break

        # Prevent DDOS
        if index > 0:
            sleep(pause)

        # From main page
        date: element.ResultSet = row.find('span', {'class': 'm-purchases-list-date'})
        link: element.ResultSet = row.find('div', {'class': 'm-purchases-list-link'}).find('a')

        data: Dict[str, Any] = {
            'date': date.text,
            'href': page + link.get('href'),
            'title': link.text,
        }

        for key, value in data.items():
            data[key] = value.strip()

        # From individual page
        log('[' + str(index + 1) + '] Fetch data from individual page', data['href'])
        soap = BeautifulSoup(requests.get(data['href']).text, 'html.parser')

        # Search for dates, responsible person, etc.
        details: element.ResultSet = soap.find('div', {'id': 'ctl00_ContentPlaceHolderBody_divSummary'})

        for key, pattern in patterns.items():
            item: element.ResultSet = details.find('p', text=pattern)

            if item:
                data[key] = re.sub(pattern, '', item.text).strip()

        # If files' panel exists
        files: element.ResultSet = soap.find('div', {'id': 'ctl00_ContentPlaceHolderBody_FilesPanel'})

        if files:
            files_data: List[Dict[str, str]] = []

            for item in files.findAll('a'):
                files_data.append({
                    'name': item.text.strip(),
                    'href': page + item.get('href').strip(),
                })

            if files_data:
                data['files'] = files_data

        # Add ro result and repeat
        result.append(data)

        # Write to file
        fout.seek(0)
        json.dump(result, fout, indent=2, ensure_ascii=False)
        fout.truncate()
