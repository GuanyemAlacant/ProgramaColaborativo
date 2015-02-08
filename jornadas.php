<?php
include_once "lib/functions.php";

if(JornadasActivas())
{
    $jornadas     = "SELECT * FROM prog_sectores";
    $jornadas     = "SELECT s.id, s.nombre, count(uj.usuario_id) as total FROM `prog_sectores` s 
                        LEFT JOIN prog_users_jornada uj ON uj.jornada_id = s.id
                        GROUP BY s.id, s.nombre";
    $jornada_user = "SELECT * FROM prog_users_jornada WHERE usuario_id=:id";
    

    if(isset($_SESSION["usuario"]))
    {
        $usuario      = autentificado();
        $user_id      = array('id' => $usuario['id']);
        $datosJornadaUser = preparada($user_id, $jornada_user);
    }
    else
    {
        $usuario      = null;
        $user_id      = array('id' => 0);
        $datosJornadaUser = 0;
    }
    
    $datos = array(
        'user' => $usuario,
        'jornadas' => listar($jornadas),
        'jornada_user' => $datosJornadaUser
    );

    $template = $twig->loadTemplate('jornadas.html');
    echo $template->render($datos);

}
else
{	
	header('Location:index.php');
}

?>