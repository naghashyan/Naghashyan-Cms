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

  use ngs\exceptions\NgsErrorException;
  use ngs\request\AbstractLoad;

  abstract class AbstractCmsLoad extends AbstractLoad {

    protected $im_limit = 10;
    protected $im_pagesShowed = 9;


    public function getLimit() {
      if (is_numeric(NGS()->args()->limit) && NGS()->args()->limit > 0){
        return NGS()->args()->limit;
      }
      return $this->im_limit;
    }

    public function getOffset() {
      return $this->getLimit() * ($this->getCurrentPage() - 1);
    }

    public function getPagesShowed() {
      return $this->im_pagesShowed;
    }

    public function getCurrentPage() {
      $page = 1;
      if (is_numeric(NGS()->args()->page) && NGS()->args()->page > 1){
        $page = NGS()->args()->page;
      }
      return $page;
    }

    public function initPaging($itemsCount) {
      $limit = $this->getLimit();
      $pagesShowed = $this->getPagesShowed();
      $page = $this->getCurrentPage();
      if ($limit < 1){
        return false;
      }
      $pageCount = ceil($itemsCount / $limit);
      $centredPage = ceil($pagesShowed / 2);
      $pStart = 0;
      if (($page - $centredPage) > 0){
        $pStart = $page - $centredPage;
      }
      if (($page + $centredPage) >= $pageCount){
        $pEnd = $pageCount;
        if (($pStart - ($page + $centredPage - $pageCount)) > 0){
          $pStart = $pStart - ($page + $centredPage - $pageCount) + 1;
        }
      } else{
        $pEnd = $pStart + $pagesShowed;
        if ($pEnd > $pageCount){
          $pEnd = $pageCount;
        }
      }
      $this->addParam("pageCount", $pageCount);
      $this->addParam("page", $page);
      $this->addParam("pStart", $pStart);
      $this->addParam("pEnd", $pEnd);
      $this->addParam("limit", $limit);
      $this->addParam("itemsCount", $itemsCount);
      $this->addParam("itemsPerPageOptions", array(15, 30, 50, 100));
      return true;
    }

    public function getRequestGroup() {
      if (!NGS()->get("REQUEST_GROUP") === null){
        throw new NgsErrorException("please set in constats REQUEST_GROUP");
      }
      return NGS()->get("REQUEST_GROUP");
    }
  }

}
