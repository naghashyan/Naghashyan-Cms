import MaterialDatetimePicker from '../lib/material-datetime-picker.min.js';
import M from '../lib/materialize.min.js';

let MaterialsUtils = {
  modalInstance: null,
  initMaterialElements: function (container) {
    M.Toast.dismissAll();
    if(M.updateTextFields){
      M.updateTextFields();
    }
    let mTextAreas = document.querySelectorAll(".materialize-textarea");
    if(mTextAreas.length > 0){
      M.textareaAutoResize(mTextAreas);
    }
    M.FormSelect.init(document.querySelectorAll('select'), {gago: null});
    this.setTimeToPickers(container);
    this.initVerticalTabs(container);
  },
  setTimeToPickers: function (container) {
    let datePickerElems = document.querySelectorAll('#' + container + ' .datepicker');
    if(datePickerElems.length > 0){
      let datePickerInstances = M.Datepicker.init(datePickerElems, {
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

    let timepickerElems = document.querySelectorAll('#' + container + ' .timepicker');
    if(timepickerElems.length > 0){
      let timepickerInstances = M.Timepicker.init(timepickerElems, {
        default: 'now',
        twelveHour: false, // change to 12 hour AM/PM clock from 24 hour
        donetext: 'OK',
        format: "HH:ii:SS",
        autoClose: false,
        vibrate: true
      });
    }
    var datatimepickerElems = document.querySelectorAll('#' + container + ' .datetimepicker');
    if(datatimepickerElems.length > 0){
      const picker = new MaterialDatetimePicker()
        .on('open', function () {
          $('body').addClass("no-scroll");
        })
        .on('close', function () {
          $('body').removeClass("no-scroll");
        })
        .on('submit', function (val) {
          this.el.value = val.format('D MMMM YYYY HH:mm:SS');
        });

      datatimepickerElems.click(function (evt) {
        picker.el = evt.currentTarget;
        picker.open() || picker.set(moment().startOf('day'));
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
      M.Toast.dismissAll();
    }.bind(this);
    return this.modalInstance;
  },
  initVerticalTabs: function (container) {
    if(!document.querySelector('#' + container + ' .f_cms_vertical-tabs')){
      return;
    }
    let instance = M.Tabs.init(document.querySelectorAll('#' + container + ' .f_cms_vertical-tabs'), {
      onShow: function () {
        let containerElement = this.$activeTabLink[0].closest('.f_cms_vertical-tabs');
        let activeElement = this.$activeTabLink[0];
        let indicator = containerElement.querySelector('.indicator');
        indicator.style.top = (activeElement.getBoundingClientRect().top - containerElement.getBoundingClientRect().top) + 'px';
      }
    });
  },
  showVerticalTabsError: function (tabsArr, tabsElement) {
    let instance = M.Tabs.getInstance(tabsElement);
    let currentIndex = instance.index;
    if(tabsArr[currentIndex]){
      return;
    }
    let tabsIds = Object.keys(tabsArr);
    instance.select(tabsArr[tabsIds[0]]);
  },
  getActiveModalInstance: function () {
    return this.modalInstance;
  },
  showErrorDialog: function (msg) {
    M.toast({html: msg, displayLength: 2500, classes: 'ngs-error-toast'})
  },

  showSuccessDialog: function (msg) {
    M.toast({html: msg, displayLength: 2500, classes: 'ngs-success-toast'})
  },
  confirmDialog: function (title = '') {
    if(title === ''){
      title = 'Are you sure?';
    }
    return new Promise(function (resolve, reject) {

      let cancel = function () {
        M.Toast.dismissAll();
        reject();
      };
      let okHandler = function () {
        resolve();
        M.Toast.dismissAll();
      };
      let toastContent = `<div><span>${title}</span>
                        <button class="btn-flat toast-action red-text f_btn" data-im-type="yes">Yes</button>
                        <button class="btn-flat toast-action green-text f_btn" data-im-type="no">No</button></div>`;
      M.toast({
        html: toastContent,
        displayLength: 10000,
        classes: 'cms-dialog'
      }).el.querySelectorAll(".f_btn").click(function () {
        if(this.attr("data-im-type") === 'yes'){
          okHandler();
          return;
        }
        cancel();
      });
    });


  }
};
export default MaterialsUtils;