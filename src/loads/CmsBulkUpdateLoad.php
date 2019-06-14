<?php
/**
 * General parent load for all imusic.am admin bulk load classes
 *
 * @author Mikael Mkrtchyan
 * @site   http://naghashyan.com
 * @email  mikael.mkrtchyan@naghashyan.com
 * @year   2018
 * @package admin.loads
 * @version 7.0
 *
 **/

namespace ngs\cms\loads {

  use ngs\exceptions\NgsErrorException;

  abstract class CmsBulkUpdateLoad extends AbstractCmsLoad {


    const NGS_CMS_EDIT_ACTION_TYPE_POPUP = "popup";
    const NGS_CMS_EDIT_ACTION_TYPE_INPLACE = "inplace";


    public function getTemplate() {
      return NGS()->getTemplateDir() . "/cms/bulk_update.tpl";
    }

    /**
     * returns get edit action type
     * @return string
     */
    public function getEditActionType(): string {
      return "";
    }

    /**
     * @return int|\ngs\request\babyclass|void
     * @throws NgsErrorException
     */
    public final function load() {
      if (!NGS()->args()->item_ids){
        throw new NgsErrorException("Items not selected.");
      }
      $editActionType = $this->getEditActionType();
      if ($editActionType == self::NGS_CMS_EDIT_ACTION_TYPE_POPUP){
        $editActionType = self::NGS_CMS_EDIT_ACTION_TYPE_POPUP;
      } else{
        $editActionType = self::NGS_CMS_EDIT_ACTION_TYPE_INPLACE;
      }
      $this->addJsonParam("editActionType", $editActionType);
      $this->addParam("itemIds", NGS()->args()->item_ids);
      $this->addJsonParam("cancelLoad", $this->getCancelLoad());
      if (NGS()->args()->parentId){
        $this->addJsonParam("parentId", NGS()->args()->parentId);
      }

      $this->addJsonParam("saveAction", $this->getSaveAction());

      $this->afterCmsLoad();
    }

    public abstract function getCancelLoad(): string;

    public abstract function getSaveAction(): string;

    /**
     * called after load
     */
    public function afterCmsLoad() {

    }

  }

}
