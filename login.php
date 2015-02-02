<?php
include_once "lib/functions.php";


//Compruebo si hay sesión de error (creada al fallar la contraseña)
$error = null;
if(isset($_SESSION["error"]))
{
    $error = $_SESSION['error'];
    //$datos = array('error'=>$_SESSION['error']);
    unset($_SESSION['error']);
}

$barrios             = 'SELECT * FROM prog_barrios ORDER BY distrito_id, id';
$distritos           = 'SELECT * FROM prog_distritos';

$datos = array(
    'barrios' => listar($barrios),
    'distritos' => listar($distritos),
    'error' => $error
);


$template = $twig->loadTemplate('login.html');
echo $template->render($datos);

?>
