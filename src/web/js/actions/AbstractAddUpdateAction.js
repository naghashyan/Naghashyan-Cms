import AbstractAction from '../../AbstractAction.js';
import MaterialsUtils from "../util/MaterialsUtils.js";

export default class AbstractAddUpdateAction extends AbstractAction {

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
    M.toast({html: params.msg, displayLength: 1500, classes: 'ngs-error-toast'})
  }

  beforeAction() {
  }

  afterAction(transport) {
    if(MaterialsUtils.getActiveModalInstance()){
      MaterialsUtils.getActiveModalInstance().close();
    }
    NGS.load(this.args().afterActionLoad, this.args().afterActionParams);
  }

}