<?php
/** 
* Biblioteca para usar Push Notifications para o One Signal
* @author Carlos W. Gama <carloswgama@gmail.com>
* @category Library
* @version 1.0.0
* @license MIT
* @link https://documentation.onesignal.com/v3.0/reference#create-notification
*/
namespace CWG\OneSignal;

use CWG\OOneSignal\Exception\OneSignalException;
use CWG\OneSignal\Notification;

class Notification {

    /**
    * Objeto que irá enviar as requisições
    * @access private
    * @var CURL
    */
    private $curl;

    /**
    * ID da API
    * @access private
    * @var string
    */
    private $appID;

    private $campos = [ ];

    public function __construct($appID) {
        $this->curl = CURL::getInstance();
        $this->appID = $appID;
    }

    /**
    * Seta o Segmento que irá receber a notificação
    * @param $segments array
    * @return Device
    */
    public function setSegment($segments) {
        if (!is_array($segments)) $segments = [$segments];
        $this->campos['included_segments'] = $segments;
        return $this;
    }

    /**
    * Adicionar um segmento que irá receber a notificação
    * @param $segment string
    * @return Device
    */
    public function addSegment($segment) {
        $this->campos['included_segments'][] = $segment;
        return $this;
    }

    
    /**
    * Adicionar um dispositivo que irá receber a notificação
    * @param $segment string
    * @return Device
    */
    public function addDevice($deviceID) {
        $this->campos['include_player_ids'][] = $deviceID;
        return $this;
    }

    
    /**
    * Adicionar uma tag que irá receber a notificação
    * @param $segment string
    * @return Device
    */
    public function addTag($campo, $valor) {
        $tag = [
            'field'     => 'tag',
            'key'       => $campo,
            'relation'  => '=',
            'value'     => $valor
        ];
		
        if (isset($this->campos['filters']) && count($this->campos['filters']) > 0)
            $this->campos['filters'][] = ['operator' => 'OR']; 
        $this->campos['filters'][] = $tag;

        return $this;
    }

    /**
    * Seta os conteúdos enviados para o servidor
    * @param $contents array com as informações
    * @param $lang no idioma informado
    * @param Notification
    */
    public function setBody($contents, $lang = 'pt') {
        $this->campos['contents'][$lang] = $contents;
        if (!isset($this->campos['contents']['en'])) 
            $this->campos['contents']['en'] = $contents;
        return $this;
    }

    
    /**
    * Seta o título do conteúdo
    * @param $contents array com as informações
    * @param $lang no idioma informado
    * @param Notification
    */
    public function setTitle($title, $lang = 'pt') {
        $this->campos['headings'][$lang] = $title;
        if (!isset($this->campos['headings']['en']))
            $this->campos['headings']['en'] = $title;
        return $this;
    }

    /**
    * Cria um novo dispositivo
    * @param $campos array;
    */
    public function send($campos = null) {
        if ($campos != null) $this->campos = $campos;

        $this->campos['app_id'] = $this->appID;
        
        //Se não seleciona para quem enviar, então via para todos
        if (empty($this->campos['included_segments']) && empty($this->campos['filters']) && empty($this->campos['include_player_ids'])) 
            $this->campos['included_segments'] = ['All'];  

        return $this->curl->post('notifications', $this->campos);
    }

    /**
    * Deleta uma notificação
    * @param $campos array;
    */
    public function cancel($deviceID) {
        return $this->curl->delete('notifications/' . $notificationID.'?app_id=' . $this->appID);
    }

    /**
    * O ID da APP
    * @param $appID string
    */
    private function setAppID($appID) {
        $this->appID = $appID;
    }

}