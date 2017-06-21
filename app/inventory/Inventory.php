<?php

include('Base.php');
include('app/MyCurl.php');

class Inventory extends Base{

    /**
    * 
    * @param array $data
    * @return void 
    **/
    public function __construct($data) {
       parent::__construct($data);
    }

    /**
    * get url will use to get token
    * @return string contain code
    **/
    public function getLoginUrl(){
        try{
            
            if(!isset(parent::$data['scope']) || !isset(parent::$data['state']) || !isset(parent::$data['redirect_uri']) || !isset(parent::$data['client_id'])){
                throw new Exception('missing something in array');
            }

            $url = parent::$host.'?scope='.parent::$data['scope'].'&';
            $url = $url.'state='.parent::$data['state'].'&';
            $url = $url.'redirect_uri='.parent::$data['redirect_uri'].'&';
            $url = $url.'response_type=code&';
            $url = $url.'client_id='.parent::$data['client_id'];
            return $url;
        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }
    }

    /**
    * Returns the encoding for the colors field to be used for ad inclusion 
    * @param array $data
    * @return array field to be used for ad inclusion
    **/
    public function getAccessToken() {
        $url = parent::$host.'/token/';
        try {

            if(!isset(parent::$data['code']) || !isset(parent::$data['client_id']) || !isset(parent::$data['redirect_uri']) || !isset(parent::$data['client_secret']) || !isset(parent::$data['grant_type'])){
                throw new Exception('missing something in array');
            }

            $dateCurl = new \stdClass();
            $dateCurl->_url = $url;
            $dateCurl->_method = 'POST';
            $dateCurl->_status = '';

            $myCurl = new MyCurl($dateCurl);
            $header[0]='Accept: application/json';
            $myCurl->setHeader($header);

            $fields = new \stdClass();
            $fields->code=parent::$data['code'];
            $fields->client_id=parent::$data['client_id'];
            $fields->client_secret=parent::$data['client_secret'];
            $fields->redirect_uri=parent::$data['redirect_uri'];
            $fields->grant_type='authorization_code';
            $fields=http_build_query($fields);
            $myCurl->setPost($fields);

            $token = $myCurl->createCurl();
            $token = json_decode($token);
            
            return $token;
            
        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }
    }

    /**
    * Returns the list of tags and their encoding in iCarros
    * @param array $data
    * @return array of tags and their encoding in iCarros
    **/
    public function getMaker(){
        $url = '/car_info';
        try{
            $dateCurl = new \stdClass();
            $dateCurl->_url = parent::$host.$url;
            $dateCurl->_method = 'POST';
            $dateCurl->_status = '';

            $myCurl = new MyCurl($dateCurl);
            $header[0]='Content-Type: application/json';

            $field = new \stdClass();
            $field->access_token= parent::$token;
            $field=json_encode($field);

            $myCurl->setPost($field);
            $myCurl->setHeader($header);
            $maker = $myCurl->createCurl();

            $maker = json_decode($maker);
            return $maker;


        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }
    }

    /**
    * Returns the list of templates and their encoding in iCarros. The tag is associated with id.
    * @param int $id_maker
    * @return array of templates and their encoding in iCarros.
    **/
    public function getModels($data){
        $url = '/car_info/'.$data['id_maker'];

        try{
            $dateCurl = new \stdClass();
            $dateCurl->_url = parent::$host.$url;
            $dateCurl->_method = 'POST';
            $dateCurl->_status = '';

            $myCurl = new MyCurl($dateCurl);
            $header[0]='Accept: application/json';

            $field = new \stdClass();
            $field->access_token= parent::$token;
            $field=json_encode($field);

            $myCurl->setPost($field);
            $myCurl->setHeader($header);
            $models = $myCurl->createCurl();

            $models = json_decode($models);
            return $models;

        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }

    }

