<?php
include_once "../lib/functions.php";

if(isset($_POST["enmienda_id"]) && isset($_POST["usuario_id"]))
{
	$propuesta_id = $_POST["propuesta_id"];
	$enmienda_id  = $_POST["enmienda_id"];
	$usuario_id   = $_POST["usuario_id"];
	$comentario   = $_POST["comentario"];
	
    ajaxCrearComentario($usuario_id, $propuesta_id, $enmienda_id, $comentario);
}

?>