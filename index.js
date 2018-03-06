'use strict';

class MenuItem {
  constructor(title, href) {
    this.title = title;
    this.href = href;
  }

  toString() {
    return '<a href="' + this.href + '">' + this.title + '</a>';
  }
}

class Menu {
  get items() {
    return [
      new MenuItem('Главная', ''),
      new MenuItem('Литература', 'page/literature.html'),
    ];
  }

  toString() {
    return '<ul><li>' + this.items.join('</li><li>') + '</li></ul>';
  }
}

document.addEventListener('DOMContentLoaded', event => {
  document.body.insertAdjacentHTML('afterbegin', '<div class="left">' + new Menu() + '</div>');
}, false);