    /**
    * Returns the list of templates and their encoding in iCarros. The tag is associated with id.
    * @param int $id_maker
    * @return array of templates and their encoding in iCarros.
    **/
    public function getVersionModels($data){
        $url = '/car_info/'.$data['id_maker'].'/'.$data['id_model'];

        try{
            $dateCurl = new \stdClass();
            $dateCurl->_url = parent::$host.$url;
            $dateCurl->_method = 'POST';
            $dateCurl->_status = '';

            $myCurl = new MyCurl($dateCurl);
            $header[0]='Accept: application/json';

            $field = new \stdClass();
            $field->access_token= parent::$token;
            $field=json_encode($field);

            $myCurl->setPost($field);
            $myCurl->setHeader($header);
            $version = $myCurl->createCurl();

            $version = json_decode($version);
            return $version;

        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }

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
    * Create a new ad
    * @param array $data
    * @return int id new deal
    **/
    public function createAd($data){
        $url = '/import';

        try {
            $dateCurl = new \stdClass();
            $dateCurl->_url = parent::$host.$url;
            $dateCurl->_method = 'PUT';
            $dateCurl->_status = '';

            $myCurl = new MyCurl($dateCurl);
            $header[0]='Content-Type: application/json';

            if(!isset($data['id'])){
                throw new Exception("Error Message: id is required");
            }

            if(!isset($data['subject'])){
                throw new Exception("Error Message: subject is required");
            }

            if(!isset($data['body'])){
                throw new Exception("Error Message: body is required");
            }  

            if(!isset($data['phone'])){
                throw new Exception("Error Message: phone is required");
            }

            if(!isset($data['zipcode'])){
                throw new Exception("Error Message: zipcode is required");
            }

            if(!isset($data['gearbox'])){
               throw new Exception("Error Message: gearbox is required");
            }

            if(!isset($data['fuel'])){
               throw new Exception("Error Message: fuel is required");
            }

            if(!isset($data['mileage'])){
                throw new Exception("Error Message: mileage is required");
            }

            $fields['access_token']= parent::$token; 

            $fields['ad_list']=[[
                'id'=>$data['id'],
                'operation' => 'insert',
                'category' => 2020,
                'type' => 's',
                'price' => $data['price'],
                'subject' => $data['subject'],
                'body' => $data['body'],
                'phone' => $data['phone'],
                'zipcode' => $data['zipcode'],
                'params'=>[
                    'fuel' => $data['fuel'],
                    'mileage' => $data['mileage'],
                    'gearbox' => $data['gearbox'],
                    'vehicle_brand' => $data['vehicle_brand'],
                    'vehicle_model' => $data['vehicle_model'],
                    'vehicle_version' => $data['vehicle_version'],
                    'regdate' => $data['regdate'],
                    'cartype' => $data['cartype'],
                    'doors' => $data['doors'],
                    'end_tag' => $data['end_tag'],
                    'car_features' => $data['car_features']
                ],
                'images'=>$data['images']]
            ];

            $fields=json_encode($fields);

            $myCurl->setPut($fields);
            $myCurl->setHeader($header);

            $return = $myCurl->createCurl();
            $return = json_decode($return);
            return $return;

        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }
    }


    /**
    * get the receveid calls by the advertiser.
    * @param array $data
    * @return array List of Dealers
    **/
    public function deleteAd($data){
        $url = $url = '/import';

       try {
            $dateCurl = new \stdClass();
            $dateCurl->_url = parent::$host.$url;
            $dateCurl->_method = 'PUT';
            $dateCurl->_status = '';

            $myCurl = new MyCurl($dateCurl);
            $header[0]='Accept: application/json';
            
            $fields['access_token']= parent::$token; 

            $fields['ad_list']=[[
                'id'=>$data['id'],
                'operation' => 'delete'
            ]];

            $fields=json_encode($fields);

            $myCurl->setPut($fields);
            $myCurl->setHeader($header);
            $dealer = $myCurl->createCurl();

            $dealer = json_decode($dealer);
            return $dealer;

        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }
    }

    /**
    * get the receveid calls by the advertiser.
    * @param array $data
    * @return array List of Dealers
    **/
    public function getStatusAd($data){
        $url = $url = '/import/'.$data['ad_token'];

        try {
            $dateCurl = new \stdClass();
            $dateCurl->_url = parent::$host.$url;
            $dateCurl->_method = 'POST';
            $dateCurl->_status = '';

            $myCurl = new MyCurl($dateCurl);
            $header[0]='Accept: application/json';
            
            $fields['access_token']= parent::$token; 

            $fields=json_encode($fields);

            $myCurl->setPost($fields);
            $myCurl->setHeader($header);
            $response = $myCurl->createCurl();

            $response = json_decode($response);
            return $response;

        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }
    }

    public function getPublishedAd(){
        $url = '/published';

        try {
            $dateCurl = new \stdClass();
            $dateCurl->_url = parent::$host.$url;
            $dateCurl->_method = 'POST';
            $dateCurl->_status = '';

            $myCurl = new MyCurl($dateCurl);
            $header[0]='Accept: application/json';
            
            $fields['access_token']= parent::$token; 

            $fields=json_encode($fields);

            $myCurl->setPost($fields);
            $myCurl->setHeader($header);
            $response = $myCurl->createCurl();

            $response = json_decode($response);
            return $response;

        } catch (Exception $e) {
            $return = [
                'status'=>'fail',
                'message'=>$e->getMessage()
            ];
            return $return;
        }
    }

    
}