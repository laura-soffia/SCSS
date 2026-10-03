<?php
function obtener_socios()
{
    global $conex;
    return mysqli_query($conex, "SELECT * FROM socio ORDER BY nombres");
}

function validar_socio($cedula, $nombres, $apellidos, $direccion, $telefono, $editando = false)
{
    global $conex;
    $errores = [];

    if ($cedula === '') $errores[] = 'Ingrese la cédula';
    elseif (strlen($cedula) > 10) $errores[] = 'La cédula admite máximo 10 caracteres';
    elseif (!$editando) {
        $c = mysqli_real_escape_string($conex, $cedula);
        $resultado = mysqli_query($conex, "SELECT cedula FROM socio WHERE cedula = '$c'");
        if (mysqli_num_rows($resultado) > 0) $errores[] = 'La cédula ya está registrada';
    }

    if ($nombres === '') $errores[] = 'Ingrese los nombres';
    elseif (strlen($nombres) > 25) $errores[] = 'Los nombres admiten máximo 25 caracteres';

    if ($apellidos === '') $errores[] = 'Ingrese los apellidos';
    elseif (strlen($apellidos) > 25) $errores[] = 'Los apellidos admiten máximo 25 caracteres';

    if ($direccion === '') $errores[] = 'Ingrese la dirección';
    elseif (strlen($direccion) > 50) $errores[] = 'La dirección admite máximo 50 caracteres';

    if ($telefono === '') $errores[] = 'Ingrese el teléfono';
    elseif (strlen($telefono) > 10) $errores[] = 'El teléfono admite máximo 10 caracteres';

    return $errores;
}

function insertar_socio($cedula, $nombres, $apellidos, $direccion, $telefono)
{
    global $conex;
    $cedula    = mysqli_real_escape_string($conex, $cedula);
    $nombres   = mysqli_real_escape_string($conex, $nombres);
    $apellidos = mysqli_real_escape_string($conex, $apellidos);
    $direccion = mysqli_real_escape_string($conex, $direccion);
    $telefono  = mysqli_real_escape_string($conex, $telefono);

    $sql = "INSERT INTO socio (cedula, nombres, apellidos, direccion, telefono)
            VALUES ('$cedula', '$nombres', '$apellidos', '$direccion', '$telefono')";
    return mysqli_query($conex, $sql);
}