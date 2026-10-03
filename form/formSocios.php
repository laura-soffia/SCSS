<?php
require "../db/conexion.php";
require "../includes/funciones.php";
require "../includes/socios/create.php";
validarSession();

$errores = [];
$cedula = $nombres = $apellidos = $direccion = $telefono = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula    = trim($_POST["cedula"]);
    $nombres   = trim($_POST["nombres"]);
    $apellidos = trim($_POST["apellidos"]);
    $direccion = trim($_POST["direccion"]);
    $telefono  = trim($_POST["telefono"]);

    $errores = validar_socio($cedula, $nombres, $apellidos, $direccion, $telefono);

    if (empty($errores)) {
        $ok = insertar_socio($cedula, $nombres, $apellidos, $direccion, $telefono);
        header("Location: ../PAG/socios.php?status=" . ($ok ? 0 : 1));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Nuevo socio</title></head>
<body>
<h2>Nuevo socio</h2>
<?php foreach ($errores as $e) echo "<p style='color:red'>" . htmlspecialchars($e) . "</p>"; ?>
<form action="" method="POST">
    <label>Cédula:</label>
    <input type="text" name="cedula" value="<?php echo htmlspecialchars($cedula); ?>"><br><br>
    <label>Nombres:</label>
    <input type="text" name="nombres" value="<?php echo htmlspecialchars($nombres); ?>"><br><br>
    <label>Apellidos:</label>
    <input type="text" name="apellidos" value="<?php echo htmlspecialchars($apellidos); ?>"><br><br>
    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?php echo htmlspecialchars($direccion); ?>"><br><br>
    <label>Teléfono:</label>
    <input type="text" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>"><br><br>
    <button type="submit">Agregar</button><br><br>
    <a href="../PAG/socios.php">Volver</a>
</form>
</body>
</html>