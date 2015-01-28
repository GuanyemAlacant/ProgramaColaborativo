<?php
include_once "lib/functions.php";

if(isset($_POST["email_login"]) && isset($_POST["pass_login"]))
{
	$email = addslashes($_POST["email_login"]);
	$pass  = $_POST["pass_login"];
	
	login($email, $pass);	
}
else
{	
	header('Location:index.php');
}

?>