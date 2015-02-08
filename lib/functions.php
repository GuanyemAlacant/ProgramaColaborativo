<?php
include_once "config.php";
include_once "PasswordHash.php";

//La coloco aquí para asegurar que se ejecuta siempre una única vez.
session_start();

//Usuarios

//Alta de usuarios
function alta($nombre, $apellidos, $email, $password, $ip, $barrio_id)
{
	
	// Creamos el objeto que nos permitirá gestionar nuestro hash
	$hasher = new PasswordHash(8, FALSE);
	$hash   = $hasher->HashPassword($password);
	
	try
	{
		$conn   = obtenerBBDD();
		$user   = array(
			'nombre' => $nombre,
			'apellidos' => $apellidos,
			'email' => $email,
			'pass' => $hash,
			'ip' => $ip,
            'barrio_id' => $barrio_id
		);
		$result = $conn->prepare("INSERT INTO prog_users(nombre, apellidos, email, password, ip, barrio_id) VALUES(:nombre, :apellidos, :email, :pass, :ip, :barrio_id);");
		$result->execute($user);
		//header( 'Location: login.php' );
		login($email, $password);
	}
	catch(PDOException $e)
	{
		echo "Alta Exception: " . $e->getMessage();
	}
	
	$conn = null;
}

//Login
function login($email, $pass)
{
	
	// Creamos el objeto que nos permitirá gestionar nuestro hash
	$hasher = new PasswordHash(8, FALSE);
	try
	{
		
		$conn   = obtenerBBDD();
		$user   = array(
			'email' => $email
		);
		$result = $conn->prepare("SELECT password FROM prog_users WHERE email=:email;");
		$result->execute($user);
		
		foreach($result as $cont)
		{
			$password = $cont['password'];
			$user_id  = $cont['id'];
		}
		
		//comprueba que usuario y contraseña coinciden y crea sesión de usuario.
		if($hasher->CheckPassword($pass, $password))
		{
			if(!isset($_SESSION["usuario"]))
			{
				$_SESSION["usuario"] = $email;
			}
			if(isset($_SESSION['error']))
			{
				unset($_SESSION['error']);
			}
			//Envía al index
			header('Location: index.php');
		}
		else
		{
			//Si no coinciden envía a login con sesión de error.
			$_SESSION["error"] = "error";
			header('Location: login.php');
		}
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	
	$conn = null;
	
}

//logout
function logout()
{
	unset($_SESSION['usuario']);
	header('Location: index.php');
}

//Busca todos los datos del usuario identificado

function autentificado()
{
	if(isset($_SESSION["usuario"]))
	{
		$usuario = $_SESSION["usuario"];
		try
		{
			$conn     = obtenerBBDD();
			$user     = array($usuario);
			$consulta = "SELECT * FROM prog_users WHERE email=?;";
			$result   = $conn->prepare($consulta);
			$result->execute($user);
			foreach($result as $res)
			{
				$nombre    = $res['nombre'];
				$apellidos = $res['apellidos'];
				$id        = $res['id'];
			}
            $conn = null;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
		
		return array(
			"nombre" => $nombre,
			"apellidos" => $apellidos,
			"id" => $id
		);
	}
    return array();
}

//Búsquedas

//Recibe una consulta SQL y tras ejecutarla devuelve el resultado de la misma
function listar($consulta)
{
	
	$propuesta = array();
	try
	{
		$conn = obtenerBBDD();
		
        //echo "listar: ".$consulta."\n";
		$resultado = $conn->query($consulta);
        if($resultado !== FALSE)
        {
            $resultado->setFetchMode(PDO::FETCH_ASSOC);
            $propuesta = $resultado->fetchall();
            $resultado->closeCursor();
        }
        else
        {
            echo "BBDD Failure!! listar: ".$consulta;
        }
		$conn      = null;
		
	}
	catch(PDOException $e)
	{
		$propuesta = $e->getMessage();
	}
	return $propuesta;
}

//Ejecuta una búsqueda preparada que devuelve un resultado único. 
//Usar siempre que se reciban datos del usuario.
function preparada($prep, $consulta)
{
	
	try
	{
		$conn   = obtenerBBDD();
		$result = $conn->prepare($consulta);
		$result->execute($prep);
        
		$propuesta = $result->fetch(PDO::FETCH_ASSOC);
		$conn      = null;
	}
	catch(PDOException $e)
	{
		$propuesta = $e->getMessage();
	}
	
	return $propuesta;
}

//Ejecuta una sentencia preparada que devuelve varios resultados
//Usar siempre que se reciban datos del usuario.
function listarpreparada($prep, $consulta)
{
	
	try
	{
		$conn   = obtenerBBDD();
		$result = $conn->prepare($consulta);
		$result->execute($prep);
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$propuesta = $result->fetchall();
		$conn      = null;
	}
	catch(PDOException $e)
	{
		$receta = $e->getMessage();
	}
	
	return $propuesta;
}

//Consulta el autor de la propuesta
function autor_propuesta($buscaID, $consulta_autor)
{
	
	try
	{
		$conn   = obtenerBBDD();
		$result = $conn->prepare($consulta_autor);
		$result->execute($buscaID);
		foreach($result as $res)
		{
			$autor = $res['autor_id'];
		}
		
	}
	catch(PDOException $e)
	{
		$result = $e->getMessage();
	}
	$conn  = null;
	$autor = (int) ($autor);
	return $autor;
}

//consigue el id del usuario

function userid()
{
	if(isset($_SESSION["usuario"]))
	{
		//Busco el usuario
		try
		{
			$usuario  = $_SESSION["usuario"];
			$conn     = obtenerBBDD();
			$user     = array(
				$usuario
			);
			$consulta = "SELECT id FROM prog_users WHERE email=?;";
			$result   = $conn->prepare($consulta);
			$result->execute($user);
			foreach($result as $idusuario)
			{
				$userid = $idusuario['id'];
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
		
		$conn   = null;
		$userid = (int) ($userid);
		return $userid;
	}
}

//Propuestas

//nueva propuesta
function nueva_propuesta($titulo, $propuesta, $sector, $barrio)
{
	$autor = userid();
	try
	{
		$conn   = obtenerBBDD();
		$cadena = array(
			'autor' => $autor,
			'titulo' => $titulo,
			'propuesta' => $propuesta,
			'sector' => $sector,
			'barrio' => $barrio
		);
		$result = $conn->prepare("INSERT INTO prog_propuestas(autor_id, titulo, propuesta, sector_id, barrio_id) VALUES (:autor, :titulo, :propuesta, :sector, :barrio);");
		$result->execute($cadena);
        $id = $conn->lastInsertId();
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	
	$conn = null;
	
    //redirije a la propuesta una vez grabada en la base de datos
    header('Location: detalle_propuesta.php?id=' . $id);
}

//Editar propuesta
function editar_propuesta($titulo, $propuesta, $sector, $barrio, $id)
{
	try
	{
		$conn   = obtenerBBDD();
		$cadena = array(
			'titulo' => $titulo,
			'propuesta' => $propuesta,
			'id' => $id,
			'sector' => $sector,
			'barrio' => $barrio
		);
		$result = $conn->prepare("UPDATE prog_propuestas SET titulo =:titulo, propuesta=:propuesta, sector_id=:sector, barrio_id=:barrio 
            WHERE id=:id;");
		$result->execute($cadena);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	
	$conn = null;
    
    //redirije a la propuesta una vez editada
    header('Location: detalle_propuesta.php?id=' . $id);
}

//--
function obtenerUsuarioJSON($usuario)
{
    //--
    $conn     = obtenerBBDD();
    $consulta = array('usuario_id' => $usuario);
    $result   = $conn->prepare('SELECT nombre, apellidos FROM prog_users WHERE id=:usuario_id');
    $result->execute($consulta);
    $res      = $result->fetch();
    if($res !== FALSE)
    {
        $nombre    = $res['nombre'];
        $apellidos = $res['apellidos'];
    }

    //Array serializado para pasar datos con json.
    $output   = array();
    $output[] = array(
        'nombre' => $nombre,
        'apellidos' => $apellidos
    );
    return json_encode($output);
}

//--
function crearPropuesta($autor, $titulo, $propuesta, $sector, $barrio)
{
	try
	{
		$conn   = obtenerBBDD();
		$consulta = array(
			'autor' => $autor,
			'titulo' => $titulo,
			'propuesta' => $propuesta,
			'sector' => $sector,
			'barrio' => $barrio
		);
		$result = $conn->prepare("INSERT INTO prog_propuestas(autor_id, titulo, propuesta, sector_id, barrio_id) VALUES (:autor, :titulo, :propuesta, :sector, :barrio);");
		$result->execute($consulta);
        $id = $conn->lastInsertId();
        
        // TODO: Add like?
        ajaxLikePropuesta($id, $autor, 1);
        $conn = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
	
    //redirije a la propuesta una vez grabada en la base de datos
    header('Location: detalle_propuesta.php?id=' . $id);
}

//--
function editarPropuesta($id, $titulo, $propuesta, $sector, $barrio)
{
	try
	{
		$conn   = obtenerBBDD();
		$consulta = array(
			'titulo' => $titulo,
			'propuesta' => $propuesta,
			'id' => $id,
			'sector' => $sector,
			'barrio' => $barrio
		);
		$result = $conn->prepare("UPDATE prog_propuestas SET titulo=:titulo, propuesta=:propuesta, sector_id=:sector, barrio_id=:barrio WHERE id=:id;");
		$result->execute($consulta);
        $conn = null;
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
    
    //redirije a la propuesta una vez editada
    header('Location: detalle_propuesta.php?id=' . $id);
}

//--
function ajaxLikePropuesta($propuesta, $usuario, $like)
{
    if($like != 1 && $like !=-1)
        $like = 0;
    
	try
	{
        $conn     = obtenerBBDD();
        $result   = $conn->prepare("INSERT INTO prog_likes_propuestas (usuario_id, propuesta_id, voto) VALUES (:usuario, :propuesta, :voto) ON DUPLICATE KEY UPDATE voto=:voto");
        $data     = array('usuario' => $usuario, 
                          'propuesta' => $propuesta,
                          'voto' => $like);
        $result->execute($data);

        //--
        $result   = $conn->prepare("SELECT sum(voto) as votos FROM prog_likes_propuestas WHERE propuesta_id=?");
        $result->bindParam(1, $propuesta, PDO::PARAM_INT);
        $result->execute();

        //--
        $like   = 0;
        $res    = $result->fetch();
        if($res !== FALSE)
        {
            $like = $res['votos'];
        }

        //Array serializado para pasar datos con json.
        $output   = array();
        $output[] = array(
            'votos' => $like
        );
        return json_encode($output);
	}
	catch(PDOException $e)
	{
		return $e->getMessage();
	}
}

//--
function ajaxCrearEnmienda($autor, $propuesta_id, $enmienda)
{
	try
	{
		$conn   = obtenerBBDD();
		$consulta = array(
			'propuesta_id' => $propuesta_id,
			'usuario_id' => $autor,
			'enmienda' => $enmienda
		);
		$result   = $conn->prepare("INSERT INTO prog_enmiendas (autor_id, propuesta_id, enmienda) VALUES(:usuario_id, :propuesta_id, :enmienda);");
		$result->execute($consulta);
        $id   = $conn->lastInsertId();
        $conn = null;
        
        // TODO: Add like?
        echo ajaxLikeEnmienda($id, $autor, 1);
        //echo obtenerUsuarioJSON($autor);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

//--
function ajaxLikeEnmienda($enmienda, $usuario, $like)
{
    if($like != 1 && $like !=-1)
        $like = 0;
    
	try
	{
        $conn     = obtenerBBDD();
        $result   = $conn->prepare("INSERT INTO prog_likes_enmiendas (usuario_id, enmienda_id, voto) VALUES (:usuario, :enmienda, :voto) ON DUPLICATE KEY UPDATE voto=:voto");
        $data     = array('usuario' => $usuario, 
                          'enmienda' => $enmienda,
                          'voto' => $like);
        $result->execute($data);

        //--
        $result   = $conn->prepare("SELECT sum(voto) as votos FROM prog_likes_enmiendas WHERE enmienda_id=?");
        $result->bindParam(1, $enmienda, PDO::PARAM_INT);
        $result->execute();

        //--
        $like   = 0;
        $res    = $result->fetch();
        if($res !== FALSE)
        {
            $like = $res['votos'];
        }

        //Array serializado para pasar datos con json.
        $output   = array();
        $output[] = array(
            'votos' => $like
        );
        return json_encode($output);
	}
	catch(PDOException $e)
	{
		return $e->getMessage();
	}
}


//--
function ajaxCrearComentario($autor, $propuesta_id, $enmienda_id, $comentario)
{
	try
	{
		$conn   = obtenerBBDD();
        
		$consulta = array(
			'propuesta_id' => $propuesta_id,
			'enmienda_id' => $enmienda_id,
			'usuario_id' => $autor,
			'comentario' => $comentario
		);
		$result   = $conn->prepare("INSERT INTO prog_comentarios (autor_id, propuesta_id, enmienda_id, comentario) VALUES(:usuario_id, :propuesta_id, :enmienda_id, :comentario);");
		$result->execute($consulta);
        $id   = $conn->lastInsertId();
        $conn = null;
        
        // TODO: Add like?
        echo ajaxLikeComentario($id, $autor, 1);
        //echo obtenerUsuarioJSON($autor);
	
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
}

//--
function ajaxLikeComentario($comentario, $usuario, $like)
{
    if($like != 1 && $like !=-1)
        $like = 0;

	try
	{
        $conn     = obtenerBBDD();
        $result   = $conn->prepare("INSERT INTO prog_likes_comentarios (usuario_id, comentario_id, voto) VALUES (:usuario, :comentario, :voto) ON DUPLICATE KEY UPDATE voto=:voto");
        $data     = array('usuario' => $usuario, 
                          'comentario' => $comentario,
                          'voto' => $like);
        $result->execute($data);

        //--
        $result   = $conn->prepare("SELECT sum(voto) as votos FROM prog_likes_comentarios WHERE comentario_id=?");
        $result->bindParam(1, $comentario, PDO::PARAM_INT);
        $result->execute();

        //--
        $like   = 0;
        $res    = $result->fetch();
        if($res !== FALSE)
        {
            $like = $res['votos'];
        }

        //Array serializado para pasar datos con json.
        $output   = array();
        $output[] = array(
            'votos' => $like
        );
        return json_encode($output);
	}
	catch(PDOException $e)
	{
		return $e->getMessage();
	}
}

//--
function obtenerConsulta($filterType, $orderType, $limit)
{
    $base = "SELECT p.id, p.autor_id, p.titulo, p.propuesta, p.barrio_id, b.nombre barrio, 
                p.sector_id, s.nombre sector, u.nombre, u.apellidos, u.id as user_id,
                (SELECT count(*) FROM prog_likes_propuestas WHERE (propuesta_id=p.id AND voto > 0)) as positivos,
                (SELECT -count(*) FROM prog_likes_propuestas WHERE (propuesta_id=p.id AND voto < 0)) as negativos,
                (SELECT count(*) FROM prog_likes_propuestas WHERE (propuesta_id=p.id AND voto <> 0)) as total,
                (SELECT count(*) FROM prog_enmiendas WHERE (propuesta_id=p.id)) as enmiendas,
                (SELECT count(*) FROM prog_comentarios WHERE (propuesta_id=p.id)) as comentarios
                FROM prog_propuestas as p 
                LEFT JOIN prog_users as u ON (p.autor_id=u.id)
                LEFT JOIN prog_sectores as s ON (p.sector_id=s.id)
                LEFT JOIN prog_barrios as b ON (p.barrio_id=b.id)
                [[WHERE]]
                GROUP BY p.id
                [[ORDER]]";
    
    $strWhere = "";
    $strOrder = "";
    if($filterType == "barrio")
    {
        $strWhere = "WHERE p.barrio_id=:id";
    }
    else if($filterType == "sector")
    {
        $strWhere = "WHERE p.sector_id=:id";
    }
    
    
    if($orderType == "valoradas")
    {
        $strOrder = "ORDER BY total DESC, positivos / total DESC";
    }
    else if($orderType == "debatidas")
    {
        $strOrder = "ORDER BY (comentarios + enmiendas) DESC";
    }
    else if($orderType == "recientes")
    {
        $strOrder = "ORDER BY p.id DESC";
    }
    else if($orderType == "consensuadas")
    {
        $strOrder = "ORDER BY positivos / total DESC, positivos DESC";
    }
    
    if($limit)
    {
        $strOrder .= " LIMIT 0, 20";
    }
    
    $base = str_replace("[[WHERE]]", $strWhere, $base);
    $base = str_replace("[[ORDER]]", $strOrder, $base);
    
    return $base;
}


function JornadasActivas()
{
    $found = true;
    try
	{
		$conn   = obtenerBBDD();
        $result   = $conn->prepare("SELECT valor FROM prog_config WHERE nombre='jornadas'");
        $result->execute();
        $found = ($result->rowCount() > 0);
	}
	catch(PDOException $e)
	{
		echo $e->getMessage();
	}
    
    return $found;
}

?>