<?php
include_once "../lib/functions.php";

if(isset($_POST["propuesta_id"]) && isset($_POST["usuario_id"]))
{
	$propuesta_id = $_POST["propuesta_id"];
	$usuario_id   = $_POST["usuario_id"];
	$enmienda     = $_POST["enmienda"];
	
    ajaxCrearEnmienda($usuario_id, $propuesta_id, $enmienda);
}

?>