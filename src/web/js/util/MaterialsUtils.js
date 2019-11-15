let MaterialsUtils = {
  modalInstance: null,
  initMaterialElements: function (container) {
    if(M.updateTextFields){
      M.updateTextFields();
    }
    let mTextAreas = $(".materialize-textarea");
    if(mTextAreas.length > 0){
      M.textareaAutoResize(mTextAreas);
    }
    M.FormSelect.init(document.querySelectorAll('select'));
    this.setTimeToPickers(container);
  },
  setTimeToPickers: function (container) {
    let datePickerElems = $('#' + container + ' .datepicker');
    if(datePickerElems.length > 0){
      datePickerElems.datepicker({
        container: document.getElementById('modalPiker'),
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 220, // Creates a dropdown of 15 years to control year,
        yearRange: 60,
        clear: 'Clear',
        close: 'Ok',
        format: 'd mmmm yyyy',
        setDefaultDate: true,
        closeOnSelect: false // Close upon selecting a date,
      });
    }

    let timepickerElems = $('#' + container + ' .timepicker');
    if(timepickerElems.length > 0){
      timepickerElems.timepicker({
        default: 'now',
        twelvehour: false, // change to 12 hour AM/PM clock from 24 hour
        donetext: 'OK',
        format: "HH:ii:SS",
        autoclose: false,
        vibrate: true
      });
    }
  },
  createCmsModal: function (title) {
    document.getElementById('modalTitie').innerHTML = title;
    let customDismissible = function (evt) {
      if(evt.key === "Escape"){
        this.modalInstance.close();
      }
      if(evt.key === "Enter"){
        ///his.modalInstance.close();
      }
    }.bind(this);
    this.modalInstance = M.Modal.getInstance(document.getElementById('modal'), {dismissible: false});
    this.modalInstance.options.dismissible = false;
    this.modalInstance.open();
    document.addEventListener('keyup', customDismissible);
    this.modalInstance.options.onCloseEnd = function () {
      document.removeEventListener('keyup', customDismissible);
      this.modalInstance = null;
    }.bind(this);
    return this.modalInstance;
  },
  getActiveModalInstance: function () {
    return this.modalInstance;
  }
};
export default MaterialsUtils;