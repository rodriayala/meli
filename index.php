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
	<link href="../assets/datatables.min.css" rel="stylesheet" type="text/css">
	<link href="../css/estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/breadcrumb.css" rel="stylesheet" type="text/css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/bootstrap-3.3.7.min.css">
	<script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/bootstrap-3.3.7.js"></script>
    <!-- <link rel="stylesheet" href="/getting-started/style.css" /> <script src="script.js"></script>--> 
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
				echo '<a href="examples/actions/get_all_products.php">VER TODOS LOS PRODUCTOS</a>';
				echo '<a href="examples/actions/publish_item.php">PUBLICAR PRODUCTO</a>';
                echo '</pre>';

                } else {
                	echo '<p><a alt="Ingresar usando MercadoLibre oAuth 2.0" class="btn" href="' . $meli->getAuthUrl($redirectURI, Meli::$AUTH_URL[$siteId]) . '">Authenticate</a></p>';
                }
             ?></div>
     </div>        
    <!-- FIN LOGUEARSE -->
	</div><!-- fin container -->


    </body>
</html>