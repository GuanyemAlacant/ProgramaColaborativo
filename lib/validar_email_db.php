<?php
include_once "config.php";

// Descomentaríamos la siguiente línea para mostrar errores de php en el fichero:
// ini_set('display_errors', '1');


//Nos intentamos conectar:
try {
    // conectamos con bbdd e inicializamos conexión como UTF8
    $db = obtenerBBDD();
    $db->exec('SET CHARACTER SET utf8');


    // Para hacer debug cargaríamos a mano el parámetro, descomentaríamos la siguiente línea:
    //$_REQUEST['email'] = "pepito@hotmail.com";
    if (isset($_REQUEST['email_signup'])) 
    {
        // La línea siguiente la podemos descomentar para ver desde firebug-xhr si se pasa bien el parámetro desde el formulario
        //echo $_REQUEST['email'];
        $email = $_REQUEST['email_signup'];
        $sql   = $db->prepare("SELECT * FROM users WHERE email=?");
        $sql->bindParam(1, $email, PDO::PARAM_STR);
        $sql->execute();
        
        $valid = ($sql->rowCount() > 0) ? 'false' : 'true';
    }
    
}
catch (Exception $e)
{
    //echo "La conexi&oacute;n ha fallado: " . $e->getMessage();
    $valid = 'false';
}

$sql=null;
$db = null;
echo $valid;
?>