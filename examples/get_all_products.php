<?php
error_reporting(E_ALL);
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

//TRAIGO EL TOKEN DEL USUARIO LOGUEADO
                if($_GET['code'] || $_SESSION['access_token']) {

                // If code exist and session is empty
                if($_GET['code'] && !($_SESSION['access_token'])) {
                	// If the code was in get parameter we authorize
                    $user = $meli->authorize($_GET['code'], $redirectURI);

                    // Now we create the sessions with the authenticated user
                    $_SESSION['access_token'] = $user['body']->access_token;
                    $access_token = $user['body']->access_token;
					$client_id = $user['body']->client_id;
					$_SESSION['expires_in'] = time() + $user['body']->expires_in;
                    $_SESSION['refresh_token'] = $user['body']->refresh_token;
                } else {
                	// We can check if the access token in invalid checking the time
                    if($_SESSION['expires_in'] < time()) {
                    	try {
                        // Make the refresh proccess
                        	$refresh = $meli->refreshAccessToken();

                            // Now we create the sessions with the new parameters
                            $_SESSION['access_token'] = $refresh['body']->access_token;
							$access_token = $refresh['body']->access_token;
							$client_id = $refresh['body']->client_id;
                            $_SESSION['expires_in'] = time() + $refresh['body']->expires_in;
                            $_SESSION['refresh_token'] = $refresh['body']->refresh_token;
                        } catch (Exception $e) {
                        	echo "Exception: ",  $e->getMessage(), "\n";
                  		}
                   }
                }
				}
 print_r($_SESSION);				
//FIN TRAIGO EL TOKEN DEL USUARIO LOGUEADO				
//$params = array();


//echo "access_token:   ".$access_token = $_SESSION['access_token2'];
//echo "user_id:    ".$user_id	  = $_SESSION['client_id'];


//Traer el token de usuario
#https://developers.mercadolibre.com.ar/es_ar/server-side
#https://api.mercadolibre.com/oauth/token?grant_type=client_credentials&client_id=YOUR_CLIENT_ID&client_secret=YOUR_SECRET_KEY



$listings = $meli -> get('/users/' . $client_id . '/items/search', array('status'=>'active', 'seller' => $client_id, 'access_token' => $access_token));
echo 'LISTANDINGGGG: --------------------------<br>';
print_r($listings['body']->results);
echo '<pre>';
print_r($listings);
echo '</pre>';

/*echo '<pre>';
print_r($result);
echo '</pre>';*/