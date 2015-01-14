<?php
include_once "../lib/functions.php";

if(isset($_POST['cuenta']))
{
	$comentario = $_POST['comentario'];
	$usuario    = $_POST['usuario_id'];
	$voto       = $_POST['cuenta'];
	
    echo ajaxLikeComentario($comentario, $usuario, $voto);
}

?>