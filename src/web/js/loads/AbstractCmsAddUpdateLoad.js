import AbstractLoad from '../../AbstractLoad.js';
import GridManager from '../managers/GridManager.js';
import PageManager from '../managers/PageManager.js';
import DialogUtility from '../util/DialogUtility.js';
import MaterialsUtils from '../util/MaterialsUtils.js';
import NgsFormValidator from '../util/NgsFormValidator.js';

export default class AbstractCmsAddUpdateLoad extends AbstractLoad {

  constructor() {
    super();
  }


  getContainer() {
    if(this.args().editActionType === "popup"){
      return "modal";
    }
    return "loadContent";
  }

  onError(params) {
    DialogUtility.showErrorDialog(params.msg);
  }

  getModalTitle() {
    let title = "";
    if(this.args().saveAction){
      let actionPath = this.args().saveAction.split(".");
      let actionName = actionPath[actionPath.length - 1].split("_").join(" ");
      title = actionName.replace(/\b[a-z]/g,
        function (firstLatter) {
          return firstLatter.toUpperCase();
        })
    }
    return title;
  }

  afterLoad() {
    this.loadedDialog = null;
    if(this.getContainer() === "modal"){
      this.loadedDialog = MaterialsUtils.createCmsModal(this.getModalTitle());
    }
    MaterialsUtils.initMaterialElements(this.getContainer());
    GridManager.init(this.getContainer());
    this.doCancelAction();
    this.modifyParentRedirect();
    this.doSaveItem();
    this.afterCmsLoad();
    this.hideHeaderAddButton();
  }


  modifyParentRedirect() {
    if(Object.keys(this.setCancelParams()).length){
      var parentRedirect = $("#main_container").find(".f_redirect").last();
      if(parentRedirect.length){
        parentRedirect.attr("params", JSON.stringify(this.setCancelParams()));
      }
    }
  }

  doCancelAction() {
    document.querySelectorAll("#" + this.getContainer() + " .f_cancel").click(event => {
      if(this.loadedDialog){
        this.loadedDialog.close();
        return;
      }
      NGS.load(this.args().cancelLoad, this.setCancelParams());
    });
  }

  setCancelParams() {
    return {};
  }

  hideHeaderAddButton() {
    //$('#addItem').addClass('is_hidden');
  }

  doSaveItem() {
    document.getElementById("addUpdateForm").onsubmit = function (event) {
      return false;
    };
    document.querySelectorAll("#" + this.getContainer() + " #saveItem").click(event => {
      let formElem = document.getElementById('addUpdateForm');
      let validationStatus = NgsFormValidator(formElem);
      if(!validationStatus){
        return false;
      }
      let formData = new FormData(formElem);
      formData = this.beforeSave(formData);
      if(this.args().parentId){
        formData.append('parentId', this.args().parentId);
      }
      formData = this._mergeWithPageParams(formData);
      NGS.action(this.args().saveAction, formData, () => {
        if(this.loadedDialog){
          this.loadedDialog.close();
        }
      });
    });
  }

  /**
   *
   * @param params FormData
   * @returns {*}
   */
  _mergeWithPageParams(params) {
    let listingParams = PageManager.getGlobalParams();
    for (let i in listingParams) {
      if(listingParams.hasOwnProperty(i) && !params[i]){
        params.set('pageParams[' + i + ']', listingParams[i]);
      }
    }
    return params;
  }

  /**
   *
   * should return FormData
   *
   * @param formData FormData
   *
   * @returns FormData
   */
  beforeSave(formData) {
    return formData;
  }

  onUnLoad() {
    document.querySelector('#addItem').removeClass('is_hidden');
  }

  afterCmsLoad() {

  }

  getMethod() {
    return "GET";
  }

}