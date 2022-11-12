var Emitter = require('tiny-emitter');
export const Bus = window.Bus = new Emitter();

const $on = function (eventName, callback) {
  window.Bus.off(`on-${eventName}`);
  window.Bus.on(`on-${eventName}`, callback);
};

const $emit = function (eventName, ...args) {
  window.Bus.emit(`on-${eventName}`, ...args);
};

export {
  $on,
  $emit
}
