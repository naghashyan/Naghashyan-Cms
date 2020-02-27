import AbstractAction from "../../AbstractAction.js";
import DialogUtility from '../../../ngs/cms/util/DialogUtility.js';
import MaterialsUtils from "../util/MaterialsUtils.js";

export default class AbstractDeleteAction extends AbstractAction {

  constructor() {
    super();
  }

  getParamsIn() {
    return 'formData';
  }

  getMethod() {
    return "POST";
  }

  onError(params) {
    M.toast({html: params.msg, displayLength: 2500, classes: 'ngs-error-toast'})
  }


  afterAction() {
    if(MaterialsUtils.getActiveModalInstance()){
      MaterialsUtils.getActiveModalInstance().close();
    }
    NGS.load(this.args().afterActionLoad, this.args().afterActionParams);
  }

}