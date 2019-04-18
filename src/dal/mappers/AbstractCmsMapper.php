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
namespace nsg\cms\dal\mappers {

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
		public function getPKFieldName() {
			return "id";
		}

		/**
		 * @see AbstractMysqlMapper::getTableName()
		 */
		public function getTableName() {
			return $this->tableName;
		}


    /**
     * @var string
     */
    private $DELETE_ITEM_BY_ID = "DELETE FROM %s WHERE `id`=:itemId";

		public function deleteItemById($itemId) {
      $sqlQuery = sprintf($this->DELETE_ITEM_BY_ID, $this->getTableName());
      $res = $this->executeUpdate($sqlQuery, ["itemId" => $itemId]);
      if (is_numeric($res)){
        return true;
      }
      return false;
    }

    /**
     * @var string
     */
    private $GET_LIST = "SELECT %s.* FROM %s %s %s %s LIMIT :offset, :limit";

    /**
     * @param string $sortBy
     * @param string $orderBy
     * @param int $limit
     * @param int $offset
     * @param int|null $registrationId
     * @param string $whereCondition
     * @param string $joinCondition
     * @return array|null
     */
    public function getList(string $sortBy = "id", string $orderBy = "DESC", int $limit = 1000,
                            int $offset = 0, int $registrationId = null, string $whereCondition = "", string $joinCondition = "") {
      $bindArray = array();
      $bindArray['offset'] = (int)$offset;
      $bindArray['limit'] = (int)$limit;

      $orderBySql = $orderBy;

      $sortBySql = $this->getTableName() . "." . $sortBy;

      $sortBySql = " ORDER BY " . $sortBySql . ' ' . $orderBySql;

      $sqlQuery = sprintf($this->GET_LIST, $this->getTableName(), $this->getTableName(), $joinCondition, $whereCondition, $sortBySql);
      return $this->fetchRows($sqlQuery, $bindArray);
    }

    /**
     * @var string
     */
    private $GET_ITEM_BY_ID = "SELECT * FROM %s WHERE `id` = :itemId";

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
    private $GET_COUNT = "SELECT COUNT(*) AS count FROM %s %s %s";

    /**
     * @param $whereCondition
     * @param $joinCondition
     * @return string
     */
    public function getItemsCount($whereCondition = null, $joinCondition = null) {
      $bindArray = array();
      if (!$whereCondition){
        $whereCondition = "";
      }
      if (!$joinCondition){
        $joinCondition = "";
      }
      $sqlQuery = sprintf($this->GET_COUNT, $this->getTableName(), $joinCondition, $whereCondition);
      return $this->fetchField($sqlQuery, 'count', $bindArray);
    }

  }

}