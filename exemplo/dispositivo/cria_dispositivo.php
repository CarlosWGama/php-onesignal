<?php
require_once(dirname(__FILE__).'/../../src/OneSignal.php');
require_once(dirname(__FILE__).'/../../src/Notification.php');
require_once(dirname(__FILE__).'/../../src/Device.php');
require_once(dirname(__FILE__).'/../../src/CURL.php');

use CWG\OneSignal\OneSignal;
use CWG\OneSignal\Device;

$appID = '92b9c6bb-89d2-4cbc-8862-a80e4e81a251';
$authorizationRestApiKey = 'MWRjMTg2MjEtNTBmYS00ODA4LWE1M2EtM2YyZjU5ZmRkNGQ5';

$api = new OneSignal($appID, $authorizationRestApiKey);

//Criando o Dispositivo
$retorno = $api->device->setLanguage('pt')
                ->setIdentifier('12312312313')
                ->setDevice(Device::ANDROID)
                ->addTag('matricula', '11111111')
                ->addTag('curso', '12312312')
                ->addTag('turma', '1111')
                ->create();


print_r($retorno);

