<?php
include_once "lib/functions.php";

if(isset($_SESSION["usuario"]) && JornadasActivas())
{   
    $usuario      = autentificado();
    $user_id      = array('id' => $usuario['id']);
    $jornadas     = "SELECT * FROM prog_jornadas";
    $jornada_user = "SELECT * FROM prog_users_jornada WHERE usuario_id=:id";
    
    $datos = array(
        'user' => $usuario,
        'jornadas' => listar($jornadas),
        'jornada_user' => preparada($user_id, $jornada_user)
    );

    $template = $twig->loadTemplate('jornadas.html');
    echo $template->render($datos);

}
else
{	
	header('Location:index.php');
}

?>