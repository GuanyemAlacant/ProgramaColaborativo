<?php
include_once "../lib/functions.php";

if(isset($_POST['propuesta']) && isset($_POST['usuario_id']))
{
	$propuesta = $_POST['propuesta'];
	$usuario   = $_POST['usuario_id'];
	
	try
	{
		$conn     = obtenerBBDD();
        $result   = $conn->prepare("SELECT voto FROM prog_likes_propuestas WHERE usuario_id=? and propuesta_id=?");
        $result->bindParam(1, $usuario, PDO::PARAM_INT);
        $result->bindParam(2, $propuesta, PDO::PARAM_INT);
        $result->execute();

        //--
        $like   = 0;
        $res    = $result->fetch();
        if($res !== FALSE)
        {
			$like = $res['voto'];
		}

		//Array serializado para pasar datos con json.
        $output   = array();
		$output[] = array('voto' => $like);
        
		//Array serializado para pasar datos con json.
		echo json_encode($output);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

?>