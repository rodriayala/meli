<?php

function get_caterogy_desc($cat_id) 
{
	$meli = new Meli($appId, $secretKey);
	$description = $meli -> get('/categories/'.$cat_id);	
	return $description['body']->name;
}