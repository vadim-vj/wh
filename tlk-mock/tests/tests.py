import os
import json
import pytest
from tornado import escape
from tornado.httpclient import HTTPClientError

from app import Application


@pytest.fixture
def app():
    return Application(debug=False)


async def test_some(http_server_client):
    #response = await http_server_client.fetch('/api/v1/projects')
    #assert response.code == 200

    #body = escape.json_decode(response.body)
    #assert body == {
    #    'items': [],
    #    'hasMore': False,
    #}

    path = '/api/v1/projects-not-exist'
    try:
        await http_server_client.fetch(path)
    except HTTPClientError as err:
        assert err.code == 404
        assert err.response.body \
            == b'{"error": "Unknown path: \'' + path.encode() + b'\'"}'

    with open(os.path.dirname(__file__) + '/../requests/projects.json', 'r') as fout:
        body = json.dumps(json.load(fout))
        response = await http_server_client.fetch('/api/v1/projects', method='POST', body=body)

    assert response.code == 200
    body = escape.json_decode(response.body)
    assert body == {}
