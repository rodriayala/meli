// JavaScript Document
$(document).ready(function(){

	/* Get Edit ID  */
	$(".edit-link").click(function()
	{
		var id = $(this).attr("id");
		var edit_id = id;
		if(confirm('¿Está seguro que desea editar el ID Nº = ' +edit_id+' ?'))
		{
			$(".content-loader").fadeOut('slow', function()
			 {
				$(".content-loader").fadeIn('slow');
				$(".content-loader").load('abm_productos/edit_form.php?edit_id='+edit_id);
				$("#btn-add").hide();
				$("#btn-view").show();
			});
		}
		return false;
	});
	/* Get Edit ID  */
	

});