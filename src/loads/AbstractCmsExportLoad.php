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

    abstract class AbstractCmsExportLoad extends AbstractCmsLoad
    {

        public abstract function getExportFields(): array;

        public final function load()
        {
            $this->beforeLoad();
            $manager = $this->getManager();
            $paramsBin = $this->getNgsListBinParams();
            $itemDtos = $manager->getList($paramsBin);
            $this->downloadSendHeaders("data_export_" . date("Y-m-d") . ".csv");
            echo $this->arrayToCsv($itemDtos);
            exit;
        }


        private function arrayToCsv(array $dtos)
        {
            if (count($dtos) == 0) {
                return null;
            }
            ob_start();
            $df = fopen("php://output", 'w');
            $exportFields = $this->getExportFields();
            $headerColumns = [];
            foreach($exportFields as $exportField) {
                $headerColumns[] = $exportField['display_name'];
            }
            fputcsv($df, $headerColumns);
            foreach ($dtos as $dto) {
                $row = [];
                foreach($exportFields as $exportField) {
                    $getter = 'get' . ucfirst($exportField['field_name']);
                    $row[] =  $dto->$getter();
                }
                fputcsv($df, $row);
            }
            fclose($df);
            return ob_get_clean();
        }

        private function downloadSendHeaders($filename) {
            // disable caching
            $now = gmdate("D, d M Y H:i:s");
            header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
            header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
            header("Last-Modified: {$now} GMT");

            // force download
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");

            // disposition / encoding on response body
            header("Content-Disposition: attachment;filename={$filename}");
            header("Content-Transfer-Encoding: binary");
        }

        /**
         *
         * set default list params bin
         *
         * @return NgsCmsParamsBin
         */

        private function getNgsListBinParams(): NgsCmsParamsBin
        {
            NGS()->args()->ordering = NGS()->args()->ordering ? NGS()->args()->ordering : 'DESC';
            NGS()->args()->sorting = NGS()->args()->sorting ? NGS()->args()->sorting : 'id';
            NGS()->args()->artistId = NGS()->args()->artistId ? NGS()->args()->artistId : null;
            $whereCondition = $this->getNgsWhereCondition();
            $joinCondition = $this->getJoinCondition();
            $paramsBin = new NgsCmsParamsBin();
            $paramsBin->setSortBy(NGS()->args()->sorting);
            $paramsBin->setOrderBy(NGS()->args()->ordering);
            $paramsBin->setLimit($this->getLimit());
            $paramsBin->setOffset($this->getOffset());
            //$paramsBin->setWhereCondition($whereCondition);
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

        protected function modifyNgsListBinParams(NgsCmsParamsBin $paramsBin): NgsCmsParamsBin
        {
            return $paramsBin;
        }

        private function addSortingParams()
        {
            $this->addParam('sortingParam', [NGS()->args()->sorting => strtolower(NGS()->args()->ordering)]);
        }

        public function getBulkUpdateLoad()
        {
            return '';
        }

        /**
         * returns load default manager
         *
         * @return AbstractCmsManager
         */
        public abstract function getManager();

        private function getNgsWhereCondition(): string
        {
            if ($this->getWhereCondition() != '') {
                return ' WHERE ' . $this->getWhereCondition();
            }
            return '';
        }

        public function getWhereCondition(): string
        {
            return '';
        }

        public function getJoinCondition(): string
        {
            return '';
        }

        protected function afterCmsLoad($itemDtos, $itemsCount): void
        {
        }

        protected function beforeLoad(): void
        {
        }

    }

}
