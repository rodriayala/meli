<?php
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

$params = array();

#$url = '/sites/' . $siteId;

#$url = "/users/{Cust_id}/items/search?access_token=$ACCESS_TOKEN";

#$result = $meli->get($url, $params);



/*$params = array(
'q' => 'dvd'
);
 
$result = $meli->get('/sites/MLV/search', $params);
*/

$access_token = $_SESSION['access_token'];

$listings = $meli -> get('/users/' . $user_id . '/items/search', array('status'=>'active', 'seller' => $user_id, 'access_token' => $access_token));
echo 'listings: --------------------------<br>';
print_r($listings['body']->results);


/*echo '<pre>';
print_r($result);
echo '</pre>';*/