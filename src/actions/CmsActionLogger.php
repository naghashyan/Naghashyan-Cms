<?php

/**
 * use this class if you want to log action
 *
 *
 * @author Mikael Mkrtchyan
 * @site https://naghashyan.com
 * @mail mikael.mkrtchyan@naghashyan.com
 * @year 2019
 * @package ngs.cms.actions
 * @version 9.0.0
 *
 */

namespace ngs\cms\actions {

    use ngs\cms\managers\LogManager;

    trait CmsActionLogger {

        /**
         * this function will be called before each action which extends from AbstractCmsAction
         *
         * @param $params
         * @param null $itemId
         *
         * @throws \ngs\exceptions\DebugException
         */
        public function loggerActionStart($params, $itemId = null) {
            $userId = NGS()->getSessionManager()->getCustomerId();
            $action = get_class($this);
            $additionalParams = $this->getAdditionalLogParams();
            if($additionalParams) {
                $params = array_merge($params, $additionalParams);
            }
            $data = json_encode($params);

            $logManager = LogManager::getInstance();
            $tableName = $this->getManager()->getMapper()->getTableName();

            $logManager->addLog($userId, $action, $data, $tableName, $itemId);
        }

        /**
         * this function returns additional data for log, if needed you can override it in your action
         *
         * @return array
         */
        public function getAdditionalLogParams():array {
            return [];
        }

        /**
         * this function will be called after each action which extends from AbstractCmsAction
         *
         * @param $dto
         */
        public function loggerActionEnd($dto = null) {

        }

    }

}
