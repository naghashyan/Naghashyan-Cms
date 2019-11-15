import AbstractAction from "../../AbstractAction.js";
import DialogUtility from '../../../ngs/cms/util/DialogUtility.js';

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
    DialogUtility.showErrorDialog(params.msg);
  }


  afterAction(transport) {
    let dialog = $("#modal");
    if(dialog && dialog.length){
      dialog.dialog();
      dialog.dialog("close");
    }
    NGS.load(this.args().afterActionLoad, this.args().afterActionParams);
  }

}