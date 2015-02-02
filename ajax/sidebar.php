<?php
include_once "../lib/functions.php";

$sectores  = listar("SELECT id, nombre FROM prog_sectores");
$barrios   = listar("SELECT * FROM prog_barrios ORDER BY distrito_id, id");
$distritos = listar("SELECT * FROM prog_distritos");


$datos = array(
    'sectores' => $sectores,
    'barrios' => $barrios,
    'distritos' => $distritos
);

echo json_encode($datos);

?>