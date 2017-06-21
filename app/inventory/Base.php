<?php
class Base {
    /**
    * access token
    * @var string
    **/
	protected static $token;

    /**
    * array With access data
    * @var array
    **/
	protected static $data = array();

    /**
    * host olx
    * @var string
    **/
	protected static $host;

	public function __construct($field) {
    	if(is_array($field)){
            self::$data = $field; 
            self::$host = 'https://auth.olx.com.br/oauth';
    	} else{
    		self::$token=$field;
            self::$host = 'https://apps.olx.com.br/autoupload';
    	}
	} 

}
