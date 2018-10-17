import ADataSource from './ADataSource';
import Frame from '../Frame/Text';

export default class extends ADataSource {
  constructor() {
    super();
    this.size = 120;
    this.fill = '0';
    this.char = '1';

    this.strings = [
      // 'The quick brown fox jumps over the lazy dog',
      this.initString(30, 4),
      this.initString(20, 4),
    ];
  }

  initString(start, count, length = this.size, fill = this.fill, replacer = this.char) {
    return fill.repeat(length).replace(new RegExp('(.{' + start + '}).{' + count + '}'), '$1' + replacer.repeat(count));
  }

  getFrames() {
    const frames = super.getFrames();

    for (let string of this.strings) {
      frames.push(new Frame(string));
    }

    return frames;
  }
}