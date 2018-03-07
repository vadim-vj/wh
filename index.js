'use strict';

class MenuItem {
  constructor(title, href) {
    this.title = title;
    this.href = href;
  }

  toString() {
    return '<a href="' + (this.href ? 'page/' + this.href + '.html' : '') + '">' + this.title + '</a>';
  }
}

class Menu {
  get items() {
    return [
      new MenuItem('Главная', ''),
      new MenuItem('Литература', 'literature'),
      new MenuItem('Проекты', 'projects'),
    ];
  }

  toString() {
    return '<ul><li>' + this.items.join('</li><li>') + '</li></ul>';
  }
}

document.addEventListener('DOMContentLoaded', event => {
  document.body.innerHTML = '<div class="main">\n<h1>' + document.title + '</h1>' + document.body.innerHTML.trim() + '</div>';

  const menu = new Menu();
  document.body.insertAdjacentHTML('afterbegin', '<div class="left">' + menu + '</div>');
  document.body.querySelector('div.main > div.menu').innerHTML = menu;
}, false);
