
$(document).ready(function() {
	

	$( "#add-prod" ).click(function()//Agrego producto
	{
		
		var id_val	= $("#id_val").val();
		id_val++;
		//alert(id_val);
		if(id_val.length==0)
		{	
			var cloneCount = 1;
			$("#id_val").val("0");
		}
			
		if(cloneCount<1)
		{	
			var cloneCount = 1;
		}

		if(id_val>1)
		{	
			var cloneCount = id_val;
		}
							
		canticero =  false;
		var maxcantiprod = parseInt($('#selcantiprod').attr('max'));
		var cantidad = parseInt($('#selcantiprod').val());
		
		if (isNaN(cantidad)) 
		{
			cantidad = 1;
			canticero =  true;
		}
		
		var veoid = parseInt($("#selidprod").val());

		var todook = true;
		var mensaje = "";

		if (isNaN(veoid)) 
		{
			todook = false;
		}
				
		/*if(cantidad>maxcantiprod)
		{
			todook = false;
			mensaje = "La cantidad supera al stock, agregue un valor igual o menor a:"+ maxcantiprod;
		}*/
		
		if((veoid.length<1) && (cantidad.length<1))
		{
			todook = false;
			mensaje = "Verifique los valores ingresados";
		}
		
		if(todook == false)
		{
			//alert("oops");
			swal({ 
			  title: "Oopss..",
			   text: mensaje,
				type: "error" 
			  },
			  function(){
				
			});
		}else{//esta todo bien

			$("#div_prod").clone().attr('id','div_prod'+cloneCount++).appendTo("#clones");
			
			var nuevoid = 'div_prod'+(cloneCount-1);
	
			document.getElementById(''+nuevoid).style.display = 'block';
			
			//GET
			var id 		= $("#selidprod").val();
			var nombre	= $("#selnombreprod").val();
			var canti 	= $("#selcantiprod").val();
			var precio  = $("#selpreciofinal").val();
			
			//SET
			$("#"+nuevoid+"").children().val(id);
			$("#"+nuevoid+" div").children().eq(0).val(nombre);
			
			if(canticero == true)
			{
				$("#"+nuevoid+" div").children().eq(1).val(cantidad);
			}else{
				$("#"+nuevoid+" div").children().eq(1).val(canti);
			}
			
			
			$("#"+nuevoid+" div").children().eq(2).val(precio);
			
			//SET readonly
			
			$("#"+nuevoid+"").children().prop("readonly", true);
			$("#"+nuevoid+" div").children().eq(0).prop("readonly", true);
			$("#"+nuevoid+" div").children().eq(1).prop("readonly", true);
			$("#"+nuevoid+" div").children().eq(2).prop("readonly", true);
			
			//Limpio
			$("#selnombreprod").val('');
			$("#selidprod").val('');
			$("#selcantiprod").val('');
			$("#selpreciofinal").val('');
			//incremento el puntero
			$("#id_val").val(id_val);		
		}
	
	});
////////////////////////////////


	var typingTimer; 
	var doneTypingInterval = 500;  //time in ms, 5 second for example
	var $input = $('#selnombreprod');
			
	$input.on('keyup', function () {
		 clearTimeout(typingTimer);
		 typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});
			
	$input.on('keydown', function () {
		clearTimeout(typingTimer);
	});
			
	function doneTyping () {

	var producto = $('#selnombreprod').val();
	
		if( producto.length > 2 )  
		{ 
			
			var producto = $('#selnombreprod').val();
			$.ajax({
				type: "POST",
				url: "consultoproductodisponible.php",
				data: "nombreproducto="+ producto ,
				success: function(html){
					$("#displayProducto").html(html).show();
					$('#displayProducto').change();
				}
			});
						
		}	 			  
	}
			
											 
});

function fillProd(id,nombre,preciofinal,cantidad)
{ 
	$("#selnombreprod").val(nombre);
	$("#selidprod").val(id);
	$("#selpreciofinal").val(preciofinal);	
		
	//document.getElementById('lidisplayprod').style.display = 'none';
	$('.lidisplayprod').hide();

	$("#selcantiprod").attr({
       "max" : cantidad,        // substitute your own
       "min" : 1          // values (or variables) here
    });
}

$(document).ready(function() {
	//ACA le asigno el evento click a cada boton de la clase bt_plus y llamo a la funcion addField
		$(".bt_del").each(function (el)
		{
			$(this).bind("click",delRow);
		});
		$(".bt_delGED").each(function (el)
		{
			$(this).bind("click",delRowGED);
		});	
		$(".bt_delFI").each(function (el)
		{
			$(this).bind("click",delRowFI);
		});	
		$(".bt_delMED").each(function (el)
		{
			$(this).bind("click",delRowMED);
		});	
		
											 
});
							



function delRow(element) 
{
	var aliminar = $(element).closest("div").attr("id");
	$("#"+aliminar).remove();
}


