<?php
/**
 * LogManager class provides all functions for creating,
 * and working with logs.
 *
 * @author Mikael Mkrtchyan
 * @site http://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2019
 * @package ngs.cms.managers
 * @version 6.5.0
 */

namespace ngs\cms\managers {

  use ngs\cms\dal\mappers\LogMapper;
  use IM\dal\dto\album\AlbumDto;
  use IM\managers\users\AdminManager;
  use ngs\AbstractManager;
  use ngs\cms\managers\AbstractCmsManager;
  use ngs\util\HttpRequest;


  class LogManager extends AbstractCmsManager {

    /**
     * @var $instance
     */
    public static $instance;

    /**
     * Returns an singleton instance of this class
     *
     * @return LogManager
     */
    public static function getInstance() {
      if (self::$instance == null){
        self::$instance = new LogManager();
      }
      return self::$instance;
    }

    /**
    * @return \ngs\cms\dal\mappers\AbstractCmsMapper|LogMapper
    */
    public function getMapper() {
      return LogMapper::getInstance();
    }


    /**
     * creates record in DB with action data
     * @param int $userId
     * @param string $action
     * @param string $data
     * @param string $tableName
     * @param int $itemId
     *
     * @throws \ngs\exceptions\DebugException
     */
    public function addLog(int $userId, string $action, string $data, string $tableName, int $itemId = null) {
        $mapper = $this->getMapper();
        $dto = $mapper->createDto();
        $dto->setUserId($userId);
        $dto->setAction($action);
        $dto->setData($data);
        $dto->setItemId($itemId);
        $dto->setItemTableName($tableName);

        $mapper->insertDto($dto);

    }
  }

}
