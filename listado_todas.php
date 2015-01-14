<?php
include_once "lib/functions.php";

$valoradas    = obtenerConsulta("", "valoradas", false);
$consensuadas = obtenerConsulta("", "consensuadas", false);
$debatidas    = obtenerConsulta("", "debatidas", false);
$recientes    = obtenerConsulta("", "recientes", false);

$datos = array(
    'tag' => "Todas",
    'user' => autentificado(),
    'valoradas' => listar($valoradas),
    'debatidas' => listar($debatidas),
    'recientes' => listar($recientes),
    'consensuadas' => listar($consensuadas)
);

$template = $twig->loadTemplate('propuestas.html');
echo $template->render($datos);
    
?>