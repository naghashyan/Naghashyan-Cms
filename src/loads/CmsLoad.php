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


  abstract class CmsLoad extends AbstractCmsLoad {


    public function getTemplate() {
      return NGS()->getTemplateDir() . "/cms/main_load.tpl";
    }

    protected function getActiveMenu() {
      return ["menu" => "", "submenu" => ""];
    }


    public function getManager() {
      return null;
    }

    public function getPermalink() {
      return "";
    }

    /**
     * returns js list page load
     * @return string
     */
    public function getListLoad(): string {
      return "ngs.cms.loads.list";
    }

    /**
     * returns js add page load
     * @return string
     */
    public function getAddLoad(): string {
      return null;
    }

    /**
     * returns js main page load
     * @return string
     */
    public function getMainLoad(): string {
      return null;
    }

    /**
     * returns js edit page load
     * @return string
     */
    public function getEditLoad(): string {
      return null;
    }

    /**
     * returns js delete item action
     * @return string
     */
    public function getDeleteAction(): string {
      return null;
    }

    public function getDefaultLoads() {
      if ($this->getManager() === null){
        return [];
      }
      $loads = [];
      $loads["items_content"]["args"] = ["manager" => $this->getManager(), "listLoad" => $this->getListLoad(),
        "mainLoad" => $this->getMainLoad(), "addLoad" => $this->getAddLoad(),
        "editLoad" => $this->getEditLoad(), "deleteAction" => $this->getDeleteAction(), "activeMenu" => $this->getActiveMenu()];
      $loads["items_content"]["action"] = $this->getListLoad();

      return $loads;
    }


    /**
     * @return string
     */
    public abstract function getSectionName(): string;

    /**
     * @return array
     */
    public abstract function getParentSections(): array;

    public final function load() {
      $this->addParam("parentSections", $this->getParentSections());
      $this->addParam("sectionName", $this->getSectionName());
      $this->addJsonParam("addLoad", $this->getAddLoad());
      $this->addJsonParam("mainLoad", $this->getMainLoad());

      $this->afterCmsLoad();
    }

    public function afterCmsLoad() {

    }

  }

}
