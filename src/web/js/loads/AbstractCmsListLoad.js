import AbstractLoad from '../../AbstractLoad.js';
import PagingManager from '../managers/PagingManager.js';
import GridManager from '../managers/GridManager.js';
import PageManager from '../managers/PageManager.js';
import DialogUtility from '../util/DialogUtility.js';
import MaterialsUtils from '../util/MaterialsUtils.js';
import AjaxLoader from "../../AjaxLoader.js";

export default class AbstractListLoad extends AbstractLoad {

  constructor() {
    super();
    this.sortingParams = {};
  }


  getContainer() {
    return "loadContent";
  }

  afterLoad() {
    PageManager.initPageParams(this.args().pageParams);
    if(this.getContainer() === "modal"){
      this.loadedDialog = MaterialsUtils.createCmsModal(this.getModalTitle());
    }
    GridManager.init(this.getContainer());
    this.initSearchBox();
    this.initPaging();
    this.initRemoveItem();
    this.initEditItem();
    this.initCheck();
    this.initDragAndDrop();
    this.afterCmsLoad();
    this.initSorting();
    this.initBulkUpdate();
    this.initFilters();
  }

  initSearchBox() {
    if(this.args().searchKey){
      $("#searchKey").val(this.args().searchKey);
      if(M.updateTextFields){
        M.updateTextFields();
      }
    }
  }


  onError(params) {
    DialogUtility.showErrorDialog(params.msg);
  }

  initEditItem() {
    document.querySelectorAll('#itemsContent .f_edit_btn').click(event => {
      let itemId = event.currentTarget.attr('data-im-id');
      let params = this._getNgsParams();
      params.itemId = itemId;
      NGS.load(this.args().editLoad, params);
    });
  }

  initRemoveItem() {
    $('#' + this.getContainer() + ' .f_delete_btn').on("click", function (evt) {
      evt.stopPropagation();
      DialogUtility.showConfirmDialog("Delete Confirmation", "Do you want to remove this item ? This item can be used in other places.").then(function () {
        var elem = $(evt.target).closest(".f_delete_btn");
        var itemId = elem.attr('data-im-id');

        var listFilterParams = PageManager.getListFilteringParams();
        var additionalParams = this.getAdditionalParams();
        if(additionalParams){
          for (var i in additionalParams) {
            if(additionalParams.hasOwnProperty(i)){
              listFilterParams[i] = additionalParams[i];
            }
          }
        }
        listFilterParams.page = +$("#pageBox").find(".waves-effect.active a").html();

        NGS.action(this.args().deleteAction, {itemId: itemId, listFilterParams: listFilterParams});
      }.bind(this)).catch(function () {
        console.log("canceled");
      });
    }.bind(this));
  }

  initCheck() {
    $("#" + this.getContainer() + " .f_check").on("click", function (evt) {
      evt.stopPropagation();
    });
  }


  initPaging() {
    PagingManager.init((args) => {
      let params = Object.assign(this._getNgsParams(), args);
      NGS.load(this.args().mainLoad, params);
    });
  }

  initSorting() {
    document.querySelectorAll("#gridHeader .f_sorting").forEach((sortableElem) => {
      sortableElem.addEventListener('click', evt => {
        let order = 'desc';
        let sortBy = evt.currentTarget.attr('data-im-sorting');
        if(evt.currentTarget.attr('data-im-order') === 'desc'){
          order = 'asc';
        }
        let params = PageManager.getPageParams();
        params.ordering = order;
        params.sorting = sortBy;
        NGS.load(this.args().mainLoad, params);
      });
    });
  }

  initBulkUpdate() {
    this._initCheckBoxChecking();
    this.bulkUpdateLoad();
  }

  bulkUpdateLoad() {
    $("#doBulkAction").click(function () {
      if(!this.args().bulkUpdateLoad){
        return false;
      }
      if(!this._getSelectedItemsIds().length){
        DialogUtility.showErrorDialog("please select items");
        return false;
      }
      var params = {item_ids: this._getSelectedItemsIds()};
      if(this.args().parentId){
        params.parentId = this.args().parentId;
      }
      NGS.load(this.args().bulkUpdateLoad, params);
    }.bind(this));
  }

  _initCheckBoxChecking() {
    var container = $("#" + this.getContainer());
    container.find(".f_checkbox-item").on("change", function (evt) {
      var checked = evt.delegateTarget.checked;
      if(checked){
        var allAreChecked = true;
        var allCheckboxes = container.find(".f_checkbox-item");
        for (var i = 0; i < allCheckboxes.length; i++) {
          if(!$(allCheckboxes[i]).is(":checked")){
            allAreChecked = false;
          }
        }
        if(allAreChecked){
          $("#" + this.getContainer()).find(".f_checkbox-item-main").prop('checked', true);
        } else{
          $("#" + this.getContainer()).find(".f_checkbox-item-main").prop('checked', false);
        }
      } else{
        $("#" + this.getContainer()).find(".f_checkbox-item-main").prop('checked', false);
      }
    }.bind(this));

    container.find(".f_checkbox-item-main").on("change", function (evt) {
      var checked = evt.delegateTarget.checked;
      var allCheckboxes = container.find(".f_checkbox-item");
      for (var i = 0; i < allCheckboxes.length; i++) {
        $(allCheckboxes[i]).prop('checked', checked)
      }
    }.bind(this));
  }

  getAdditionalParams(params) {
    return params;
  }

  _getSelectedItemsIds() {
    var result = [];
    var container = $("#" + this.getContainer());
    var allCheckboxes = container.find(".f_checkbox-item");
    for (var i = 0; i < allCheckboxes.length; i++) {
      var checkbox = $(allCheckboxes[i]);
      if(checkbox.is(":checked")){
        result.push(checkbox.closest(".f_table-row").attr("data-im-id"));
      }
    }
    return result;
  }


  initFilters() {
    MaterialsUtils.initMaterialElements('cmsFilterBox');
    $("#filterBtn").click(function () {
      let params = $('#cmsFilterBox').serializeObject();
      NGS.load(this.args().mainLoad, {filterParams: params});
      return false;
    }.bind(this));
  }

  getFilterParams() {
    if(this.args().filterParams){
      return {filterParams: this.args().filterParams};
    }
    return {};
  }

  _getNgsParams() {
    let params = {};
    params = Object.assign(params, PageManager.getPageParams());
    params = Object.assign(this.getFilterParams(), params);
    params = this.getAdditionalParams(params);
    if(this.args().parentId){
      params.parentId = this.args().parentId;
    }
    return params;
  }

  getModalTitle() {
    return 'modal';
  }

  afterCmsLoad() {

  }

  getMethod() {
    return "GET";
  }

  getPermalink() {
    return super.getPermalink();
  }

  initDragAndDrop() {

  }

}