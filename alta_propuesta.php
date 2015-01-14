<?php
include_once "lib/functions.php";

if(isset($_SESSION["usuario"]))
{
    
    $barrios  = 'SELECT * FROM prog_barrios';
    $sectores = 'SELECT * FROM prog_sectores';
    
	$datos    = array('user' => autentificado(),
                      'titulo' => 'Nueva propuesta',
                      'sectores' => listar($sectores),
                      'barrios' => listar($barrios));
    
    $template = $twig->loadTemplate('editar_propuesta.html');
	echo $template->render($datos);
}
else
{
	header('Location: login.php');
}

?>
