<?php
/**
 * General parent load for all imusic.am admin load classes
 *
 * @author Levon Naghashyan
 * @site   http://naghashyan.com
 * @email  levon@naghashyan.com
 * @year   2012-2017
 * @package admin.loads.music
 * @version 6.5.0
 *
 **/

namespace ngs\cms\loads {

  use ngs\request\AbstractLoad;

  abstract class CmsAddUpdateLoad extends AbstractLoad {


    /**
     * @var array
     */
    private $addEditFieldsMethods = [];
    const NGS_CMS_EDIT_ACTION_TYPE_POPUP = "popup";
    const NGS_CMS_EDIT_ACTION_TYPE_INPLACE = "inplace";

    /**
     * @param array $visibleFieldsMethods
     */
    public function setAddEditFieldsMethods(array $visibleFieldsMethods): void {
      $this->addEditFieldsMethods = $visibleFieldsMethods;
    }

    /**
     * @return array
     */
    public function getAddEditFieldsMethods(): array {
      return $this->addEditFieldsMethods;
    }

    public function getTemplate() {
      return NGS()->getTemplateDir() . "/cms/add_update.tpl";
    }

    /**
     * returns get edit action type
     * @return string
     */
    public function getEditActionType(): string {
      return "";
    }

    public abstract function getManager();

    public abstract function getItemId();

    /**
     * returns js cancel load page
     * @return string
     */
    public abstract function getCancelLoad(): string;

    /**
     * returns js save item action
     * @return string
     */
    public abstract function getSaveAction(): string;

    /**
     * @param $cmsDto
     * @param string $type
     */
    private function initializeAddEditFieldsMethods($cmsDto, string $type): void {
      $visibleFieldsMethods = $cmsDto->getAddEditFieldsMethods($type);
      if (count($visibleFieldsMethods)){
        $this->setAddEditFieldsMethods($visibleFieldsMethods);
      }
    }

    public function getPossibleValuesForSelects($itemDto) {
      return [];
    }

    public final function load() {
      $manager = $this->getManager();

      $itemDto = null;
      $fieldsType = "add";
      if ($this->getItemId()){
        $itemDto = $manager->getItemById($this->getItemId());
        $fieldsType = "edit";
      }
      $this->initializeAddEditFieldsMethods($manager->createDto(), $fieldsType);
      $this->addParam("visibleFields", $this->getAddEditFieldsMethods());
      $this->addJsonParam("cancelLoad", $this->getCancelLoad());
      $this->addJsonParam("saveAction", $this->getSaveAction());
      $this->addJsonParam("limit", NGS()->args()->limit);
      $this->addJsonParam("page", NGS()->args()->page);
      $editActionType = $this->getEditActionType();
      if ($editActionType == self::NGS_CMS_EDIT_ACTION_TYPE_INPLACE){
        $editActionType = self::NGS_CMS_EDIT_ACTION_TYPE_INPLACE;
      } else{
        $editActionType = self::NGS_CMS_EDIT_ACTION_TYPE_POPUP;
      }
      if (NGS()->args()->parentId){
        $this->addJsonParam("parentId", NGS()->args()->parentId);
      }
      $this->addJsonParam("editActionType", $editActionType);
      $this->addParam("itemDto", $itemDto);
      $this->addParam("possibleValues", $this->getPossibleValuesForSelects($itemDto));
      $this->afterLoad($itemDto);
    }

    /**
     * get itemDto if itemId is set, if not, get null
     *
     * @param $itemDto
     */
    public function afterLoad($itemDto) {

    }

  }

}
