<?php

/**
 * General parent cms bulk update action.
 *
 *
 * @author Mikael Mkrtcyan
 * @site http://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2019
 * @package admin.actions
 * @version 7.0.0
 *
 */

namespace ngs\cms\actions {

  use ngs\request\AbstractAction;

  abstract class CmsBulkAction extends AbsctractCmsAction {

    /**
     * main service
     */
    public final function service() {
      $this->beforeCmsBulkService();
      $result = $this->cmsBulkService();
      $this->afterCmsBulkService($result);
      $this->addPagingParameters();
    }

    /**
     * service which should be override to handle service
     */
    protected abstract function cmsBulkService();

    /**
     * called before csmBulkService
     */
    protected function beforeCmsBulkService() {

    }

    /**
     * called after cmsBulkService, get result of cmsBulkService as parameter
     *
     * @param $resultAfterCmsService
     */
    protected function afterCmsBulkService($resultAfterCmsService) {

    }
  }

}
