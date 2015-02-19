<?php
include_once "lib/functions.php";

//$valoradas    = obtenerConsulta("", "valoradas", false);
$valoradas = "SELECT p.id, p.autor_id, p.titulo, p.propuesta, p.barrio_id, b.nombre barrio, 
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
                GROUP BY p.id
                ORDER BY p.sector_id, total DESC, positivos / total DESC";

$datos = array(
    'propuestas' => listar($valoradas)
);

//echo "<pre>";
//var_dump($valoradas);
//echo "</pre>";

$template = $twig->loadTemplate('informe_propuestas.html');
echo $template->render($datos);

?>