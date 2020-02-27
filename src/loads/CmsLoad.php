<?php
/**
 * General parent load for all imusic.am admin load classes
 *
 * @author Levon Naghashyan
 * @site   https://naghashyan.com
 * @email  levon@naghashyan.com
 * @year   2012-2019
 * @package ngs.cms.loads
 * @version 6.5.0
 *
 **/

namespace ngs\cms\loads {


    abstract class CmsLoad extends AbstractCmsLoad
    {

        public function initialize()
        {
            parent::initialize();
            $this->addParentParam('activeMenu', $this->getActiveMenu());
        }

        public function getTemplate()
        {
            return NGS()->getTemplateDir('ngs-cms') . '/main_load.tpl';
        }

        protected function getActiveMenu()
        {
            return ['menu' => '', 'submenu' => ''];
        }


        public function getManager()
        {
            return null;
        }


        /**
         * returns js list page load
         * @return string
         */
        public function getListLoad(): string
        {
            return 'ngs.cms.loads.cms_list';
        }

        /**
         * returns js add page load
         * @return string
         */
        public function getAddLoad(): string
        {
            return '';
        }

        /**
         * returns js main page load
         * @return string
         */
        public function getMainLoad(): string
        {
            return '';
        }

        /**
         * returns js export load
         * @return string
         */
        public function getExportLoad(): string
        {
            return '';
        }

        /**
         * returns js edit page load
         * @return string
         */
        public function getEditLoad(): string
        {
            return '';
        }

        /**
         * returns js delete item action
         * @return string
         */
        public function getDeleteAction(): string
        {
            return '';
        }

        public function getDefaultLoads()
        {
            if ($this->getManager() === null) {
                return [];
            }
            $loads = [];
            $loads['items_content']['args'] = ['manager' => $this->getManager(), 'listLoad' => $this->getListLoad(),
                'mainLoad' => $this->getMainLoad(), 'exportLoad' => $this->getExportLoad(), 'addLoad' => $this->getAddLoad(),
                'editLoad' => $this->getEditLoad(), 'deleteAction' => $this->getDeleteAction(), 'activeMenu' => $this->getActiveMenu()];
            $loads['items_content']['action'] = $this->getListLoad();

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

        public final function load()
        {
            $this->addParam('parentSections', $this->getParentSections());
            $this->addParam('sectionName', $this->getSectionName());
            $this->addJsonParam('addLoad', $this->getAddLoad());
            $this->addJsonParam('mainLoad', $this->getMainLoad());
            $this->addJsonParam('exportLoad', $this->getExportLoad());

            $this->afterCmsLoad();
        }

        public function afterCmsLoad()
        {

        }

    }

}
