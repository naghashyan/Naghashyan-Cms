<?php

/**
 * General parent cms delete action.
 *
 *
 * @author Mikael Mkrtcyan
 * @site http://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2010-2017
 * @package admin.actions
 * @version 7.0.0
 *
 */

namespace ngs\cms\actions {

  use ngs\request\AbstractAction;
  use ngs\exceptions\NgsErrorException;

  abstract class CmsDeleteAction extends AbstractAction {

    /**
     * called before service function
     *
     * @param $itemDto
     */
    public function beforeService() {

    }

    public final function service() {
      $this->beforeService();
      $manager = $this->getManager();

      if (NGS()->args()->itemId){
        $itemId = NGS()->args()->itemId;
        $itemDto = $manager->getItemById($itemId);
        if (!$itemDto){
          throw new NgsErrorException("Item not found.");
        }
        $manager->deleteItemById($itemId);
      } else{
        throw new NgsErrorException("item id incorrect");
      }
      $this->addParam("afterActionLoad", $this->getAfterActionLoad());
      $this->addPagingParameters();

      $this->afterService($itemDto);
    }

    /**
     * called after service function, gets in parameter deleted item DTO
     *
     * @param $itemDto
     */
    public function afterService($itemDto) {

    }

    /**
     * returns load which will called after action
     * @return string
     */
    public function getAfterActionLoad(): string {
      return "";
    }

    protected function addPagingParameters() {
      $result = [];
      $page = NGS()->args()->page ? NGS()->args()->page : 1;
      $result["page"] = $page;
      if (NGS()->args()->limit){
        $result["limit"] = NGS()->args()->limit;
      }
      if (NGS()->args()->search_key){
        $result["search_key"] = NGS()->args()->search_key;
      }
      if (NGS()->args()->sorting){
        $result["sorting"] = NGS()->args()->sorting;
      }
      if (NGS()->args()->ordering){
        $result["ordering"] = NGS()->args()->ordering;
      }
      $this->addParam("afterActionParams", $result);
    }

    /**
     * returns manager
     *
     * @return mixed
     */
    public abstract function getManager();

  }

}
