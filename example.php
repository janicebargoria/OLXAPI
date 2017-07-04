<?php

use OlxAPI\Olx as Olx;
require('vendor/autoload.php');

$olx = new olx(
	array(
		'response_type'=>'{code}',
		'client_id'=>'{client_id}',
	    'client_secret'=>'{client_secret}',
	    'redirect_uri' => '{redirect_uri}',
	    'state'=>'{state}',
	    'code'=>'{code}'
	)
);

$url = $olx->getLoginUrl();
$token = $olx->getToken();

