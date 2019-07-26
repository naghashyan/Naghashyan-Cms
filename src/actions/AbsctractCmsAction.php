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

    public function getRequestGroup() {
      if (!NGS()->get("REQUEST_GROUP") === null){
        throw new NgsErrorException("please set in constats REQUEST_GROUP");
      }
      return NGS()->get("REQUEST_GROUP");
    }

  }

}
