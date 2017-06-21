<?php
/**
 * Class OAuth
 *
 * @package authentication
 */

include('app/MyCurl.php');
class OAuth {

	// //$username, $password, $client_id, $client_secret, $url, $redirect_url
	public function __construct(){

	}

	/**
	* url do host icarros
	* @var string
	**/
	protected $host = '';
	
	/**
	* get autorization code, then you can get token
	* @param array $data
	**/
	public function getAccessAuthorization($data){
		$host = '​https://auth.olx.com.br/oauth';

		try{

			$host = $host.'?scope='.$data->scope.'&';
			$host = $host.'state='.$data->state.'&';
			$host = $host.'redirect_uri='.$data->redirect_uri.'&';
			$host = $host.'response_type='.$data->response_type.'&';
			$host = $host.'client_id='.$data->client_id;

			$header[0]='Content-Type: application/json';

			$dateCurl = new \stdClass();
			$dateCurl->_url = $host;
			$dateCurl->_method = 'GET';
			$dateCurl->_status = '';

			$myCurl = new MyCurl($dateCurl);
			var_dump($host);
			exit(0);

			$myCurl->setHeader($header);
			$response = json_decode($myCurl->createCurl());
		    return $response;

			
		} catch (Exception $e) {
            $return = [
            	'status'=>'fail',
            	'message'=>$e->getMessage()
            ];
            return $return;
        }
	}

	/**
	* Depois de obter o código de autorização, necessário solicitar token de acesso.
	* @param array $data
	**/
	public function getAccessToken($data){
		$host = '/auth/realms/icarros/protocol/openid-connect/token';
		try{

			$fields=[
				'scope'=>$data->scope,
				'client_id'=>$data->client_id,
				'client_secret'=>$data->client_secret,
				'redirect_url'=>$data->redirect_url,
				'grant_type'=>'authorization_code'
			];

			$header[0]='Content-Type: application/json';

			$dateCurl = new \stdClass();
			$dateCurl->_url = $host;
			$dateCurl->_method = 'POST';
			$dateCurl->_status = '';
			$myCurl = new MyCurl($dateCurl);

			$myCurl->setPost($fields);
			$myCurl->setHeader($header);

			$response = json_decode($myCurl->createCurl());
			return $request;

		} catch (Exception $e) {
            $return = [
            	'status'=>'fail',
            	'message'=>$e->getMessage()
            ];
            return $return;
        }
	}

	/**
	* Token de acesso tem algo em torno de 1 hora de duração, médoto criado para atualizar token
	* @param array $data
	**/
	public function getRefreshToken($data){
		$host = '/auth/realms/icarros/protocol/openid-connect/token';

		try{

			$fields=[
				'refresh_token'=>$data->refresh_token,
				'client_id'=>$data->client_id,
				'client_secret'=>$data->client_secret,
				'grant_type'=>'refresh_token'
			];

			$header[0]='Content-Type: application/json';

			$dateCurl = new \stdClass();
			$dateCurl->_url = $host;
			$dateCurl->_method = 'POST';
			$dateCurl->_status = '';
			$myCurl = new MyCurl($dateCurl);

			$myCurl->setPost($fields);
			$myCurl->setHeader($header);

			$response =  json_decode($myCurl->createCurl());
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

