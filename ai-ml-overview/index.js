'use strict';

class MenuItem {
  constructor(title, href, child) {
    this.title = title;
    this.href = href;
    this.child = child || '';
  }

  toString() {
    return '<a href="' + (this.href ? 'page/' + this.href + '.html' : '') + '">' + this.title + '</a>' + this.child;
  }
}

class Menu {
  constructor(items) {
    this.items = items;
  }

  toString() {
    return '<ul><li>' + this.items.join('</li><li>') + '</li></ul>';
  }
}

document.addEventListener('DOMContentLoaded', event => {
  document.body.innerHTML = '<div class="main">\n<h1>' + document.title + '</h1>' + document.body.innerHTML.trim() + '</div>';

  const menu = new Menu([
    new MenuItem('Главная', ''),
    new MenuItem('Ресурсы', 'resources'),
    new MenuItem('Проекты', 'projects', new Menu([
      new MenuItem('OpenWorm', 'projects/openworm'),
      new MenuItem('Numenta', 'projects/numenta'),
    ])),
    new MenuItem('Темы', 'themes'),
  ]);
  document.body.insertAdjacentHTML('afterbegin', '<div class="left">' + menu + '</div>');

  const divMenu = document.body.querySelector('div.main > div.menu');
  if (divMenu) {
    divMenu.innerHTML = menu;
  }
}, false);
