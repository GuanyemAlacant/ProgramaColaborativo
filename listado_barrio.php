<?php
include_once "lib/functions.php";

if(isset($_GET['barrio']))
{
    $id           = $_GET['barrio'];
    $buscaID      = array('id' => $id);
    $obj          = preparada($buscaID, "SELECT nombre FROM prog_barrios WHERE id=:id");
    $valoradas    = obtenerConsulta("barrio", "valoradas", true);
    $consensuadas = obtenerConsulta("barrio", "consensuadas", true);
    $debatidas    = obtenerConsulta("barrio", "debatidas", true);
    $recientes    = obtenerConsulta("barrio", "recientes", true);
    
	$datos = array(
        'id' => $id,
		'tag' => "Barrio " . $obj['nombre'],
		'user' => autentificado(),
		'valoradas' => listarpreparada($buscaID, $valoradas),
		'debatidas' => listarpreparada($buscaID, $debatidas),
		'recientes' => listarpreparada($buscaID, $recientes),
		'consensuadas' => listarpreparada($buscaID, $consensuadas)
	);
    
	$template = $twig->loadTemplate('propuestas.html');
	echo $template->render($datos);
    
//    echo "<pre>";
//    var_dump($datos);
//    echo "</pre>";
}
else
{
	header('Location:index.php');
}
?>