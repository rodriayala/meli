<?php
session_start();
require 'Meli/meli.php';
require 'configApp.php';

$domain = $_SERVER['HTTP_HOST'];
$appName = explode('.', $domain)[0];

$muestro_acciones = false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PINTURERIA</title>
	<!--<link href="../assets/datatables.min.css" rel="stylesheet" type="text/css">
	<link href="../css/estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/breadcrumb.css" rel="stylesheet" type="text/css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/bootstrap-3.3.7.min.css">
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/bootstrap-3.3.7.js"></script>
     <link rel="stylesheet" href="/getting-started/style.css" /> <script src="script.js"></script>--> 

	<link href="https://github.com/rodriayala/pinta/blob/master/assets/datatables.min.css" rel="stylesheet" type="text/css">
	<link href="css/estilos.css" rel="stylesheet" type="text/css">
	<link href="css/breadcrumb.css" rel="stylesheet" type="text/css">    
    <link rel="stylesheet" href="css/bootstrap-3.3.7.min.css">
    <script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap-3.3.7.js"></script>
    
</head>
<body>
<?php include('../menu.php'); ?>
	<div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<div class="panel panel-info">
                	<div class="panel panel-heading text-rigth">
                    	<h4>USUARIO: <?php echo $apellido." ,".$nombre; ?></h4>
                    </div>
                </div> 
            </div>
        </div>



	<!-- PRIMERO LOGUEARSE -->
    <div class="row">
    	<div class="col-sm-6 col-md-6">
        	<h3>Loguear</h3>
            <p>Lo primero es loguearse, Ingresa con tu cuenta de Mercado Libre.</p>
			<?php
            	$meli = new Meli($appId, $secretKey);

                if($_GET['code'] || $_SESSION['access_token']) {

                // If code exist and session is empty
                if($_GET['code'] && !($_SESSION['access_token'])) {
                	// If the code was in get parameter we authorize
                    $user = $meli->authorize($_GET['code'], $redirectURI);

                    // Now we create the sessions with the authenticated user
                    $_SESSION['access_token'] = $user['body']->access_token;
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
                            $_SESSION['expires_in'] = time() + $refresh['body']->expires_in;
                            $_SESSION['refresh_token'] = $refresh['body']->refresh_token;
                        } catch (Exception $e) {
                        	echo "Exception: ",  $e->getMessage(), "\n";
                  		}
                   }
                }

                echo '<pre>';
                print_r($_SESSION);
				$muestro_acciones = true;
				echo '<p>USTED SE ENCUENTRA LOGUEADO</p>';
				echo '<a href="actions/get_all_products.php?code='.$_GET['code'].'">VER TODOS LOS PRODUCTOS</a>';
				echo '<br>';
				echo '<a href="actions/publish_item.php?code='.$_GET['code'].'">PUBLICAR PRODUCTO</a>';
                echo '</pre>';

				/*echo '<pre>';
				$listings2 = $meli -> get('/users/'.$_SESSION['client_id'].'?access_token='.$_SESSION['access_token']);
				echo "<br> USUARIO LOGUEADO: **********<br>";
				print_r($listings2);
				echo '</pre>';
				*/

				//echo '<pre>';
				$listings3 = $meli -> get('/users/me'.'?access_token='.$_SESSION['access_token']);
				//echo "<br> INFORMACION DE LA CUENTA LOGUEADO: **********<br>";
				$_SESSION['user_id'] = $listings3['body']->id;
				//print_r($listings3);
				//echo '</pre>';
					
				//include_once('actions/get_all_products.php');
								
                } else {
                	echo '<p><a alt="Ingresar usando MercadoLibre oAuth 2.0" class="btn" href="' . $meli->getAuthUrl($redirectURI, Meli::$AUTH_URL[$siteId]) . '">Authenticate</a></p>';
                }
             ?></div>
     </div>        
    <!-- FIN LOGUEARSE -->
	</div><!-- fin container -->


    </body>
</html>