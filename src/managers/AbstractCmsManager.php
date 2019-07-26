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

namespace ngs\cms\managers {

  use ngs\AbstractManager;
  use ngs\cms\dal\binparams\NgsCmsParamsBin;
  use ngs\cms\dal\dto\AbstractCmsDto;
  use ngs\cms\dal\mappers\AbstractCmsMapper;

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
     * @return AbstractCmsDto
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
     * NgsCmsParamsBin $paramsBin
     *
     * @return AbstractCmsDto[]
     */
    public function getList(NgsCmsParamsBin $paramsBin = null) {

      if ($paramsBin === null){
        $paramsBin = new NgsCmsParamsBin();
      }

      return $this->getMapper()->getList($paramsBin);
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

    /**
     * @return AbstractCmsMapper
     */
    public abstract function getMapper();

    public function createDto() {
      return $this->getMapper()->createDto();
    }

    /**
     * get all items count
     *
     * @param NgsCmsParamsBin $paramsBin
     *
     * @return int
     */
    public function getItemsCount(NgsCmsParamsBin $paramsBin): int {
      return $this->getMapper()->getItemsCount($paramsBin);
    }


  }

}
