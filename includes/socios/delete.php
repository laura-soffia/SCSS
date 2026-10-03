<?php
require_once __DIR__ . "/../../db/conexion.php";
require_once __DIR__ . "/../funciones.php";
validarSession();

$id = mysqli_real_escape_string($conex, $_GET['id']);
try {
    mysqli_query($conex, "DELETE FROM socio WHERE cedula = '$id'");
    $status = 4;
} catch (mysqli_sql_exception $e) {
    $status = 5; // tiene barcos asociados (FK)
}
header("Location: ../../PAG/socios.php?status=$status");
exit;