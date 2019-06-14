<?php
/**
 * MainParamsBin class provides setter/getter,
 * for working sending params between loads<----> managers <---->mapper
 *
 * @author Levon Naghashyan
 * @site https://naghashyan.com
 * @mail levon@naghashyan.com
 * @year 2019
 * @package managers.binparams
 * @version 1.0.0
 */

namespace ngs\cms\dal\binparams {

  class NgsCmsParamsBin {

    private $userId = null;
    private $languageId = null;
    private $sortBy = "id";
    private $orderBy = "DESC";
    private $offset = null;
    private $limit = 100;
    private $page = 1;
    private $itemId = null;
    private $position = null;
    private $groupBy = null;
    private $itemType = null;
    private $returnItemsCount = null;
    private $joinCondition = "";
    private $whereCondition = "";
    private $customField = "*";
    private $customFields = [];
    private $searchKey = "";

    /**
     * @param int $userId
     * the userId to set
     */
    public function setUserId($userId) {
      $this->userId = $userId;
    }

    /**
     * @return int userId
     */
    public function getUserId() {
      return $this->userId;
    }

    /**
     * @param string $orderBy
     * the orderBy to set
     */
    public function setOrderBy($orderBy) {
      $this->orderBy = $orderBy;
    }

    /**
     * @return string orderBy
     */
    public function getOrderBy() {
      return $this->orderBy;
    }

    /**
     * @param string $sortBy
     * the sortBy to set
     */
    public function setSortBy($sortBy) {
      if (strtolower($sortBy) == "asc" || strtolower($sortBy) == "desc"){
        $this->sortBy = $sortBy;
      }
    }

    /**
     * @return string sortBy
     */
    public function getSortBy() {
      return $this->sortBy;
    }

    /**
     * @param int $offset
     * the offset to set
     */
    public function setOffset($offset) {
      $this->offset = $offset;
    }

    /**
     * @return int offset
     */
    public function getOffset() {
      return $this->offset;
    }

    /**
     * @param int $limit
     * the limit to set
     */
    public function setLimit($limit) {
      $this->limit = $limit;
    }

    /**
     * @return int limit
     */
    public function getLimit() {
      return $this->limit;
    }

    /**
     * @param int $page
     * the limit to set
     */
    public function setPage($page) {
      $this->page = $page;
    }

    /**
     * @return int page
     */
    public function getPage() {
      return $this->page;
    }


    /**
     * @param string $itemType
     * the itemId to set
     */
    public function setItemType($itemType) {
      $this->itemType = $itemType;
    }

    /**
     * @return string $itemType
     */
    public function getItemType() {
      return $this->itemType;
    }

    /**
     * @param int $itemId
     * the itemId to set
     */
    public function setItemId($itemId) {
      $this->itemId = $itemId;
    }

    /**
     * @return int itemId
     */
    public function getItemId() {
      return $this->itemId;
    }


    /**
     * @param int $position
     * the trackId to set
     */
    public function setPosition($position) {
      $this->position = $position;
    }

    /**
     * @return int $position
     */
    public function getPosition() {
      return $this->position;
    }

    /**
     * @param $groupBy
     * the groupBy to set
     */
    public function setGroupBy($groupBy) {
      $this->groupBy = $groupBy;
    }

    /**
     * @return string groupBy
     */
    public function getGroupBy() {
      return $this->groupBy;
    }

    /**
     * @param bool $returnItemsCount
     * the returnItemsCount to set
     */
    public function setReturnItemsCount($returnItemsCount) {
      $this->returnItemsCount = $returnItemsCount;
    }

    /**
     * @return bool returnItemsCount
     */
    public function getReturnItemsCount() {
      return $this->returnItemsCount;
    }

    /**
     * @param string $customField
     * the customField to set
     */
    public function setCustomField($customField) {
      $this->customField = $customField;
    }

    /**
     * @return string customField
     */
    public function getCustomField() {
      return $this->customField;
    }

    /**
     * @param string $customField
     * the customField to set
     */
    public function setCustomFields($customField) {
      $this->customFields[] = $customField;
    }

    /**
     * @return  array customField
     */
    public function getCustomFields() {
      if (count($this->customFields) == 0){
        return ["*"];
      }
      return $this->customFields;
    }

    /**
     * @param bool $includeFavorite
     * the $includeFavorite to set
     */
    public function setIncludeFavorites($includeFavorite) {
      $this->includeFavorite = $includeFavorite;
    }

    /**
     * @return bool $includeFavorite
     */
    public function getIncludeFavorites() {
      return $this->includeFavorite;
    }

    /**
     * @param string $searchKey
     * the $searchKey to set
     */
    public function setSearchKey($searchKey) {
      $this->searchKey = $searchKey;
    }

    /**
     * @return string $searchKey
     */
    public function getSearchKey() {
      return $this->searchKey;
    }

    /**
     * @return null
     */
    public function getLanguageId() {
      return $this->languageId;
    }

    /**
     * @param null $languageId
     */
    public function setLanguageId($languageId): void {
      $this->languageId = $languageId;
    }

    /**
     * @return string
     */
    public function getJoinCondition(): string {
      return $this->joinCondition;
    }

    /**
     * @param string $joinCondition
     */
    public function setJoinCondition(string $joinCondition): void {
      $this->joinCondition = $joinCondition;
    }

    /**
     * @return string
     */
    public function getWhereCondition(): string {
      return $this->whereCondition;
    }

    /**
     * @param string $whereCondition
     */
    public function setWhereCondition(string $whereCondition): void {
      $this->whereCondition = $whereCondition;
    }
    

  }

}
