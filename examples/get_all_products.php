<?php
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

$params = array();

#$url = '/sites/' . $siteId;

/*$params = array(
'access_token' => 'dvd'
);*/
/*
$url = "/users/{Cust_id}/items/search?access_token=$ACCESS_TOKEN";
$result = $meli->get($url, $params);

echo '<pre>';
print_r($result);
echo '</pre>';

echo "new_token:  ".$access_token = $result['body']->access_token;
*/

echo "access_token:   ".$access_token = $_SESSION['access_token'];
echo "user_id:    ".$user_id	  = $_SESSION['client_id'];


//Traer el token de usuario
#https://developers.mercadolibre.com.ar/es_ar/server-side
#https://api.mercadolibre.com/oauth/token?grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_SECRET_KEY



$listings = $meli -> get('/users/' . $user_id . '/items/search', array('status'=>'active', 'seller' => $user_id, 'access_token' => $access_token));
echo 'LISTANDINGGGG: --------------------------<br>';
print_r($listings['body']->results);
echo '<pre>';
print_r($listings);
echo '</pre>';

/*echo '<pre>';
print_r($result);
echo '</pre>';*/