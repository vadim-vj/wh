import AFrame from './AFrame';

export default class extends AFrame {
  constructor(string) {
    super();

    this.string = string;
  }

  show() {
    document.querySelector('div#data').insertAdjacentHTML('afterbegin', '<div>' + this.string + '</div>');

    return super.show();
  }

  process(handler) {
    handler.processText(this.string);
  }
}