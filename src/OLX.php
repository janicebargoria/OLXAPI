<?php
namespace OlxAPI;
/**
 * Olx API v1.
 *
 * TERMS OF USE:
 * - This code is in no way affiliated with, authorized, maintained, sponsored
 *   or endorsed by OLX or any of its affiliates or subsidiaries. This is
 *   an independent and unofficial API. Use at your own risk.
 * - We do NOT support or tolerate anyone who wants to use this API to send spam
 *   or commit other online crimes.
 *
 */

class olx
{

/**
	* config to all requests
	*
	* @var array
	**/
	private static $cfg = [];

	/**
	* Login url
	*
	* @var string
	**/
	protected $_loginUrl = 'https://auth.olx.com.br/oauth';

	/**
	* Rest API
	*
	* @var string
	**/
	protected $_api = 'https://apps.olx.com.br/autoupload';

	/**
	* use a 2 types of data
	* @var array
	*		   client_id
	*		   client_secret
	*		   redirect_uri
	*		   response_type
	*		   scope
	*
	* @var string
	*		   token
	**/
	public function __construct(
        $data = null)
	{
		if(empty($data))
			throw new Exception("Empty data in __construct");

		if(is_array($data)){
			self::$cfg['redirect_uri'] 	    = $data['redirect_uri'];
			self::$cfg['client_id'] 	    = $data['client_id'];
			self::$cfg['response_type']     = 'code';

			if(isset($data['scope'])) 
				self::$cfg['scope'] 	    = $data['scope'];

			if(isset($data['state'])) 
				self::$cfg['state']         = $data['state'];

			if(isset($data['code'])) 			
				self::$cfg['code'] 	        = $data['code'];

			if(isset($data['client_secret'])) 
				self::$cfg['client_secret'] = $data['client_secret'];			

		} else{
			self::$cfg['token'] = $data;
		}
    }


     /**
	* 
	* Get a login url to send your user
	* in $scope include offline_access to get indefined token
	*
	* @return string 	
	*
	**/
    public function getLoginUrl()
	{
		$endpoint = $this->_loginUrl . '/auth';
		return $endpoint . http_build_query(self::$cfg);
	}

	/**
	* 
	* Get token for the request
	* in $scope include code to receiver in return a getLoginUrl
	*
	* @return array 	
	*
	**/
    public function getToken()
	{
		return $this->request($this->_loginUrl . '/token')
			->addHeader('Accept', 'application/json')
            ->addPost('code', self::$cfg['code'])
            ->addPost('client_id', self::$cfg['client_id'])
            ->addPost('client_secret', self::$cfg['client_secret'])
            ->addPost('redirect_uri', self::$cfg['redirect_uri'])
            ->addPost('grant_type', 'authorization_code')
            ->getResponse();
	}

	/**
	* 
	* Get trademarks OLX used
	*
	* @return array 	
	*
	**/
    public function getMaker()
	{
		$endpoint = $this->_api . '/car_info';

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addPost('access_token', self::$cfg['token'])
            ->getResponse();
	}

	/**
	* 
	* Get models used in olx register
	* 
	* @var make_id is a marcaId
	*
	* @return array 	
	*
	**/
    public function getModels($params)
	{
		$endpoint = $this->_api . '/car_info/'.$params['id_maker'];

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addPost('access_token', self::$cfg['token'])
            ->getResponse();
	}

    /**
    * Returns the list of templates and their encoding in iCarros. The tag is associated with id.
    * @param int $id_maker
    * @return array of templates and their encoding in iCarros.
    **/
    public function getVersionModels($data){
    	$endpoint = $this->_api . '/car_info/'.$params['id_maker'].'/'.$params['id_model'];

    	return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addPost('access_token', self::$cfg['token'])
            ->getResponse();
    }

    /**
    * Returns the encoding for the fuel field to be used for ad inclusion
    * @return array Containing fuel field to be used for ad inclusion
    **/
    public function getFuelTypes(){
        
        $fuelTypes =  [
            '1'=>'Gasolina',
            '2'=>'Álcool',
            '3'=>'Flex',
            '4'=>'Gás Natural',
            '5'=>'Diesel'
        ];
        return $fuelTypes;
    }

    /**
    * Returns the encoding for the fuel field to be used for ad inclusion
    * @return array Containing fuel field to be used for ad inclusion
    **/
    public function getGearbox(){
        
        $gearbox = [
            '1'=>'Manual',
            '2'=>'Automático'
        ];
        return $gearbox;
    }

