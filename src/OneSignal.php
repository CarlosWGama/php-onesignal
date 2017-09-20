<?php
/** 
* Biblioteca para usar Push Notifications para o One Signal
* @author Carlos W. Gama <carloswgama@gmail.com>
* @category Core
* @version 1.0.0
* @license MIT
*/
namespace CWG\OneSignal;

use CWG\OneSignal\Notification;
use CWG\OneSignal\Device;
use CWG\OneSignal\CURL;

class OneSignal {


    private $notification;
    private $device;

    public function __construct($appID, $authorizationID) {
        $this->notification = new Notification($appID);
        $this->device = new Device($appID);
    
        $curl = CURL::getInstance();
        $curl->setAuthorization($authorizationID);
    }

    /**
    * O ID da APP
    * @param $appID string
    */
    private function setAppID($appID) {
        $this->notification->setAppID($appID);
        $this->device->setAppID($appID);
    }
    
    /**
    * Usa um Getter para permitir recuperar os objetos de notificação e device
    */
    public function __get($field) {
        if (isset($this->$field))
            return $this->$field; 
    }

}