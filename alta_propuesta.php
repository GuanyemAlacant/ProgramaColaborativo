<?php
include_once "lib/functions.php";

if(isset($_SESSION["usuario"]))
{
    
    $barrios   = 'SELECT * FROM prog_barrios ORDER BY distrito_id, id';
    $sectores  = 'SELECT * FROM prog_sectores';
    $distritos = 'SELECT * FROM prog_distritos';
    
	$datos    = array('user' => autentificado(),
                      'titulo' => 'Nueva propuesta',
                      'sectores' => listar($sectores),
                      'barrios' => listar($barrios),
                     'distritos' => listar($distritos));
    
    $template = $twig->loadTemplate('editar_propuesta.html');
	echo $template->render($datos);
}
else
{
	header('Location: login.php');
}

?>
