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

  use ngs\cms\dal\dto\AbstractCmsDto;
  use ngs\cms\managers\AbstractCmsManager;
  use ngs\request\AbstractLoad;

  abstract class AbstractCmsListLoad extends AbstractLoad {

    protected $im_limit = 15;
    protected $im_pagesShowed = 12;

    /**
     * @var array
     */
    private $visibleFieldsMethods = ["getId" => ["type" => "number"], "display_name" => "ID", "data_field_name" => "id"];

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
      return ["edit", "delete"];
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
     * returns js delete item action
     * @return string
     */
    public abstract function getDeleteAction(): string;

    public final function load() {
      $this->beforeLoad();
      $manager = $this->getManager();
      $this->initializeVisibleFieldsMethods($manager->createDto());
      NGS()->args()->ordering = NGS()->args()->ordering ? NGS()->args()->ordering : "DESC";
      NGS()->args()->sorting = NGS()->args()->sorting ? NGS()->args()->sorting : "id";
      NGS()->args()->artistId = NGS()->args()->artistId ? NGS()->args()->artistId : null;
      $whereCondition = $this->getNgsWhereCondition();
      $joinCondition = $this->getJoinCondition();

      $itemDtos = $manager->getList(NGS()->args()->sorting, NGS()->args()->ordering, $this->getLimit(),
        $this->getOffset(), NGS()->args()->artistId, $whereCondition, $joinCondition);
      $itemsCount = $manager->getItemsCount($whereCondition, $joinCondition);
      $this->addParam("itemDtos", $itemDtos);
      $this->addParam("visibleFields", $this->getVisibleFieldsMethods());
      $this->addParam("actions", $this->getCmsActions());
      $this->addParam("itemDtosCount", $itemsCount);
      $this->addJsonParam("listLoad", $this->getListLoad());
      $this->addJsonParam("editLoad", $this->getEditLoad());
      $this->addJsonParam("mainLoad", $this->getMainLoad());
      $this->addJsonParam("activeMenu", $this->getActiveMenu());
      $this->addJsonParam("deleteAction", $this->getDeleteAction());
      $this->addJsonParam("bulkUpdateLoad", $this->getBulkUpdateLoad());
      $this->addSortingParams();
      if (NGS()->args()->parentId){
        $this->addJsonParam("parentId", NGS()->args()->parentId);
      }
      if (NGS()->args()->search_key){
        $this->addJsonParam("searchKey", NGS()->args()->search_key);
      }
      $this->addJsonParam("cms_manager", json_encode($this->getManager()));

      $this->initPaging($itemsCount);

      $this->afterLoad($itemDtos, $itemsCount);
    }

    private function addSortingParams() {
      $this->addParam("sortingParam", [NGS()->args()->sorting => strtolower(NGS()->args()->ordering)]);
    }

    public function getBulkUpdateLoad() {
      return "";
    }


    public abstract function getManager();

    private function getNgsWhereCondition(): string {
      if ($this->getWhereCondition() != ""){
        return " WHERE " . $this->getWhereCondition();
      }
      return "";
    }

    public function getWhereCondition(): string {
      return "";
    }

    public function getJoinCondition(): string {
      return "";
    }

    protected function afterLoad($itemDtos, $itemsCount): void {


    }

    protected function beforeLoad(): void {


    }

    /**
     * @return string
     */
    public function getTemplate(): string {
      return NGS()->getTemplateDir() . "/cms/list.tpl";
    }

  }

}
