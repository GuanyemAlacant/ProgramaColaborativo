<?php
include_once "lib/functions.php";

if(isset($_GET['sector']))
{
    $id           = $_GET['sector'];
    $buscaID      = array('id' => $id);
    $obj          = preparada($buscaID, "SELECT nombre FROM prog_sectores WHERE id=:id");
    $valoradas    = obtenerConsulta("sector", "valoradas", true);
    $consensuadas = obtenerConsulta("sector", "consensuadas", true);
    $debatidas    = obtenerConsulta("sector", "debatidas", true);
    $recientes    = obtenerConsulta("sector", "recientes", true);
    
	$datos = array(
        'id' => $id,
		'tag' => "Sector " . $obj['nombre'],
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