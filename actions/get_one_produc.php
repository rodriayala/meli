<?php
session_start();
error_reporting(E_ALL);
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);

$access_token 	= $_SESSION['access_token'];
$client_id	  	= $_SESSION['client_id'];
$user_id		= $_SESSION['user_id'];

$id_prod		= $_GET['id_prod'];

$listings2 = $meli -> get('/items?ids='.$id_prod);

//$result2 = $listings2['body']->results;
echo '<pre>';
print_r($listings2);
echo '</pre>';

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
                        	<div class="col-sm-9"><input type="text" class="form-control" value="<?php echo $prods2['category_id']; ?>"></div>
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
                        	<div class="col-sm-9"><input type="text" class="form-control" value="<?php echo $prods2['sold_quantity']; ?>"></div>
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
                        <div class="form-group row"><label class="col-sm-2 col-form-label">GARANTIA</label>
                         	<div class="col-sm-10">
                               	<select class="form-control mb-15" name="account">
                                	<option <?php if(trim($prods3['value_name'])=="Con garantía") echo 'selected'; ?> >CON GARANTIA</option>
                                    <option <?php if(trim($prods3['value_name'])=="Sin garantía") echo 'selected'; ?> >SIN GARANTIA</option>
                                </select>
                                </div> 
                        </div>                          
                        <?php 	
							}
						?>  
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Help text</label>
                                                <div class="col-sm-10"><input type="text" class="form-control"> <span class="form-text mb-15-none">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                                                </div>
                                            </div>
                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Password</label>

                                                <div class="col-sm-10"><input type="password" class="form-control" name="password"></div>
                                            </div>
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Placeholder</label>

                                                <div class="col-sm-10"><input type="text" placeholder="placeholder" class="form-control"></div>
                                            </div>
                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-lg-2 col-form-label">Disabled</label>

                                                <div class="col-lg-10"><input type="text" disabled="" placeholder="Disabled input here..." class="form-control"></div>
                                            </div>
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-lg-2 col-form-label">Static control</label>

                                                <div class="col-lg-10">
                                                    <p class="form-control-static">email@example.com</p>
                                                </div>
                                            </div>
                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Checkboxes and radios <br> <small class="text-navy">Normal Bootstrap elements</small></label>

                                                <div class="col-sm-10">
                                                    <div><label> <input type="checkbox" value=""> Option one is this and that—be sure to include why it's great </label></div>
                                                    <div><label> <input type="radio" checked="" value="option1" id="optionsRadios1" name="optionsRadios"> Option one is this and that—be sure to include why it's great </label></div>
                                                    <div><label> <input type="radio" value="option2" id="optionsRadios2" name="optionsRadios"> Option two can be something else and selecting it will deselect option one </label></div>
                                                </div>
                                            </div>
                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Inline checkboxes</label>
                                                <div class="col-sm-10">
                                                    <label class="mr-3"><input type="checkbox" value="option1" id="inlineCheckbox1"> a</label>
                                                    <label class="checkbox-inline mr-3">
                                                        <input type="checkbox" value="option2" id="inlineCheckbox2"> b</label>
                                                    <label><input type="checkbox" value="option3" id="inlineCheckbox3"> c</label>
                                                </div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Checkboxes &amp; radios <br><small class="text-navy">Custom elements</small></label>
                                                <div class="col-sm-10">
                                                    <div class="i-checks"><label> <input type="checkbox" value=""> <i></i> Option one </label></div>
                                                    <div class="i-checks"><label> <input type="checkbox" value="" checked=""> <i></i> Option two checked </label></div>
                                                    <div class="i-checks"><label> <input type="checkbox" value="" disabled="" checked=""> <i></i> Option three checked and disabled </label></div>
                                                    <div class="i-checks"><label> <input type="checkbox" value="" disabled=""> <i></i> Option four disabled </label></div>
                                                    <div class="i-checks"><label> <input type="radio" value="option1" name="a"> <i></i> Option one </label></div>
                                                    <div class="i-checks"><label> <input type="radio" checked="" value="option2" name="a"> <i></i> Option two checked </label></div>
                                                    <div class="i-checks"><label> <input type="radio" disabled="" checked="" value="option2"> <i></i> Option three checked and disabled </label></div>
                                                    <div class="i-checks"><label> <input type="radio" disabled="" name="a"> <i></i> Option four disabled </label></div>
                                                </div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Inline checkboxes</label>
                                                <div class="col-sm-10">
                                                    <label class="checkbox-inline i-checks mr-3"> <input type="checkbox" value="option1"> a</label>
                                                    <label class="i-checks mr-3"> <input type="checkbox" value="option2"> b</label>
                                                    <label class="i-checks mr-3"> <input type="checkbox" value="option3"> c</label>
                                                </div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Select</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control mb-15" name="account">
                                                        <option>option 1</option>
                                                        <option>option 2</option>
                                                        <option>option 3</option>
                                                        <option>option 4</option>
                                                    </select>

                                                    <div class="mt-30">
                                                        <select class="form-control" multiple="">
                                                            <option>option 1</option>
                                                            <option>option 2</option>
                                                            <option>option 3</option>
                                                            <option>option 4</option>
                                                        </select></div>
                                                </div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group row has-success"><label class="col-sm-2 col-form-label">Input with success</label>
                                                <div class="col-sm-10"><input type="text" class="form-control"></div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group row has-warning"><label class="col-sm-2 col-form-label">Input with warning</label>
                                                <div class="col-sm-10"><input type="text" class="form-control"></div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group  row has-error"><label class="col-sm-2 col-form-label">Input with error</label>

                                                <div class="col-sm-10"><input type="text" class="form-control"></div>
                                            </div>

                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Control sizing</label>

                                                <div class="col-sm-10">
                                                    <input type="text" placeholder=".form-control-lg" class="form-control form-control-lg mb-15">
                                                    <input type="text" placeholder="Default input" class="form-control mb-15"> <input type="text" placeholder=".form-control-sm" class="form-control form-control-sm"></div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Column sizing</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-md-2"><input type="text" placeholder=".col-md-2" class="form-control"></div>
                                                        <div class="col-md-3"><input type="text" placeholder=".col-md-3" class="form-control"></div>
                                                        <div class="col-md-4"><input type="text" placeholder=".col-md-4" class="form-control"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Input groups</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group mb-15">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">@</span>
                                                        </div>
                                                        <input type="text" placeholder="Username" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-15">
                                                        <input type="text" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-addon">.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-15">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">$</span>
                                                        </div>
                                                        <input type="text" class="form-control">
                                                        <div class="input-group-append">
                                                            <span class="input-group-addon">.00</span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group mb-15">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox">
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="input-group mb-15">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-addon">
                                                                <input type="radio">
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>
                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Button addons</label>

                                                <div class="col-sm-10">
                                                    <div class="input-group mb-15"><span class="input-group-prepend">
                                                            <button type="button" class="btn btn-primary">Go!</button> </span> <input type="text" class="form-control">
                                                    </div>

                                                    <div class="input-group"><input type="text" class="form-control"> <span class="input-group-append"> <button type="button" class="btn btn-primary">Go!</button> </span></div>
                                                </div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group row"><label class="col-sm-2 col-form-label">With dropdowns</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group mb-15">
                                                        <div class="input-group-prepend">
                                                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">Action </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#">Action</a></li>
                                                                <li><a href="#">Another action</a></li>
                                                                <li><a href="#">Something else here</a></li>
                                                                <li class="dropdown-divider"></li>
                                                                <li><a href="#">Separated link</a></li>
                                                            </ul>
                                                        </div>

                                                        <input type="text" class="form-control">
                                                    </div>

                                                    <div class="input-group"><input type="text" class="form-control">
                                                        <div class="input-group-append">
                                                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">Action </button>
                                                            <ul class="dropdown-menu float-right">
                                                                <li><a href="#">Action</a></li>
                                                                <li><a href="#">Another action</a></li>
                                                                <li><a href="#">Something else here</a></li>
                                                                <li class="dropdown-divider"></li>
                                                                <li><a href="#">Separated link</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Segmented</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group mb-15">
                                                        <div class="input-group-prepend">
                                                            <button tabindex="-1" class="btn btn-white" type="button">Action</button>
                                                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"></button>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#">Action</a></li>
                                                                <li><a href="#">Another action</a></li>
                                                                <li><a href="#">Something else here</a></li>
                                                                <li class="dropdown-divider"></li>
                                                                <li><a href="#">Separated link</a></li>
                                                            </ul>
                                                        </div>

                                                        <input type="text" class="form-control">
                                                    </div>
                                                    <div class="input-group"><input type="text" class="form-control">
                                                        <div class="input-group-append">
                                                            <button tabindex="-1" class="btn btn-white" type="button">Action</button>
                                                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button"></button>
                                                            <ul class="dropdown-menu float-right">
                                                                <li><a href="#">Action</a></li>
                                                                <li><a href="#">Another action</a></li>
                                                                <li><a href="#">Something else here</a></li>
                                                                <li class="dropdown-divider"></li>
                                                                <li><a href="#">Separated link</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- Line -->
                                            <div class="ap-line-dashed"></div>

                                            <div class="form-group mb-0 row">
                                                <div class="col-12">
                                                    <button class="btn btn-white btn-sm mr-10" type="submit">Cancel</button>
                                                    <button class="btn btn-primary btn-sm" type="submit">Save changes</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

		<?php 	
			foreach($prods2['pictures'] as $key_pic => $pictures)
			{
		?>  
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="boxing">
                    <img class="img-responsive" src="<?php echo $pictures['url']; ?>" alt="">
                    <div class="box-content">
                        <div class="content">
                            <h3 class="title">Hale Nur Çalışkan</h3>
                            <span class="post">Front End Developer</span>
                            <ul class="icon">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-link"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> 
		</div>
		<?php 	
			}
		?>         
        
                                             
          	<?php
						}
					}			
				}
			} 
			?>

	</div><!-- fin container -->


    </body>
</html>