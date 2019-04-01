<?php
session_start();
error_reporting(E_ALL);
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

//echo "<br>**********<br>";
$access_token = $_SESSION['access_token'];
$client_id	  = $_SESSION['client_id'];
$user_id = $_SESSION['user_id'];
/*
echo "<br>**********<br>";
print_r($_SESSION);	
echo "<br>**********<br>";	
*/		

$listings = $meli -> get('/users/'.$user_id.'/items/search?access_token='.$access_token);
//$listings = $meli -> get('/sites/MLA/search?seller_id='.$client_id);

//print_r($listings['body']->results);
/*echo '<pre>';
print_r($listings);
echo '</pre>';
*/
echo
'<table class="table table-striped">
  <thead>
  <tr>
    <td>CODIGO MERCADO LIBRE PRODUCTO</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </thead>  
  <tbody> 
  <tr>
    <td>'.$listings['body'][0]->results.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>';
