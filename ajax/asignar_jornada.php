<?php
include_once "../lib/functions.php";

$output = "false";
if(isset($_POST["usuario_id"]) && isset($_POST["jornada_id"]))
{
	$usuario_id   = $_POST["usuario_id"];
	$jornada_id   = $_POST["jornada_id"];
    $user         = userid();
    
    if($user == $usuario_id)
    {
        try
        {
            $conn     = obtenerBBDD();
            $result   = $conn->prepare("INSERT INTO prog_users_jornada (usuario_id, jornada_id) VALUES (:usuario, :jornada) ON DUPLICATE KEY UPDATE jornada_id=:jornada");
            $data     = array('usuario' => $usuario_id, 
                              'jornada' => $jornada_id);
            
            if($result->execute($data))
            {
                if($result->rowCount() > 0)
                {
                    $output = "true";
                }
                else
                {
                    echo "row count ".$result->rowCount().", ";
                }
            }
            else
            {
                echo "exec";
            }
        }
        catch(PDOException $e)
        {
  		    echo $e->getMessage();
        }
    }
    else
    {
        echo "user";
    }
}

echo $output;

?>