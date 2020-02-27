import AbstractLoad from '../../AbstractLoad.js';
import DialogUtility from '../util/DialogUtility.js';
import PageManager from '../managers/PageManager.js';

export default class AbstractCmsLoad extends AbstractLoad {

  constructor() {
    super();
  }

  getMethod() {
    return "GET";
  }


  getContainer() {
    return "main_container";
  }

  onError(params) {
    DialogUtility.showErrorDialog(params.msg);
  }

  afterLoad() {
    this.modifyParentRedirect();
    this.initBreadCrumb();
    this.initSearch();
    this.afterCmsLoad();
  }

  afterCmsLoad() {

  }

  modifyParentRedirect() {
    if(!this.args().parentId){
      return;
    }
    let parentRedirect = $("#main_container").find(".f_redirect").last();
    if(parentRedirect.length){
      parentRedirect.attr("params", JSON.stringify({parentId: this.args().parentId}));
    }
  }

  onUnload() {
    let parentRedirect = $("#main_container").find(".f_redirect").last();
    parentRedirect.removeAttr("params")
  }

  initBreadCrumb() {
    let selector = '#' + this.getContainer() + ' .f_redirect';
    document.querySelectorAll(selector).forEach((elem) => {
      elem.addEventListener('click', (evt) => {
        let element = evt.currentTarget;
        let params = {};
        if(element.attr('params')){
          params = JSON.parse(element.attr('params'));
        }
        NGS.load(element.attr('data-im-load'), params);
      });
    });
  }

  initSearch() {
    let glbSearchElem = document.getElementById('glbSearch');
    if(!glbSearchElem){
      return glbSearchElem;
    }
    glbSearchElem.addEventListener('submit', evt => {
      evt.preventDefault();
      let searchKey = document.getElementById('searchKey').value.trim();
      if(searchKey.length < 1){
        return false;
      }
      let params = PageManager.getGlobalParams();
      params.searchKey = searchKey;
      NGS.load(this.args().mainLoad, params);
      return false;
    });
  }
}