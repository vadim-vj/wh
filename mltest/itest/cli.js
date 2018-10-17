const path = '/usr/local/lib/node_modules/';

require(path + 'babel-register')({ presets: [ path + 'babel-preset-env', ], });
const { JSDOM } = require(path + 'jsdom'), Canvas = require(path + 'canvas'), fs = require('fs');

fs.readFile('./index.html', (err, data) => {
  const jsdom = new JSDOM(data);

  global.window = jsdom.window;
  global.document = global.window.document;
  global.Image = Canvas.Image;

  module.exports = require('./index.js');
});

