<?php
require_once __DIR__ . "/../../db/conexion.php";
require_once __DIR__ . "/../funciones.php";
validarSession();

$id = mysqli_real_escape_string($conex, $_GET['id']);
try {
    mysqli_query($conex, "DELETE FROM barco WHERE matricula = '$id'");
    $status = 4;
} catch (mysqli_sql_exception $excepcion) {
    $status = 5; // tiene salidas asociadas (FK)
}
header("Location: ../../PAG/barcos.php?status=$status");
exit;