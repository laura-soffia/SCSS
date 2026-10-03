<?php
function obtener_barcos()
{
    global $conex;
    $sql = "SELECT b.matricula, b.nombre, b.n_amarre, b.cuota_amarre,
                   s.nombres, s.apellidos
            FROM barco b
            INNER JOIN socio s ON b.socio_cedula = s.cedula
            ORDER BY b.nombre";
    return mysqli_query($conex, $sql);
}

function validar_barco($matricula, $nombre, $n_amarre, $cuota, $socio_cedula, $editando = false)
{
    global $conex;
    $errores = [];

    if ($matricula === '') $errores[] = 'Ingrese la matrícula';
    elseif (strlen($matricula) > 15) $errores[] = 'La matrícula admite máximo 15 caracteres';
    elseif (!$editando) {
        $m = mysqli_real_escape_string($conex, $matricula);
        $resultado = mysqli_query($conex, "SELECT matricula FROM barco WHERE matricula = '$m'");
        if (mysqli_num_rows($resultado) > 0) $errores[] = 'La matrícula ya está registrada';
    }

    if ($nombre === '') $errores[] = 'Ingrese el nombre';
    elseif (strlen($nombre) > 25) $errores[] = 'El nombre admite máximo 25 caracteres';

    if ($n_amarre === '') $errores[] = 'Ingrese el número de amarre';
    elseif (strlen($n_amarre) > 50) $errores[] = 'El amarre admite máximo 50 caracteres';

    if ($cuota === '') $errores[] = 'Ingrese la cuota de amarre';
    elseif (!is_numeric($cuota) || $cuota < 0) $errores[] = 'La cuota debe ser un número válido';
    elseif ($cuota > 9999999.99) $errores[] = 'La cuota es demasiado grande';

    if ($socio_cedula === '') $errores[] = 'Seleccione el socio';
    else {
        $c = mysqli_real_escape_string($conex, $socio_cedula);
        $resultado = mysqli_query($conex, "SELECT cedula FROM socio WHERE cedula = '$c'");
        if (mysqli_num_rows($resultado) === 0) $errores[] = 'El socio no existe';
    }

    return $errores;
}

function insertar_barco($matricula, $nombre, $n_amarre, $cuota, $socio_cedula)
{
    global $conex;
    $matricula    = mysqli_real_escape_string($conex, $matricula);
    $nombre       = mysqli_real_escape_string($conex, $nombre);
    $n_amarre     = mysqli_real_escape_string($conex, $n_amarre);
    $socio_cedula = mysqli_real_escape_string($conex, $socio_cedula);
    $cuota        = (float) $cuota;

    $sql = "INSERT INTO barco (matricula, nombre, n_amarre, cuota_amarre, socio_cedula)
            VALUES ('$matricula', '$nombre', '$n_amarre', $cuota, '$socio_cedula')";
    return mysqli_query($conex, $sql);
}