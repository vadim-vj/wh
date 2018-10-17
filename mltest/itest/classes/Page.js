import Handler from './Handler';

export default class {
  constructor(data) {
    this.handler = new Handler();

    for (let frame of data.getFrames()) {
      frame.show().process(this.handler);
    }

    console.log(this.handler.struct);
  }
}
