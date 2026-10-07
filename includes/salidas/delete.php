<?php
require_once __DIR__ . "/../../db/conexion.php";
require_once __DIR__ . "/../funciones.php";
validarSession();

$id = (int) $_GET['id'];
$exito = mysqli_query($conex, "DELETE FROM salidas WHERE IdSalida = $id");
header("Location: ../../PAG/salidas.php?status=" . ($exito ? 4 : 5));
exit;