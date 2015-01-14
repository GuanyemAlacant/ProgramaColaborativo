<?php
include_once "../lib/functions.php";

if(isset($_POST['cuenta']))
{
	$propuesta = $_POST['propuesta'];
	$usuario   = $_POST['usuario_id'];
	$voto      = $_POST['cuenta'];
	
    echo ajaxLikePropuesta($propuesta, $usuario, $voto);
}

?>