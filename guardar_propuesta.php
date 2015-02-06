<?php
include_once "lib/functions.php";

if(isset($_POST["titulo"]) && isset($_POST["propuesta"]) && isset($_POST["sector"]))
{
    $autor     = userid();
	$titulo    = $_POST["titulo"];
	$propuesta = $_POST["propuesta"];
	$sector    = $_POST["sector"];
	$barrio    = $_POST["barrio"];
    
    if(isset($_POST["id"]))
    {
        $id        = $_POST["id"];
        editarPropuesta($id, $titulo, $propuesta, $sector, $barrio);
    }
    else
    {
        crearPropuesta($autor, $titulo, $propuesta, $sector, $barrio);	
    }
}
else
{
	header('Location: index.php');
}

?>