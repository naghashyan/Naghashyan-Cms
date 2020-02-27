<?php

/**
 * General parent cms actions.
 *
 *
 * @author Levon Naghashyan
 * @site https://naghashyan.com
 * @mail levon@naghashyan.com
 * @year 2019
 * @package ngs.cms.actions
 * @version 9.0.0
 *
 */

namespace ngs\cms\actions {

  use ngs\request\AbstractAction;
  use ngs\cms\dal\dto\AbstractCmsDto;
  use ngs\exceptions\NgsErrorException;

  abstract class AbsctractCmsAction extends AbstractAction {


    protected function addPagingParameters() {
      $result = [];
      $page = NGS()->args()->page ? NGS()->args()->page : 1;
      $result['page'] = $page;
      if (NGS()->args()->limit){
        $result['limit'] = NGS()->args()->limit;
      }
      if (NGS()->args()->search_key){
        $result['search_key'] = NGS()->args()->search_key;
      }
      if (NGS()->args()->sorting){
        $result['sorting'] = NGS()->args()->sorting;
      }
      if (NGS()->args()->ordering){
        $result['ordering'] = NGS()->args()->ordering;
      }
      if (NGS()->args()->parentId){
        $result['parentId'] = NGS()->args()->parentId;
      }
      $this->addParam('afterActionParams', $result);
    }

    public function getRequestGroup() {
      if (!NGS()->get("REQUEST_GROUP") === null){
        throw new NgsErrorException("please set in constats REQUEST_GROUP");
      }
      return NGS()->get("REQUEST_GROUP");
    }

    public function loggerActionStart($params) {

    }

    public function loggerActionEnd($dto = null) {

    }

  }

}
