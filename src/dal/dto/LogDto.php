<?php
/**
 * LogDto class
 * setter and getter generator
 * for ilyov_logs table
 * this dto used to store actions logs
 *
 * @author Mikael Mkrtchyan
 * @site http://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2019
 * @package ngs.cms.dal.dto
 * @version 7.0
 *
 */

namespace ngs\cms\dal\dto {

  use ngs\cms\dal\dto\AbstractCmsDto;

  class LogDto extends AbstractCmsDto {

    protected $mapArray = ["id" => ["type" => "number", "display_name" => "ID", "field_name" => "id", "visible" => true, "actions" => []],
      "user_id" => ["type" => "number", "display_name" => "User ID", "field_name"=> "userId", "visible" => true, "actions" => []],
      "action" => ["type" => "text", "display_name" => "Action", "field_name" => "action", "visible" => true, "actions" => []],
      "item_id" => ["type" => "number", "display_name" => "Item ID", "field_name"=> "itemId", "visible" => true, "actions" => []],
      "item_table_name" => ["type" => "text", "display_name" => "Table Name", "field_name"=> "itemTableName", "visible" => true, "actions" => []],
      "data" => ["type" => "text", "display_name" => "Data", "field_name" => "data", "visible" => true, "actions" => []],
      "added_time" => ["type" => "date", "display_name" => "Added Time", "field_name" => "addedTime", "visible" => true, "actions" => []]
    ];

    // constructs class instance
    public function __construct() {
    }

    public function getTableName():string {
      return "ilyov_logs";
    }
  }

}
