<?php
include_once "lib/functions.php";

$template = $twig->loadTemplate('aviso_legal.html');
$datos    = array('user'=>autentificado());
echo $template->render($datos);

?>