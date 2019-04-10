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
print_r($listings['body']->results);
//print_r($listings);
echo '</pre>';
*/
$result = $listings['body']->results;
$quest_prods = "";
foreach($result as $key => $id_prods)
{
	if(strlen(trim($quest_prods))==0)
	$quest_prods = $id_prods;
	else
	$quest_prods = $quest_prods.",".$id_prods;
}
//echo "lista final: ".$quest_prods;
$listings2 = $meli -> get('/items?ids='.$quest_prods);

//$result2 = $listings2['body']->results;
echo '<pre>';
//print_r($listings2);
echo '</pre>';

//$obj = json_decode($listings2);

$array = json_decode(json_encode($listings2),true);

echo '<pre>';
//print_r($array);
echo '</pre>';

//$array = json_decode($listings2);
//echo $character->body;

	
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
	<link href="../css/estilos.css" rel="stylesheet" type="text/css">
	<link href="../css/breadcrumb.css" rel="stylesheet" type="text/css">    
    <link rel="stylesheet" href="../css/bootstrap-3.3.7.min.css">
    <script src="../js/jquery-3.3.1.min.js"></script>
	<script src="../js/bootstrap-3.3.7.js"></script>
    
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


        <table class="table table-striped">
          <thead>
          <tr>
            <td>CODIGO MERCADO LIBRE PRODUCTO</td>
            <td>NOMBRE PRODUCTO</td>
            <td>CANT.</td>
            <td>PRECIO</td>
          </tr>
          </thead>  
          <tbody><?php 	
			foreach($array as $mydata)
			{			
				foreach($mydata as $key => $prods)
				{

					foreach($prods as $key2 => $prods2)
					{echo "---".$prods2['id']."---";
						if(strlen(trim($prods2['id']))!=0)
						{
				?>	
              <tr>
                <td><?php echo $prods2['id']; ?></td>
                <td><?php echo $prods2['title']; ?></td>
                <td><?php echo $prods2['available_quantity']; ?></td>
                <td><?php echo $prods2['price']; ?></td>
              </tr>
          	<?php
						}
					}			
				}
			} 
			?>
          </tbody>
        </table>

	</div><!-- fin container -->


    </body>
</html>