<?php
/**
 * @author Mikael Mkrtchyan
 * @site http://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2017
 * @package admin.dal.dto
 * @version 7.0
 *
 */

namespace ngs\cms\dal\dto {

  use ngs\dal\dto\AbstractDto;

  abstract class AbstractCmsDto extends AbstractDto {

    protected $tableName = '';
    private $_cmsParentObject = null;
    protected $mapArray = ['id' => ['type' => 'number', 'display_name' => 'ID', 'field_name' => 'id', 'visible' => true, 'actions' => []]];

    public function getMapArray(): array {
      $result = [];
      foreach ($this->mapArray as $key => $value){
        if (isset($value['virtual']) && $value['virtual'] === true){
          continue;
        }
        $result[$key] = $value['field_name'];
      }
      return $result;
    }

    public function getTableName(): string {
      return $this->tableName;
    }

    public function __call($m, $a) {
      return parent::__call($m, $a);
    }

    /**
     * @return array
     */
    public function getVisibleFields(): array {
      $result = [];
      foreach ($this->mapArray as $key => $value){
        if (isset($value['visible']) && $value['visible']){
          $result[$value['field_name']] = ['type' => $value['type'], 'display_name' => $value['display_name'],
            'data_field_name' => $key, 'sortable' => false, 'default_value' => null];
          if (isset($value['sortable']) && $value['sortable'] === true){
            $result[$value['field_name']]['sortable'] = true;
          }
          if (isset($value['default_value'])){
            $result[$value['field_name']]['default_value'] = $value['default_value'];
          }
        }

      }
      return $result;
    }

    private function _getParentDto() {
      if ($this->_cmsParentObject){
        return $this->_cmsParentObject;
      }
      $this->_cmsParentObject = $this->getParentDto();
      return $this->_cmsParentObject;
    }

    protected function getParentDto() {

      return null;
    }


    /**
     * @return array
     */
    public function getVisibleFieldsMethods(): array {
      $visibleFieldsGetters = [];
      $visibleFields = $this->getVisibleFields();
      foreach ($visibleFields as $key => $value){
        $visibleFieldsGetters['get' . ucfirst($key)] = $value;
      }
      return $visibleFieldsGetters;
    }

    /**
     * @param string $type
     * @return array
     */
    public function getAddEditFields(string $type): array {
      $type = $type === 'add' ? $type : 'edit';
      $result = [];
      foreach ($this->mapArray as $key => $value){
        if (isset($value['actions']) && in_array($type, $value['actions'], true)){
          $result[$value['field_name']] = [
            'type' => $value['type'],
            'display_name' => $value['display_name'],
            'data_field_name' => $key,
            'tab' => $value['tab'] ?? 'main',
            'group_name' => $value['group_name'] ?? $value['display_name'],
            'default_value' => $value['default_value'] ?? null,
            'required' => isset($value['required_in']) && in_array($type, $value['required_in'], true)
          ];
        }

      }
      return $result;
    }

    /**
     * @param string $type
     * @return array
     */
    public function getAddEditFieldsMethods(string $type): array {
      $visibleFieldsGetters = [];
      $visibleFields = $this->getAddEditFields($type);
      foreach ($visibleFields as $key => $value){
        $visibleFieldsGetters['get' . ucfirst($key)] = $value;
      }
      return $visibleFieldsGetters;
    }

  }

}
