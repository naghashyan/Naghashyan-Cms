<?php
/**
 *
 * AbstractAlbumMapper class is extended class from AbstractMysqlMapper.
 * It contatins functions that used in album mapper.
 *
 * @author Mikael Mkrtcyan
 * @site http://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2017
 * @package dal.mappers
 * @version 7.0
 *
 */

namespace ngs\cms\dal\mappers {

  use ngs\cms\dal\binparams\NgsCmsParamsBin;
  use ngs\dal\mappers\AbstractMysqlMapper;

  abstract class AbstractCmsMapper extends AbstractMysqlMapper {

    public function __construct() {
      // Initialize the dbmc pointer.
      AbstractMysqlMapper::__construct();
    }

    /**
     * @var string
     */
    public $tableName;

    /**
     * @see AbstractMysqlMapper::getPKFieldName()
     */
    public function getPKFieldName(): string {
      return 'id';
    }

    /**
     * @see AbstractMysqlMapper::getTableName()
     */
    public function getTableName(): string {
      return $this->tableName;
    }


    /**
     * @var string
     */
    private $DELETE_ITEM_BY_ID = 'DELETE FROM %s WHERE `id`=:itemId';

    public function deleteItemById($itemId) {
      $sqlQuery = sprintf($this->DELETE_ITEM_BY_ID, $this->getTableName());
      $res = $this->executeUpdate($sqlQuery, ['itemId' => $itemId]);
      if (is_numeric($res)){
        return true;
      }
      return false;
    }

    /**
     * @var string
     */
    private $GET_LIST = 'SELECT %s.* FROM %s %s %s %s LIMIT :offset, :limit';

    /**
     * @param NgsCmsParamsBin $paramsBin
     * @return array|null
     */
    public function getList(NgsCmsParamsBin $paramsBin) {
      $bindArray = array();
      $bindArray['offset'] = (int)$paramsBin->getOffset();
      $bindArray['limit'] = (int)$paramsBin->getLimit();

      $orderBySql = $paramsBin->getOrderBy();

      $sortBySql = $this->getTableName() . '.' . $paramsBin->getSortBy();
      $sortBySql = ' ORDER BY ' . $sortBySql . ' ' . $orderBySql;
      $sqlQuery = sprintf($this->GET_LIST, $this->getTableName(), $this->getTableName(),
        $paramsBin->getJoinCondition(), $paramsBin->getWhereCondition(), $sortBySql);
      return $this->fetchRows($sqlQuery, $bindArray);
    }

    /**
     * @var string
     */
    private $GET_ITEM_BY_ID = 'SELECT * FROM %s WHERE `id` = :itemId';

    /**
     * @param string $itemId
     * @return bool|mixed
     */
    public function getItemById(string $itemId) {
      $bindArray = ['itemId' => $itemId];
      $sqlQuery = sprintf($this->GET_ITEM_BY_ID, $this->getTableName());
      return $this->fetchRow($sqlQuery, $bindArray);
    }


    /**
     * @var string
     */
    private $GET_COUNT = 'SELECT COUNT(*) AS count FROM %s %s %s';

    /**
     * @param NgsCmsParamsBin $paramsBin
     *
     * @return int
     */
    public function getItemsCount(NgsCmsParamsBin $paramsBin): int {
      $sqlQuery = sprintf($this->GET_COUNT, $this->getTableName(),
        $paramsBin->getJoinCondition(), $paramsBin->getWhereCondition());
      return $this->fetchField($sqlQuery, 'count', []);
    }

  }

}