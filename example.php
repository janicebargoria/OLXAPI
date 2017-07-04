<?php

error_reporting(1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

use OlxAPI\Olx as Olx;
require('vendor/autoload.php');

$olx = new olx(array(
	'response_type'=>'{code}',
	'client_id'=>'{client_id}',
    'client_secret'=>'{client_secret}',
    'redirect_uri' => '{redirect_uri}',
    'state'=>'{state}',
    'code'=>'{code}'
));

$url = $olx->getLoginUrl();
$token = $olx->getToken();

