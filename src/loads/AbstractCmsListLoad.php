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

  use ngs\cms\dal\binparams\NgsCmsParamsBin;
  use ngs\cms\dal\dto\AbstractCmsDto;
  use ngs\cms\managers\AbstractCmsManager;

  abstract class AbstractCmsListLoad extends AbstractCmsLoad {

    protected $im_limit = 15;
    protected $im_pagesShowed = 12;

    /**
     * @var array
     */
    private $visibleFieldsMethods = ['getId' => ['type' => 'number'], 'display_name' => 'ID', 'data_field_name' => 'id'];

    /**
     * @param array $visibleFieldsMethods
     */
    public function setVisibleFieldsMethods(array $visibleFieldsMethods): void {
      $this->visibleFieldsMethods = $visibleFieldsMethods;
    }

    /**
     * @return array
     */
    public function getVisibleFieldsMethods(): array {
      return $this->visibleFieldsMethods;
    }

    /**
     * @return array
     */
    public function getCmsActions(): array {
      return ['edit', 'delete'];
    }


    /**
     * @param AbstractCmsDto $cmsDto
     */
    private function initializeVisibleFieldsMethods($cmsDto): void {
      $visibleFieldsMethods = $cmsDto->getVisibleFieldsMethods();
      if (count($visibleFieldsMethods)){
        $this->setVisibleFieldsMethods($visibleFieldsMethods);
      }
    }

    /**
     * returns js list page load
     * @return string
     */
    public abstract function getListLoad(): string;

    /**
     * returns js add page load
     * @return string
     */
    public abstract function getAddLoad(): string;

    /**
     * returns js edit page load
     * @return string
     */
    public abstract function getEditLoad(): string;

    /**
     * returns js main page load
     * @return string
     */
    public abstract function getMainLoad(): string;

    /**
     * returns js export load
     * @return string
     */
    public abstract function getExportLoad(): string;

    /**
     * returns js delete item action
     * @return string
     */
    public abstract function getDeleteAction(): string;

    public final function load() {
      $this->beforeLoad();
      $manager = $this->getManager();
      $itemDto = $manager->createDto();
      $this->initializeVisibleFieldsMethods($itemDto);
      $paramsBin = $this->getNgsListBinParams();
      $itemDtos = $manager->getList($paramsBin);
      $itemsCount = $manager->getItemsCount($paramsBin);
      $this->addParam('itemDtos', $itemDtos);
      $this->addParam('visibleFields', $this->getVisibleFieldsMethods());
      $this->addParam('actions', $this->getCmsActions());
      $this->addParam('itemDtosCount', $itemsCount);
      $this->addJsonParam('listLoad', $this->getListLoad());
      $this->addJsonParam('editLoad', $this->getEditLoad());
      $this->addJsonParam('mainLoad', $this->getMainLoad());
      $this->addJsonParam('exportLoad', $this->getExportLoad());
      $this->addJsonParam('activeMenu', $this->getActiveMenu());
      $this->addJsonParam('deleteAction', $this->getDeleteAction());
      $this->addJsonParam('bulkUpdateLoad', $this->getBulkUpdateLoad());
      $this->addSortingParams();
      if (NGS()->args()->parentId){
        $this->addJsonParam('parentId', NGS()->args()->parentId);
      }
      $this->initPaging($itemsCount);
      $jsParams = ['page' => $this->getCurrentPage(), 'limit' => $this->getLimit(), 'offset' => $this->getOffset(),
        'pagesShowed' => $this->getPagesShowed(), 'ordering' => strtolower($paramsBin->getOrderBy()),
        'sorting' => $paramsBin->getSortBy(), 'searchKey' => NGS()->args()->search_key];
      $this->addJsonParam('pageParams', $jsParams);
      $this->afterCmsLoad($itemDtos, $itemsCount);
    }

    /**
     *
     * set default list params bin
     *
     * @return NgsCmsParamsBin
     */

    private function getNgsListBinParams(): NgsCmsParamsBin {
      NGS()->args()->ordering = NGS()->args()->ordering ? NGS()->args()->ordering : 'DESC';
      NGS()->args()->sorting = NGS()->args()->sorting ? NGS()->args()->sorting : 'id';
      $joinCondition = $this->getJoinCondition();
      $paramsBin = new NgsCmsParamsBin();
      $paramsBin->setSortBy(NGS()->args()->sorting);
      $paramsBin->setOrderBy(NGS()->args()->ordering);
      $paramsBin->setLimit($this->getLimit());
      $paramsBin->setOffset($this->getOffset());
      $paramsBin->setJoinCondition($joinCondition);
      $paramsBin = $this->modifyNgsListBinParams($paramsBin);
      return $paramsBin;
    }

    /**
     *
     * modify already set params
     *
     * @param NgsCmsParamsBin $paramsBin
     * @return NgsCmsParamsBin
     */

    protected function modifyNgsListBinParams(NgsCmsParamsBin $paramsBin): NgsCmsParamsBin {
      return $paramsBin;
    }

    private function addSortingParams() {
      $this->addParam('sortingParam', [NGS()->args()->sorting => strtolower(NGS()->args()->ordering)]);
    }

    public function getBulkUpdateLoad() {
      return '';
    }

    /**
     * returns load default manager
     *
     * @return AbstractCmsManager
     */
    public abstract function getManager();


    public function getWhereCondition(): string {
      return '';
    }

    public function getJoinCondition(): string {
      return '';
    }

    protected function afterCmsLoad($itemDtos, $itemsCount): void {


    }

    protected function beforeLoad(): void {

    }

    /**
     * @return string
     */
    public function getTemplate(): string {
      return NGS()->getTemplateDir('ngs-cms') . '/list.tpl';
    }

  }

}
