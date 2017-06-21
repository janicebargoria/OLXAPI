# OLX SDK
This open-source library allows you to integrate OLX into your app. Learn more about the provided samples, documentation, integrating the SDK into your app, accessing source code, and more at, [click here](https://www.google.com.br/url?sa=t&rct=j&q=&esrc=s&source=web&cd=3&ved=0ahUKEwjsj_rg987UAhXDx5AKHQatAOgQFggvMAI&url=https%3A%2F%2Folxbrasil.zendesk.com%2Fhc%2Fpt-br%2Farticle_attachments%2F115000987385%2FAPI_OLX_Como_Enviar_Anuncios_2017.pdf&usg=AFQjCNH6Va36dINDHjyI1foOyGN3EqJSvA&sig2=WRXwIXqmvm7dP2YAXmrNFQ)

## Dependencies
List of dependencies for use sdk

  - PHP >= 5.4
  - Curl
  - Composer 
  - Apache

You can also:
  - Generate access token 
  - Access your OLX account
  - Crate news Ads, delete ads e show ads status

The Website of OLX Ltda, is intended to disclose advertisements, surveys, as well as any information and news relating to motor car. This application allows you to make requests in OLX and use many resources, like: inventory, create forms in your application, new ads registration.

## Give Feedback
Please report bugs or issues to https://github.com/Veloccer/olx/issues

## Instalation
step by step - not ready

## Access Token
### Step 1 - Authorization
At first, you register your application on [olx.com](http://www.olx.com.br), learn more about this in [click here](https://www.google.com.br/url?sa=t&rct=j&q=&esrc=s&source=web&cd=2&ved=0ahUKEwjsj_rg987UAhXDx5AKHQatAOgQFggqMAE&url=https%3A%2F%2Folxbrasil.zendesk.com%2Fhc%2Fpt-br%2Farticle_attachments%2F115000987405%2FAPI_OLX_2017.pdf&usg=AFQjCNGqSTATZ1KkGZuar_CeJlr3ldUfGQ&sig2=9zaWOEKnBTktc5V7PwnzGQ). The authorization code is obtained by directing to the authentication page of olx.com.br that, after authenticating the user with login and password, will be redirected again for application along with the authorization code. observe the example below:

| Param | Description| 
| ------ | ------ |
| client_id | Identifies the client that is sending the request. The value of the parameter must be Identical to the value provided by olx.com.br during registration of the application.
| redirect_uri | Determines to which server the response of the request will be sent, only valid and registered url by olx.com
| scope | Identifies the type of access to the olx.com.br API that the application is requesting.
| state | Provides any value that may be useful to the application upon receiving the request response.

#### Permission
When requesting the access key the client must request permissions through the scope parameter. These requests will be sent to the user so that he can allow access or not. The scope parameter value is expressed as a case-sensitive list separated by spaces, regardless of order.

| Value | Description| 
| ------ | ------ |
| basic_user_info | Allows access to basic user information. Ex: full name and email.
| autoupload | Allows access to the autouploads system (Sending ads in a Automatic)

```sh
$inventory = new Inventory(array(
  'client_id'=>'{client_id}',
  'client_secret'=>'{client_secret}',
  'scope'=>'autoupload',
  'redirect_uri' => '{rediret_uri}',
  'state'=>'{state}'
));

$url = $inventory->getLoginUrl();
```

An URL example: https://auth.olx.com.br/oauth?scope=basic_user_info&state=/profile&redirect_uri=https://yourserver.com/code&response_type=code&client_id= ​1055d3e698d289f2af8663725127bd4b

If requested permission to the user is successful server sends to the client through the parameters in the URI:

| Value | Description| 
| ------ | ------ |
| code | Authorization code used to request permission to access a user's resources. Expires 10 minutes after being generated and can not be reused.
| state | Provides any value that may be useful to the application upon receiving the request response.

Example of confirmation response:
https://yourserver.com/code?state=/profile&code=4gP7q7W91a­oMsCeLvIaQm6bTrgtp7 


### Step 2 - Access Token
After receiving the authorization code, the user can exchange for an access key through the function getAccessToken ()

| Param | Description| 
| ------ | ------ |
| code | Authorization code used to request permission to access resources from a user. Expires 10 minutes after being generated and can not be reused.
| client_id | Identifies the client that is sending the request. The value of the parameter must be Identical to the value provided by olx.com.br during registration of the application.
| client_secret | The client's security key obtained in the application registry in olx.com.br.
| redirect_uri | Determines to which server the request response will be sent.

```sh
$inventory = new Inventory(array(
  'code'=>'{code}',
  'client_id'=>'{client_id}',
  'client_secret'=>'{client_secret}',
  'redirect_uri' => '{rediret_uri}'
));

$token = $inventory->getAccessToken();
```
If the request succeeds, the user will receive the access token to use OLX features.

## Features
List of functions and operations that can be used by sdk

### GetMakes
Returns the list of tags and their encoding in iCarros
```sh
$inventory = new Inventory($token);
$maker = $inventory->getMaker();
```
return: array

### GetModels
Returns the list of templates and their encoding in olx. The tag is associated with make id.
```sh
$data['id_maker']={id};
$inventory = new Inventory($token);
$models = $inventory->getModels($data);
```
return: array

### getVersionModels
Returns the list of versions and their encoding in OLX. Versions are a specialization of the model and are associated with it by the id.
```sh
$data['id_maker']={id};
$data['id_model']={id};

$inventory = new Inventory($token);
$models = $inventory->getVersionModels($data);
```
return: array

### getFuelTypes
Returns the encoding for the fuel field to be used for ad inclusion
```sh
$inventory = new Inventory($token);
$models = $inventory->getFuelTypes();
```
return: array

### getGearbox
Returns automatic and manual gearbox
```sh
$inventory = new Inventory($token);
$models = $inventory->getGearbox();
```
return: array

### getDoors
Returns doors number 
```sh
$inventory = new Inventory($token);
$models = $inventory->getDoors();
```
return: array

### getEnd_tag
Return last plate number
```sh
$inventory = new Inventory($token);
$models = $inventory->getEnd_tag();
```
return: array

### getCar_features
Return car features
```sh
$inventory = new Inventory($token);
$models = $inventory->getCar_features();
```
return: array

### Create Ad
create a new Ad

| Param | Required | Type | Description|
| ----- | -------- | ---- | ---------- |
| id | Yes | Numeric string | ad identify
| subject | Yes | String | Ad title
| body | Yes | String | Ad description
| phone | Yes | Numeric string | contact phone
| price | No | Integer | Ad price (not allow cents)
| zipcode | Yes | Numeric string | seller/store zipcode
| vehicle_brand | No | Numeric string | vehicle mark
| vehicle_model | No | Numeric string | vehicle model
| vehicle_version | No | Numeric string | vehicle version 
| regdate | No | Numeric string | Year of manufacture
| gearbox | Yes | Numeric string | kind of gearbox
| fuel | Yes | Numeric string | kind of fuel
| cartype | No | Numeric string | kind of type
| mileage | Yes | Numeric string | Traveled Away
| doors | No | Numeric string | door number
| end_tag | No | Numeric string | end of the plate
| car_features | No | Array numeric | features
| images | No | Array string | Ad images url array 

 - Important for images array: not allowed repeated URLs, max 6 images, first image will be the Main picture

```sh
$data['id']='{identify}';
$data['subject']='{title}';
$data['body']='{description}';
$data['phone']={phone};
$data['price']={price};
$data['zipcode']='{zipcode}';
$data['vehicle_brand']= '{brand}';
$data['vehicle_model']= '{model}';
$data['vehicle_version']= '{version}';
$data['regdate']= '{year}';
$data['gearbox']='{gearbox type}';
$data['fuel']='{fuel type}';
$data['mileage']='{mileage}';
$data['cartype']='{car type}';
$data['doors']='{doors}';
$data['end_tag']='{end tags}';
$data['car_features']=[{features1}, {features2}];
$data['images']=[{url1}, {url2}, {url3}];

$inventory = new Inventory($token);
$ad = $inventory->createAd($data);
```
return: array 

In array contain a string with a token to be used to access the status of the ad

See the example below:
```sh
{
"token": "06fb235e216f3095ba913654d10afee2f55eae35",
"statusCode": 0,
"statusMessage": "The ads were imported and will be processed",
"errors": []
}
```

### getStatusAd
After crate a new ad, the ads will go to the olx.com import queue to be processed. You can check the import status with the token returned

```sh
$data['ad_token']='{token_returned_in_add}';
$inventory = new Inventory($token);
$response = $inventory->getStatusAd($data);
```

#### Expected Return
autoupload_status 
- done: All ads were processed
- pending: At least one ad is still in the queue import

status
- peding: ad will be processed
- error: error in ad
- queued: The ad was entered and will be activated soon
- accepted: actived ad
- refused: ad not active

message: Warning messages about errors occurred

list_id: ad id if the ad was actived

### deleteAd
It deletes the ad from olx's base.

```sh
$data['id']='{ad_id}';
$inventory = new Inventory($token);
$response = $inventory->deleteAd($data);
```

### getPublishedAd
Returns all ads that have already been processed and are active

```sh
$inventory = new Inventory($token);
$response = $inventory->getPublishedAd();
```
return: array

# Error
```sh
array(2) { 
    ["status"]=> string(4) "fail" 
    ["message"]=> string(101) "Mensage Error!" 
  } 
```

# License
OLX SDK is Copyright © 2017 haganicolau.

It is free software, and may be redistributed under the terms specified in the [LICENSE.txt](https://github.com/Veloccer/olx/blob/master/LICENSE.txt)