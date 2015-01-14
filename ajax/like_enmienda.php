<?php
include_once "../lib/functions.php";

if(isset($_POST['cuenta']))
{
	$enmienda = $_POST['enmienda'];
	$usuario  = $_POST['usuario_id'];
	$voto     = $_POST['cuenta'];
	
    echo ajaxLikeEnmienda($enmienda, $usuario, $voto);
}

?>