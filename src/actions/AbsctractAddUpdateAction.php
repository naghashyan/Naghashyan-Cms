<?php
/**
 * General parent cms add update action.
 *
 *
 * @author Mikael Mkrtcyan
 * @site https://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2010-2019
 * @package ngs.cms.actions
 * @version 9.0.0
 *
 */

namespace ngs\cms\actions {

  use ngs\cms\dal\dto\AbstractCmsDto;
  use ngs\cms\managers\AbstractCmsManager;
  use ngs\exceptions\NgsErrorException;

  abstract class AbsctractAddUpdateAction extends AbsctractCmsAction {

    /**
     * return default action manager
     *
     * @return AbstractCmsManager
     */
    public abstract function getManager();

    /**
     * fields that should be set after save request
     *
     * @var array
     */
    private $addEditFieldsMethods = [];

    /**
     * sets addEditFieldMethods which are used to fill request data
     * @param array $visibleFieldsMethods
     */
    public function setAddEditFieldsMethods(array $visibleFieldsMethods): void {
      $this->addEditFieldsMethods = $visibleFieldsMethods;
    }

    /**
     * returns addEditFieldMethods which are used to fill request data
     * @return array
     */
    public function getAddEditFieldsMethods(): array {
      return $this->addEditFieldsMethods;
    }

    /**
     * by using mapArray sets addEditFieldMethods which are used to fill request data
     *
     * @param AbstractCmsDto $cmsDto
     * @param string $type
     */
    private function initializeAddEditFieldsMethods($cmsDto, string $type): void {
      $visibleFieldsMethods = $cmsDto->getAddEditFieldsMethods($type);
      if (count($visibleFieldsMethods)){
        $this->setAddEditFieldsMethods($visibleFieldsMethods);
      }
    }

    /**
     * @param $params
     * @return mixed
     */
    public function beforeService(array $params): array {
      return $params;
    }

    public final function service() {
      $manager = $this->getManager();
      $itemDto = null;
      if (NGS()->args()->id){
        $params = $this->getRequestParameters('edit');
        $params = $this->beforeService($params);
        $this->loggerActionStart($params, NGS()->args()->id);
        $itemDto = $manager->updateItem(NGS()->args()->id, $params);
      } else{
        $params = $this->getRequestParameters('add');
        $this->loggerActionStart($params);
        $params = $this->beforeService($params);
        $itemDto = $manager->createItem($params);
      }
      $this->addParam('afterActionLoad', $this->getAfterActionLoad());
      $this->addPagingParameters();
      $this->afterService($itemDto);
      $this->loggerActionEnd($itemDto);
    }


    /**
     * called after service function, gets in parameter deleted item DTO
     *
     * @param AbstractCmsDto $itemDto
     */
    public function afterService($itemDto): void {

    }

    protected function addPagingParameters() {
      $pageParams = [];
      if(NGS()->args()->pageParams && is_array(NGS()->args()->pageParams)){
        foreach (NGS()->args()->pageParams as $key => $pageParam){
          if ($pageParam === 'null'){
            continue;
          }
          $pageParams[$key] = $pageParam;
        }
      }
      $this->addParam('afterActionParams', $pageParams);
    }

    /**
     * returns load which will called after action
     * @return string
     */
    public function getAfterActionLoad(): ?string {
      return '';
    }

    /**
     * returns request parameters array formater as ['db_field_name' => value]
     *
     * @param string $type
     * @return array
     * @throws NgsErrorException
     */
    public function getRequestParameters(string $type): array {
      $type = $type === 'add' ? $type : 'edit';
      $updateArr = [];
      $manager = $this->getManager();
      $this->initializeAddEditFieldsMethods($manager->createDto(), $type);
      $editFields = $this->getAddEditFieldsMethods();
      foreach ($editFields as $methodKey => $methodValue){
        $key = $methodValue['data_field_name'];
        $fieldName = $methodValue['data_field_name'];

        $value = NGS()->args()->$fieldName;
        if (is_string($value)){
          $value = trim($value);
        }
        if ($methodValue['required'] && !$value){
          $fieldDisplayName = $methodValue['display_name'];
          throw new NgsErrorException($fieldDisplayName . ' field is required!');
        }
        if ($methodValue['type'] === 'number' && $value && !is_numeric($value)){
          throw new NgsErrorException($key . ' field should be number!');
        }
        if ($methodValue['type'] === 'checkbox'){
          $value = $value === 'on' ? 1 : 0;
        }
        if (is_null($value) || $value === ''){
          $updateArr[$key] = 'NULL';
          continue;
        }
        if ($methodValue['type'] === 'date'){
          $format = 'd F Y';
          if ($fieldName === 'date_start'){
            $format = 'd F Y, H:i';
            $value .= ', 00:00';
          } else if ($fieldName === 'date_end'){
            $format = 'd F Y, H:i';
            $value .= ', 23:59';
          }

          $date = \DateTime::createFromFormat($format, $value);
          if (!$date){
            continue;
          }
          $value = $date->format('Y-m-d H:i:s');
        }
        if (!($methodValue['type'] === 'password' && !$value)){
          $updateArr[$key] = $value;
        }
      }
      $updateArr = array_merge($updateArr, $this->getAdditionalParams());
      return $updateArr;
    }

    public function getAdditionalParams(): array {
      return [];
    }

  }

}
