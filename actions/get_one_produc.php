<?php
session_start();
error_reporting(E_ALL);
require '../Meli/meli.php';
require '../configApp.php';
require '../Meli/functions.php';
$meli = new Meli($appId, $secretKey);

$access_token 	= $_SESSION['access_token'];
$client_id	  	= $_SESSION['client_id'];
$user_id		= $_SESSION['user_id'];

$id_prod		= $_GET['id_prod'];

$listings2 = $meli -> get('/items?ids='.$id_prod);

//$result2 = $listings2['body']->results;
#echo '<pre>';
#print_r($listings2);
#echo '</pre>';

//$obj = json_decode($listings2);

$array = json_decode(json_encode($listings2),true);


//$array = json_decode($listings2);
//echo $character->body;

$description = $meli -> get('/items/'.$id_prod.'/description');	
$local_des = $description['body']->plain_text;
/*
echo '<pre>';
print_r($description);
echo '</pre>';
*/
/*$array_description = json_decode(json_encode($description),true);

foreach($array_description as $arr_des)
{	echo 1;
	echo $local_des1 = $arr_des['plain_text'];
	foreach($arr_des as  $arr_des2)
	{echo 2;
		echo $local_des = $arr_des2['plain_text'];
	}
}*/
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
    
    <link rel="stylesheet" href="../css/box.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
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
		<?php 	
		foreach($array as $mydata)
		{			
			foreach($mydata as $key => $prods)
			{
				foreach($prods as $key2 => $prods2)
				{
					if(strlen(trim($prods2['id']))!=0)
					{
		?>
		<div class="row">
        	<div class="col-lg-12">
            	<div class="ibox bg-boxshadow mb-50">
                	<!-- Title -->
                    <div class="ibox-title basic-form mb-30">
                    	<h4>PRODUCTO: <?php echo $prods2['id']; ?> - <?php echo $prods2['title']; ?></h4><a href="<?php echo trim($prods2['permalink']); ?>" target="_blank" ><input name="verml" type="button"  value="VER EN ML" class="btn m-2 btn-xl btn-warning"/></a>
                    </div>
                    <!-- Ibox-content -->
                    <div class="ibox-content">
                    	<form method="post">
                        <!-- Line -->
                        <div class="ap-line-dashed"></div> 
                        <?php if(trim($prods2['status'])=="active"){ ?>
                        <div class="form-group  row">
                        	<div class="col-sm-10">
                            	<div class="alert alert-success alert-dismissible fade show">Publicación Activa</div>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <?php if(trim($prods2['status'])=="paused"){ ?>
                        <div class="form-group  row">
                        	<div class="col-sm-10">
                            	<div class="alert alert-warning">Publicación Pausada</div>
                                	<span class="input-group-prepend"><a href="<?php echo $prods2['permalink']; ?>"><button type="button" class="btn btn-primary">VER PUBLICACION</button></a> </span>
                            </div>
                        </div>  
                                          
                        <?php } ?>
                            
                        <!-- Line -->
                        <div class="ap-line-dashed"></div>                        
                        <div class="form-group  row"><label class="col-sm-3 col-form-label">Categoria</label>
                        	<div class="col-sm-9"><input type="text" class="form-control" value="<?php echo get_caterogy_desc($prods2['category_id']); ?>" disabled="disabled"></div>
                        </div>
                        <!-- Line -->
                        <div class="ap-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 col-form-label">Precio ($AR):</label>
                        	<div class="col-sm-9"><input type="text" class="form-control" value="<?php echo $prods2['price']; ?>"></div>
                        </div>
                        <!-- Line -->
                        <div class="ap-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 col-form-label">Cantidad Disponible (Para venta)</label>
                        	<div class="col-sm-9"><input type="text" class="form-control" value="<?php echo $prods2['available_quantity']; ?>"></div>
                        </div>                        
                        <!-- Line -->
                        <div class="ap-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 col-form-label">Cantidad Vendidos</label>
                        	<div class="col-sm-9"><input type="text" class="form-control" value="<?php echo $prods2['sold_quantity']; ?>" disabled="disabled" ></div>
                        </div>
                        <!-- Line -->
                        <div class="ap-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 col-form-label">Condición</label>
                        	<div class="col-sm-9"><input type="text" class="form-control" value="<?php echo $prods2['condition']; ?>"></div>
                        </div>
                        <!-- Line -->
                        <div class="ap-line-dashed"></div>
                        <div class="form-group  row"><label class="col-sm-3 col-form-label">Descripción del producto</label>
                        	<div class="col-sm-9"><textarea name="" cols="100%" rows="10" class="form-control"><?php echo $local_des; ?></textarea></div>
                        </div>
 						
                        <!-- Line -->
                        <div class="ap-line-dashed"></div>
                        
                     	<?php 	
							foreach($prods2['sale_terms'] as $key2 => $prods3)
							{
						?>   
                        <div class="form-group row"><label class="col-sm-3 col-form-label">GARANTIA</label>
                         	<div class="col-sm-9">
                               	<select class="form-control mb-15" name="account">
                                	<option <?php if(trim($prods3['value_name'])=="Con garantía") echo 'selected'; ?> >CON GARANTIA</option>
                                    <option <?php if(trim($prods3['value_name'])=="Sin garantía") echo 'selected'; ?> >SIN GARANTIA</option>
                                </select>
                                </div> 
                        </div>                          
                        <?php 	
							}
						?>      

					</form>
				</div>
        	</div>
    	</div>
	</div>
                        
	<!--IMAGENES-->
	<div class="row">
		<?php 	
			foreach($prods2['pictures'] as $key_pic => $pictures)
			{
		?>  

            <div class="col-md-3 col-sm-4">
                <div class="boxing">
                    <img class="img-responsive" src="<?php echo $pictures['url']; ?>" alt="">
                    <div class="box-content">
                        <div class="content">
                            <h3 class="title">¿Queres eliminar esta foto?</h3>
                            <!--<span class="post">Front End Developer</span>-->
                            <ul class="icon">
                                <li><a href="#"><i class="fas fa-trash"></i></a></li>
                                <!--<li><a href="#"><i class="fa fa-link"></i></a></li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div> 
		<?php 	
			}
		?>
            <div class="col-md-3 col-sm-4">
                <div class="boxing">
                    <img class="img-responsive" src="../img/plus.png" alt="">
                    <div class="box-content">
                        <div class="content">
                            <h3 class="title">¿Queres agregar una foto?</h3>
                            <ul class="icon">
                                <li><a href="#"><i class="fas fa-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> 
                             
	</div>        
    <!--FIN IMAGENES-->                                         
          	<?php
						}
					}			
				}
			} 
			?>

	<div class="row">
		<div class="form-group mb-0 row">
			<div class="col-12 ibox-title basic-form mb-30" style="text-align: right;">
            	<button class="btn btn-white btn-sm mr-10" type="submit">Cancelar</button>
           		<button class="btn btn-primary btn-sm" type="submit">Guardar Cambios</button>
            </div>
    	</div>
    </div>
                                            
	</div><!-- fin container -->


    </body>
</html>