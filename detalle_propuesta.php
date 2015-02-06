<?php
include_once "lib/functions.php";

if(isset($_GET['id']))
{
	
	$id        = $_GET['id'];
	$buscaID   = array('id' => $id);
	$propuesta = "SELECT p.id, p.autor_id, p.titulo, p.propuesta, p.barrio_id, b.nombre barrio, 
                    p.sector_id, s.nombre sector, u.nombre, u.apellidos, u.id as user_id,
                    Sum(Case When l.voto > 0 Then l.voto Else 0 End) positivos,
                    Sum(Case When l.voto < 0 Then l.voto Else 0 End) negativos,
                    Count(l.voto) total
                    FROM prog_propuestas as p 
                    LEFT JOIN prog_users as u ON (p.autor_id=u.id) 
                    LEFT JOIN prog_likes_propuestas as l ON (p.id=l.propuesta_id)
                    LEFT JOIN prog_sectores as s ON (p.sector_id=s.id)
                    LEFT JOIN prog_barrios as b ON (p.barrio_id=b.id)
                    WHERE p.id=:id
                    GROUP BY p.id";
	
	$enmiendas = "SELECT e.id, e.propuesta_id, e.enmienda, u.nombre, u.apellidos, e.autor_id,
                    Sum(Case When l.voto > 0 Then l.voto Else 0 End) positivos,
                    Sum(Case When l.voto < 0 Then l.voto Else 0 End) negativos,
                    Count(l.voto) total
                    FROM prog_enmiendas as e 
                    LEFT JOIN prog_users as u ON (e.autor_id=u.id) 
                    LEFT JOIN prog_likes_enmiendas as l ON (e.id=l.enmienda_id)
                    WHERE e.propuesta_id=:id
                    GROUP BY e.id
                    ORDER BY total";
	
	
	$comentarios = "SELECT c.id, c.enmienda_id, u.nombre, u.apellidos, c.comentario, c.autor_id,
                    Sum(Case When l.voto > 0 Then l.voto Else 0 End) positivos,
                    Sum(Case When l.voto < 0 Then l.voto Else 0 End) negativos,
                    Count(l.voto) total
                    FROM prog_comentarios AS c
                    LEFT JOIN prog_enmiendas AS e ON (c.enmienda_id=e.id) 
                    LEFT JOIN prog_users as u ON (c.autor_id=u.id)
                    LEFT JOIN prog_likes_comentarios as l ON (c.id=l.comentario_id)
                    WHERE e.propuesta_id=:id
                    GROUP BY c.id";
	
	$id_propuesta   = $_GET['id'];
	$ID_prop        = array('id' => $id_propuesta);
	$consulta_autor = "SELECT p.autor_id FROM prog_propuestas as p, prog_users WHERE p.id=:id and p.autor_id=prog_users.id;";
	$autor_id       = autor_propuesta($ID_prop, $consulta_autor);
	$usuario_id     = userid();
	$usuario        = array('usuario_id' => $usuario_id);
	
	//Compruebo que el autor de la propuesta sea el usuario logueado (para enlace editar)
	if($autor_id == $usuario_id)
	{
		$autor   = array('autor_id' => $autor_id);
	}

    $datos = array(
        'autor' => $autor,
        'id' => $buscaID,
        'user' => autentificado(),
        'propuesta' => preparada($buscaID, $propuesta),
        'enmiendas' => listarpreparada($buscaID, $enmiendas),
        'comentarios' => listarpreparada($buscaID, $comentarios)
    );

    $template = $twig->loadTemplate('propuesta.html');
    echo $template->render($datos);
}
else
{	
	header('Location:index.php');
}

?>