<?php
include_once "../lib/functions.php";

$sectores = listar("SELECT id, nombre FROM prog_sectores");
$barrios  = listar("SELECT id, nombre FROM prog_barrios");


$datos = array(
    'sectores' => $sectores,
    'barrios' => $barrios
);

echo json_encode($datos);

?>