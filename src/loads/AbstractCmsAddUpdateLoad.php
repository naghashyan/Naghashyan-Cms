<?php
/**
 * General parent load for all
 * cms add and update(edit) loads
 *
 * @author Levon Naghashyan
 * @site   https://naghashyan.com
 * @email  levon@naghashyan.com
 * @year   2012-2020
 * @package ngs.cms.loads
 * @version 2.0.0
 * @copyright Naghashyan Solutions
 *
 **/

namespace ngs\cms\loads {


  abstract class AbstractCmsAddUpdateLoad extends AbstractCmsLoad {


    /**
     * @var array
     */
    private array $addEditFieldsMethods = [];
    public const NGS_CMS_EDIT_ACTION_TYPE_POPUP = 'popup';
    public const NGS_CMS_EDIT_ACTION_TYPE_INPLACE = 'inplace';

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
      $result = [];
      foreach ($this->addEditFieldsMethods as $key => $addEditFieldMethod){
        $result[$addEditFieldMethod['tab']][$addEditFieldMethod['group_name']][$key] = $addEditFieldMethod;
      }
      return $result;
    }

    public function getTemplate(): string {
      return NGS()->getTemplateDir('ngs-cms') . '/add_update.tpl';
    }

    /**
     * returns get edit action type
     * @return string
     */
    public function getEditActionType(): string {
      return '';
    }

    abstract public function getManager();

    abstract public function getItemId(): int;

    /**
     * returns js cancel load page
     * @return string
     */
    abstract public function getCancelLoad(): string;

    /**
     * returns js save item action
     * @return string
     */
    abstract public function getSaveAction(): string;

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

    public function getPossibleValuesForSelects($itemDto): array {
      return [];
    }

    public final function load(): void {
      $manager = $this->getManager();
      $itemDto = null;
      $fieldsType = 'add';
      if ($this->getItemId()){
        $itemDto = $manager->getItemById($this->getItemId());
        $fieldsType = 'edit';
      }
      $this->initializeAddEditFieldsMethods($manager->createDto(), $fieldsType);
      $visibleFields = $this->getAddEditFieldsMethods();
      $this->addParam('ngsTabs', array_keys($visibleFields));
      $this->addParam('visibleFields', $this->getAddEditFieldsMethods());
      $this->addJsonParam('cancelLoad', $this->getCancelLoad());
      $this->addJsonParam('saveAction', $this->getSaveAction());
      $editActionType = $this->getEditActionType();
      if ($editActionType === self::NGS_CMS_EDIT_ACTION_TYPE_INPLACE){
        $editActionType = self::NGS_CMS_EDIT_ACTION_TYPE_INPLACE;
      } else{
        $editActionType = self::NGS_CMS_EDIT_ACTION_TYPE_POPUP;
      }
      if (NGS()->args()->parentId){
        $this->addJsonParam('parentId', NGS()->args()->parentId);
      }
      $this->addJsonParam('editActionType', $editActionType);
      $this->addParam('itemDto', $itemDto);
      $this->addParam('possibleValues', $this->getPossibleValuesForSelects($itemDto));
      $jsParams = ['itemId' => NGS()->args()->itemId, 'parentId' => NGS()->args()->parentId,
        'page' => $this->getCurrentPage(), 'limit' => $this->getLimit(), 'offset' => $this->getOffset(),
        'pagesShowed' => $this->getPagesShowed(), 'ordering' => NGS()->args()->ordering,
        'sorting' => NGS()->args()->sorting, 'searchKey' => NGS()->args()->searchKey];
      $this->addJsonParam('pageParams', $jsParams);
      $this->afterCmsLoad($itemDto);
    }

    /**
     * after cms loaded
     *
     * @return void
     */
    public function afterCmsLoad($itemDto): void {

    }

  }

}
