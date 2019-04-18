<?php
/**
 * CmsManager manager class
 *
 * @author Mikael Mkrtchyan
 * @site http://naghashyan.com
 * @mail miakel.mkrtchyan@naghashyan.com
 * @year 2017
 * @package admin.managers
 * @version 7.0.0
 *
 */

namespace nsg\cms\managers {

  use ngs\AbstractManager;
  use nsg\cms\dal\dto\AbstractCmsDto;
  use nsg\cms\dal\mappers\AbstractCmsMapper;

  abstract class AbstractCmsManager extends AbstractManager {

    /**
     * @var AbstractCmsMapper
     */
    private $mapper = null;

    /**
     * AbstractCmsManager constructor.
     * @param AbstractCmsMapper $mapper
     */
    public function __construct() {
    }


    /**
     * @param array $params
     * @return mixed
     */
    public function createItem(array $params) {
      $itemDto = $this->getMapper()->createDto();
      $itemDto->fillDtoFromArray($params);
      $id = $this->getMapper()->insertDto($itemDto);
      $itemDto->setId($id);
      return $itemDto;
    }

    /**
     * @param $itemId
     * @param array $params
     * @return mixed
     */
    public function updateItem($itemId, array $params) {
      $itemDto = $this->getMapper()->createDto();
      $itemDto->fillDtoFromArray($params);
      $itemDto->setId($itemId);
      $this->getMapper()->updateByPk($itemDto);
      $itemDto = $this->getMapper()->getItemById($itemId);
      return $itemDto;
    }


    /**
     * @param string $orderBy
     * @param string $sortBy
     * @param int $limit
     * @param int $offset
     * @param int $registrationId
     * @return AbstractCmsDto[]
     */
    public function getList(string $orderBy = "id", string $sortBy = "DESC", int $limit = 1000,
                            int $offset = 0, int $registrationId = null, $whereCondition = "", $joinCondition = "") {
      return $this->getMapper()->getList($orderBy, $sortBy, $limit, $offset, $registrationId, $whereCondition, $joinCondition);
    }

    public function deleteItemById($itemId) {
      return $this->getMapper()->deleteItemById($itemId);
    }


    /**
     * @param string $itemId
     * @return mixed
     */
    public function getItemById(string $itemId) {
      return $this->getMapper()->getItemById($itemId);
    }


    public abstract function getMapper();

    public function createDto() {
      return $this->getMapper()->createDto();
    }

    /**
     * get all items count
     *
     * @param $whereCondition
     * @param $joinCondition
     *
     * @return int
     */
    public function getItemsCount($whereCondition = null, $joinCondition = null): int {
      return $this->getMapper()->getItemsCount($whereCondition, $joinCondition);
    }

  }

}
