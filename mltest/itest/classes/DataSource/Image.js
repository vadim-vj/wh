import ADataSource from './ADataSource';
import Frame from '../Frame/Image';

export default class extends ADataSource {
  getFrames() {
    const frames = super.getFrames();

    for (let i = 1; i <= 2; i++) {
      frames.push(new Frame('data/image', i));
    }

    return frames;
  }
}