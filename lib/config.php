<?php

//--
// Base de datos
function obtenerBBDD()
{
    // Datos de conexión a la base de datos
    // Obtener el usuario y contraseña introducidos en /DB/database_struct.sql
    $dbinfo = 'mysql:host=localhost;dbname=programa';
    $dbuser = "sec_user";
    $dbpass = "your_own_password_here";
    
    //--
    $conn = new PDO($dbinfo, $dbuser, $dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8");
	return $conn;
}

//--
//Configuración Twig - Motor de plantillas
//Cargador de Twig
//Realpath nos da la ruta absoluta de ese directorio.
require_once realpath(dirname(__FILE__)."/../vendor/twig/twig/lib/Twig/Autoloader.php");

//Inicializamos el motor de plantillas (twig)
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(realpath(dirname(__FILE__)."/../vistas"));
$twig   = new Twig_Environment($loader);

?>