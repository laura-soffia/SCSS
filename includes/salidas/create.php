<?php
function obtener_salidas()
{
    global $conex;
    $sql = "SELECT sa.IdSalida, sa.Fecha, sa.Hora, sa.Destino,
                   b.matricula, b.nombre AS barco,
                   s.nombres, s.apellidos
            FROM salidas sa
            INNER JOIN barco b ON sa.Barcos_Matricula = b.matricula
            INNER JOIN socio s ON b.socio_cedula = s.cedula
            ORDER BY sa.Fecha DESC, sa.Hora DESC";
    return mysqli_query($conex, $sql);
}

function validar_salida($fecha, $hora, $destino, $matricula)
{
    global $conex;
    $errores = [];

    $objetoFecha = DateTime::createFromFormat('Y-m-d', $fecha);
    if ($fecha === '') $errores[] = 'Ingrese la fecha';
    elseif (!$objetoFecha || $objetoFecha->format('Y-m-d') !== $fecha) $errores[] = 'La fecha no es válida';

    if ($hora === '') $errores[] = 'Ingrese la hora';
    elseif (!preg_match('/^([01]\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $hora)) $errores[] = 'La hora no es válida';

    if ($destino === '') $errores[] = 'Ingrese el destino';
    elseif (strlen($destino) > 50) $errores[] = 'El destino admite máximo 50 caracteres';

    if ($matricula === '') $errores[] = 'Seleccione el barco';
    else {
        $m = mysqli_real_escape_string($conex, $matricula);
        $resultado = mysqli_query($conex, "SELECT matricula FROM barco WHERE matricula = '$m'");
        if (mysqli_num_rows($resultado) === 0) $errores[] = 'El barco no existe';
    }

    return $errores;
}

function insertar_salida($fecha, $hora, $destino, $matricula)
{
    global $conex;
    $fecha     = mysqli_real_escape_string($conex, $fecha);
    $hora      = mysqli_real_escape_string($conex, $hora);
    $destino   = mysqli_real_escape_string($conex, $destino);
    $matricula = mysqli_real_escape_string($conex, $matricula);

    $sql = "INSERT INTO salidas (Fecha, Hora, Destino, Barcos_Matricula)
            VALUES ('$fecha', '$hora', '$destino', '$matricula')";
    return mysqli_query($conex, $sql);
}