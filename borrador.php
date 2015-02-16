<?php
include_once "lib/functions.php";

$template = $twig->loadTemplate('borrador.html');
$datos    = array('user'=>autentificado());
echo $template->render($datos);

?>