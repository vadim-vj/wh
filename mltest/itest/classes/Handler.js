import Geometry from './Handler/Geometry';
import AprInfo from './Handler/AprInfo';

export default class {
  constructor() {
    this.struct = [];
    this.threshold = 0.34;
  }

  getPos(x, y) {
    return (y * this.data.width + x) * 4;
  }

  getPixel(x, y, asInt = false) {
    const pos = this.getPos(x, y);
    let result = this.data.data.slice(pos, pos + 4);

    if (asInt) {
      if (result[3]) {
        result = /*(result[3] / 255) * */(0.299 * result[0] + 0.587 * result[1] + 0.114 * result[2]); // YUV & YIQ
        // result = (result[3] / 255) * (0.2126 * result[0] + 0.7152 * result[1] + 0.0722 * result[2]); // HDTV

      } else {
        result = 0;
      }
    }

    return result;
  }

  processImage(data) {
    this.data = data;

    console.log(this.getPixel(52, 178), this.getPixel(52, 178, true));
    /*for (let x = 0; x < this.data.width; x++) {
      for (let y = 0; y < this.data.height; y++) {
        const gray = this.getPixel(x, y, true), pos = this.getPos(x, y);

        for (let i = 0; i < 3; i++) {
          this.data.data[pos + i] = gray;
        }

        if (this.data.data[pos + 3]) {
          //this.data.data[pos + 3] = 255;
        }
      }
    }*/

    //return this.data;
  }

  processText(data) {
    const objects = [], i = 0, obj = '';

    do {
      if (data[i] - data[i + 1] > this.threshold) {
        objects.push(new Geometry(i, obj.length));

      } else {
        obj += data[i];
      }
    } while (i++ < data.length);

    this.struct.push(objects);
    console.log(data);
  }
}
