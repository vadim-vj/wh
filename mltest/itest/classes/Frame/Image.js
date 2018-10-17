import AFrame from './AFrame';

export default class extends AFrame {
  constructor(base, id, ext = 'png') {
    super();

    this.src = base + '/' + id + '.' + ext;
    this.initCanvas();
  }

  initCanvas(canvas) {
    this.canvas = canvas || document.createElement('canvas');
    this.context = this.canvas.getContext('2d');
  }

  show(canvas) {
    if (canvas) {
      this.initCanvas(canvas);
    }

    const img = new Image();
    img.onload = () => {
      for (let dim of ['width', 'height']) {
        this.canvas[dim] = img[dim];
      }

      this.context.drawImage(img, 0, 0);
      this.canvas.classList.add('loaded');
    }

    img.src = this.src;
    document.querySelector('div#data').appendChild(this.canvas);

    return super.show();
  }

  process(handler) {
    handler.processImage(this.context.getImageData(0, 0, this.canvas.width, this.canvas.height));
  }
}