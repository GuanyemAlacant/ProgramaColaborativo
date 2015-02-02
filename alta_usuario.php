<?php
include_once "lib/functions.php";

if(isset($_POST["email_signup"]) && isset($_POST["pass_signup"]))
{
	//Con addslashes escapamos las comillas, la barra invertida y NUL (el byte NULL).
	//$nombre    = $_POST["nombre"];
	//$apellidos = $_POST["apellidos"];
	//$email     = $_POST["email_signup"];
	//$pass      = $_POST["pass_signup"];
	$nombre    = addslashes($_POST["nombre"]);
	$apellidos = addslashes($_POST["apellidos"]);
	$email     = addslashes($_POST["email_signup"]);
	$password  = addslashes($_POST["pass_signup"]);
	$barrio_id = addslashes($_POST["barrio_id"]);
	
	//Obtenemos la IP
	if(!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	alta($nombre, $apellidos, $email, $password, $ip, $barrio_id);
}
else
{	
	header('Location:index.php');
}

?>