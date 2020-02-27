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

  use ngs\cms\loads\AbstractCmsListLoad;
  use ngs\cms\managers\AbstractCmsManager;

  class CmsListLoad extends AbstractCmsListLoad {


    private $listLoad;
    private $addLoad;
    private $editLoad;
    private $deleteAction;
    private $manager;
    private $mainLoad;
    private $exportLoad;
    private $activeMenu;

    public function initialize() {
      parent::initialize();
      $this->listLoad = NGS()->args()->listLoad;
      $this->addLoad = NGS()->args()->addLoad;
      $this->editLoad = NGS()->args()->editLoad;
      $this->deleteAction = NGS()->args()->deleteAction;
      $this->mainLoad = NGS()->args()->mainLoad;
      $this->exportLoad = NGS()->args()->exportLoad;
      $this->manager = NGS()->args()->manager;
      $this->activeMenu = NGS()->args()->activeMenu;
    }

    /**
     * returns load default manager
     *
     * @return AbstractCmsManager
     */
    public function getManager() {
      return $this->manager;
    }

    /**
     * returns js list page load
     * @return string
     */
    public function getListLoad(): string {
      return $this->listLoad;
    }

    /**
     * returns js add page load
     * @return string
     */
    public function getAddLoad(): string {
      return $this->addLoad;
    }

    /**
     * returns js main page load
     * @return string
     */
    public function getMainLoad(): string {
      return $this->mainLoad;
    }


    /**
     * returns js export load
     * @return string
     */
    public function getExportLoad(): string {
      return $this->exportLoad;
    }

    /**
     * returns js edit page load
     * @return string
     */
    public function getEditLoad(): string {
      return $this->editLoad;
    }

    /**
     * returns js edit page load
     * @return string
     */
    protected function getActiveMenu() {
      return $this->activeMenu;
    }

    /**
     * returns js delete item action
     * @return string
     */
    public function getDeleteAction(): string {
      return $this->deleteAction;
    }

    /**
     * @return string
     */
    public function getTemplate(): string {
      return NGS()->getTemplateDir('ngs-cms') . "/list.tpl";
    }

  }

}