    /**
    * Returns the encoding for the fuel field to be used for ad inclusion
    * @return array Containing fuel field to be used for ad inclusion
    **/
    public function getCartype(){
        
        $cartype = [
            '1'=>'Passeio',
            '2'=>'Conversível',
            '3'=>'Pick-up',
            '4'=>'Antigo',
            '5'=>'SUV'
        ];
        return $cartype;
    }

    /**
    * Returns the encoding for the fuel field to be used for ad inclusion
    * @return array Containing fuel field to be used for ad inclusion
    **/
    public function getDoors(){
        
        $doors = [
            '1'=>'2 Portas',
            '2'=>'4 Portas'
        ];
        return $doors;
    }

    /**
    * Returns the encoding for the fuel field to be used for ad inclusion
    * @return array Containing fuel field to be used for ad inclusion
    **/
    public function getEnd_tag(){
        
        $end_tag = [
            '1'=>'0',
            '2'=>'1',
            '3'=>'2',
            '4'=>'3',
            '5'=>'4',
            '6'=>'5',
            '7'=>'6',
            '8'=>'7',
            '9'=>'8',
            '10'=>'9'
        ];
        return $end_tag;
    }

    /**
    * Returns the encoding for the fuel field to be used for ad inclusion
    * @return array Containing fuel field to be used for ad inclusion
    **/
    public function getCar_features(){
        
        $car_features = [
            '1'=>'Ar Condicionado',
            '2'=>'Direção Hidráulica',
            '3'=>'Vidro Elétrico',
            '4'=>'Trava Elétrica',
            '5'=>'Air Bag',
            '6'=>'Alarme'
        ];
        return $car_features;
    }

    /**
    * get all ads published
    * @return array Containing fuel field to be used for ad inclusion
    **/
    public function getPublishedDeals(){
		$endpoint = $this->_api . '/published';

    	return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addPost('access_token', self::$cfg['token'])
            ->getResponse();
    }

    /**
    * get the receveid calls by the advertiser.
    * @return array Containing fuel field to be used for ad inclusion
    **/
    public function getStatusDeal($params){
		$endpoint = $this->_api . '/import/'.$params['ad_token'];

    	return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addPost('access_token', self::$cfg['token'])
            ->getResponse();
    }

    /**
	* 
	* Create a new ad in the inventory
	* 
	* @var array 
	*		dealer_id
	*		trim_id
	*		production_year
	*		model_year
	*		doors
	*		color_id
	*		km
	*		price
	*		price_resale
	*		fuel_id
	*		plate
	*		text
	*		equipments_ids
	*		photos_ids
	*
	* @return array 	
	*
	**/
    public function postDeal($params)
	{

		$endpoint = $this->_api . '/import';

	    $fields['ad_list']=[[
            'id'=>$params['id'],
            'operation' => 'insert',
            'category' => 2020,
            'type' => 's',
            'price' => $params['price'],
            'subject' => $params['subject'],
            'body' => $params['body'],
            'phone' => $params['phone'],
            'zipcode' => $params['zipcode'],
            'params'=>[
                'fuel' => $params['fuel'],
                'mileage' => $params['mileage'],
                'gearbox' => $params['gearbox'],
                'vehicle_brand' => $params['vehicle_brand'],
                'vehicle_model' => $params['vehicle_model'],
                'vehicle_version' => $params['vehicle_version'],
                'regdate' => $params['regdate'],
                'cartype' => $params['cartype'],
                'doors' => $params['doors'],
                'end_tag' => $params['end_tag'],
                'car_features' => $params['car_features']
            ],
            'images'=>$params['images']]
        ];

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addHeader('Content-Type', 'application/json')
            ->addPut('access_token', self::$cfg['token'])
            ->addPut('ad_list', $fields)
            ->getResponse();
	}

	/**
	* 
	* Remove a ad in the inventory
	* 
	* @var array 
	*				dealerId
	*				dealId
	*
	*
	* @return array 	
	*
	**/
    public function deleteDeal($params){
		$endpoint = $this->_api . '/import';

		$fields['ad_list']=[[
                'id'=>$params['id'],
                'operation' => 'delete'
        ]];

		return $this->request($endpoint)
            ->addHeader('Accept', 'application/json')
            ->addPut('access_token', self::$cfg['token'])
            ->addPut('ad_list' $fields)
            ->getResponse();
    }

    /**
     *
     * Used internally, but can also be used by end-users if they want
     * to create completely custom API queries without modifying this library.
     *
     * @param string $url
     *
     * @return array
     */
    public function request(
        $url)
    {
        return new Request($this, $url);
    }


}