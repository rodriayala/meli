<?php
session_start();
error_reporting(E_ALL);
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

echo "<br>**********<br>";
echo "<br>access_token:   ".$access_token = $_SESSION['access_token'];
echo "<br>user_id:    ".$client_id	  = $_SESSION['client_id'];

echo "<br>**********<br>";
print_r($_SESSION);	
echo "<br>**********<br>";			
//FIN TRAIGO EL TOKEN DEL USUARIO LOGUEADO				
//$params = array();


//echo "access_token:   ".$access_token = $_SESSION['access_token2'];
//echo "user_id:    ".$user_id	  = $_SESSION['client_id'];


//Traer el token de usuario
#https://developers.mercadolibre.com.ar/es_ar/server-side
#https://api.mercadolibre.com/oauth/token?grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_SECRET_KEY



//$listings = $meli -> get('/users/' . $client_id . '/items/search', array('status'=>'active', 'seller' => $client_id, 'access_token' => $access_token));

$listings = $meli -> get('/users/'.$client_id.'/items/search?access_token='.$access_token);
//$listings = $meli -> get('/sites/MLA/search?seller_id='.$client_id);
echo "<br>**********<br>";
echo "prubea ";

echo 'LISTANDINGGGG: --------------------------<br>';
print_r($listings['body']->results);
echo '<pre>';
print_r($listings);
echo '</pre>';

/*echo '<pre>';
print_r($result);
echo '</pre>';*/