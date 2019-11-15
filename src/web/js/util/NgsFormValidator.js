import _ngsFormValidator from '../../util/NgsFormValidator.js';

let NgsFormValidator = function (formElement, options) {
  let _options = {
    showError: function (elem, msg) {
      _options.hideError(elem);
      elem.addClass('invalid');
      elem.addClass('ngs');
      elem.parentNode.insertAdjacentHTML('beforeend', "<div class='ilyov_validate'>" + msg + "</div>");
    },
    hideError: function (elem) {
      elem.removeClass('invalid');
      elem.addClass('ngs');
      let errorElement = elem.parentNode.getElementsByClassName('ilyov_validate');
      if(errorElement.length === 0){
        return;
      }
      errorElement[0].remove();
    }
  };
  options = Object.assign(_options, options);
  return _ngsFormValidator(formElement, options);
};
export default NgsFormValidator;