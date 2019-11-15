/**
 * DialogUtility helper util
 * for showing custom notifications
 *
 * @author Levon Naghashyan
 * @site https://naghashyan.com
 * @mail levon@naghashyan.com
 * @year 2015-2019
 */



let DialogUtility = {

  openStatus: false,
  dialogTypeClass: "",
  dialogLayoutClass: "",
  timeoutId: -1,
  initialize: function () {
    this.dialogElem = $("#im_dialog");
    this.dialogElemBox = this.dialogElem.find(".f_im_dialog_box");
    this.titleElem = $("#im_dialogTitle");
    this.contentTextElem = $("#im_dialogContent");
    this.okBtn = this.dialogElem.find(".f_im_ok_btn");
    this.cancelBtn = this.dialogElem.find(".f_im_cancel_btn");
  },
  /**
   * Default options
   * it can be overrided in each public method
   * of this object
   */
  options: {
    openAnimation: "animationOn fadeIn",// for more animation options see on nimate.css or http://daneden.github.io/animate.css/
    closeAnimation: "fadeOut",// for more animation options see on nimate.css or http://daneden.github.io/animate.css/
    layout: "center",// top, topLeft, topCenter, topRight, centerLeft, center, centerRight, bottomLeft, bottomCenter, bottomRight, bottom
    timeout: 2000,
    overlay: false,
    type: "success",//success, error, warning, confirm, alert, custom
    customTpl: "",
    okBtnText: "ok",
    cancelBtnText: "cancel",
    closeAfterOk: true,
    onOpen: NGS.emptyFunction
  },
  /**
   * Method for showing Info notification
   *
   * @param  title:String
   * @param  txt:String
   * @param  options:Object
   *
   */
  showInfoDialog: function (title, txt, options) {
    return this._showDialog(title, txt, "info", options);
  },
  /**
   * Method for showing Alert notification
   *
   * @param  title:String
   * @param  txt:String
   * @param  options:Object
   *
   */
  showAlertDialog: function (title, txt, options) {
    return this._showDialog(title, txt, "alert", options);
  },
  /**
   * Method for showing Error notification
   *
   * @param  title:String
   * @param  txt:String
   * @param  options:Object
   *
   */
  showErrorDialog: function (title, txt, options) {
    return this._showDialog(title, txt, "error", options);
  },
  /**
   * Method for showing success notification
   *
   * @param  title:String
   * @param  txt:String
   * @param  options:Object
   *
   */
  showSuccessDialog: function (title, txt, options) {
    return this._showDialog(title, txt, "success", options);
  },
  /**
   * Method for showing warning notification
   *
   * @param  title:String
   * @param  txt:String
   * @param  options:Object
   *
   */
  showWarningDialog: function (title, txt, options) {
    return this._showDialog(title, txt, "warning", options);
  },
  /**
   * Method for showing confirm dialog
   *
   * @param  title:String
   * @param  txt:String
   * @param  options:Object
   *
   */
  showConfirmDialog: function (title, txt, options) {
    if(!options){
      options = {overlay: true};
    }
    return this._showDialog(title, txt, "confirm", options);
  },
  /**
   * Method for showing Noty notifications
   *
   * @param  title:String
   * @param  txt:String
   * @param  type:String
   * @param  options:Object
   *
   */
  _showDialog: function (title, txt, type, options) {
    if(this.openStatus){
      this.closeDialog();
    }
    if(this.timeoutId >= 0){
      window.clearTimeout(this.timeoutId);
    }

    this.openStatus = true;
    this._options = null;
    const _options = Object.assign({}, this.options);
    this._options = Object.assign(_options, options);
    this.dialogElem.removeClass("im-dialog-overlay");
    if(this._options.overlay){
      this.dialogElem.addClass("im-dialog-overlay");
    }
    this.dialogTypeClass = "im-dialog-" + type;
    this.dialogLayoutClass = "im-dialog-" + this._options.layout;
    this.dialogElem.addClass(this.dialogTypeClass);
    this.dialogElem.addClass(this.dialogLayoutClass);
    this.titleElem.html(title);
    this.contentTextElem.html(txt);
    this.okBtn.val(this._options.okBtnText);
    this.cancelBtn.val(this._options.cancelBtnText);
    this.dialogElem.removeClass(this._options.closeAnimation);
    this.dialogElem.addClass(this._options.openAnimation);
    return new Promise(function (resolve, reject) {
      document.getElementById("im_dialogOverlay").onclick = function () {
        console.log("click");
        if(this.timeoutId >= 0){
          window.clearTimeout(this.timeoutId);
        }
        this.closeDialog();
        reject();
      }.bind(this);
      if(type !== "alert" && type !== "confirm"){
        this.timeoutId = setTimeout(function () {
          this.closeDialog();
        }.bind(this), this._options.timeout);
      }
      this.dialogElem.find(".f_im_dialog_close").click(function () {
        document.getElementById("im_dialogOverlay").onclick = function () {
          this.closeDialog();
        }.bind(this);
        this.closeDialog();

      }.bind(this));
      this.okBtn.unbind("click");
      this.okBtn.click(function () {
        this.closeDialog();
        resolve(true);
      }.bind(this));
    }.bind(this));

  },
  openCustomModal: function (options) {
    if(this.openStatus){
      this.closeDialog(true);
      if(this.timeoutId >= 0){
        window.clearTimeout(this.timeoutId);
      }
    }
    this.openStatus = true;
    const _options = Object.assign({}, this.options);
    this._options = Object.assign(_options, options);
    this.dialogElem.removeClass("im-dialog-overlay");
    if(this._options.overlay){
      this.dialogElem.addClass("im-dialog-overlay");
    }
    this.dialogElem.addClass("im-dialog-custom");
    this.dialogLayoutClass = "im-dialog-" + this._options.layout;
    this.dialogElem.addClass(this.dialogLayoutClass);
    this.dialogElem.removeClass(this._options.closeAnimation);
    this.dialogElem.addClass(this._options.openAnimation);
    this.titleElem.html(this._options.title ? this._options.title : "");
    this.contentTextElem.html(this._options.customTpl ? this._options.customTpl : "");
    this.dialogElem.click(function (evt) {
      evt.stopPropagation();
    });
    return new Promise(function (resolve, reject) {
      document.getElementById("im_dialogOverlay").onclick = function (evt) {
        evt.stopPropagation();
        resolve(null);
        this.closeDialog();
      }.bind(this);
      this.okBtn.unbind("click");
      const confirmForm = $("#confirmData");
      confirmForm.on("submit", function () {
        this.okBtn.trigger("click");
        return false;
      }.bind(this));
      this.okBtn.click(function () {
        const confirmForm = $("#confirmData");
        if(confirmForm && confirmForm.length){
          resolve(confirmForm.serializeObject());
        } else{
          resolve(null);
        }
        if(this._options.closeAfterOk){
          this.closeDialog();
        }
      }.bind(this));
      this.dialogElem.find(".f_im_dialog_close").click(function () {
        resolve(null);
        this.closeDialog();
      }.bind(this));
    }.bind(this));
  },

  closeDialog: function (custom, closeTime) {
    if(!this.openStatus){
      return;
    }
    this.dialogElem.removeClass(this._options.openAnimation);
    this.dialogElem.addClass(this._options.closeAnimation);
    this.openStatus = false;
    this.dialogElem.removeClass(this.dialogLayoutClass);
    this.dialogElem.removeClass(this.dialogTypeClass);
    this.dialogElem.removeClass("im-dialog-overlay");
    this.dialogElem.removeClass("im-dialog-custom");
    this.openStatus = false;
    if(!custom){
      $("#im_dialogContainer").html("");
    }


  }
};
document.onreadystatechange = () => {
  if(document.readyState === 'complete'){
    DialogUtility.initialize();
  }
};
if(document.readyState === 'complete'){
  DialogUtility.initialize();
}

export default DialogUtility;