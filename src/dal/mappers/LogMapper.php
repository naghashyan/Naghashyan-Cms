<?php
/**
 *
 * LogMapper class is extended class from AbstractCmsMapper.
 * It contatins all read and write functions which are working with ilyov_logs table.
 *
 * @author Mikael Mkrtchyan
 * @site http://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2019
 * @package admin.dal.mappers.album
 * @version 7.0
 *
 */

namespace ngs\cms\dal\mappers {

  use ngs\cms\dal\dto\LogDto;
  use ngs\dal\mappers\AbstractMysqlMapper;
  use ngs\cms\dal\mappers\AbstractCmsMapper;

  class LogMapper extends AbstractCmsMapper {

    //! Private members.

    private static $instance;
    public $tableName = "ilyov_logs";

    /**
     * Returns an singleton instance of this class
     *
     * @return LogMapper
     */
    public static function getInstance(): LogMapper {
      if (self::$instance == null){
        self::$instance = new LogMapper();
      }
      return self::$instance;
    }

    /**
     * @see AbstractMysqlMapper::createDto()
     *
     * return LogDto
     */
    public function createDto() {
      return new LogDto();
    }

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
  }

}