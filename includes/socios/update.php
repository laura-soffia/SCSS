<?php
require_once __DIR__ . "/../../db/conexion.php";
require_once __DIR__ . "/../funciones.php";
require_once __DIR__ . "/create.php";
validarSession();

$id = mysqli_real_escape_string($conex, $_GET['id']);
$res = mysqli_query($conex, "SELECT * FROM socio WHERE cedula = '$id'");
$data = mysqli_fetch_assoc($res);
if (!$data) { header("Location: ../../PAG/socios.php"); exit; }

$errores = [];
if (isset($_POST['editar'])) {
    $nombres   = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $direccion = trim($_POST['direccion']);
    $telefono  = trim($_POST['telefono']);

    $errores = validar_socio($data['cedula'], $nombres, $apellidos, $direccion, $telefono, true);

    if (empty($errores)) {
        $n = mysqli_real_escape_string($conex, $nombres);
        $a = mysqli_real_escape_string($conex, $apellidos);
        $d = mysqli_real_escape_string($conex, $direccion);
        $t = mysqli_real_escape_string($conex, $telefono);
        $ok = mysqli_query($conex, "UPDATE socio SET nombres='$n', apellidos='$a', direccion='$d', telefono='$t' WHERE cedula='$id'");
        header("Location: ../../PAG/socios.php?status=" . ($ok ? 2 : 3));
        exit;
    }
    $data = array_merge($data, ['nombres' => $nombres, 'apellidos' => $apellidos, 'direccion' => $direccion, 'telefono' => $telefono]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Actualizar socio</title></head>
<body>
<h2>Actualizar socio</h2>
<?php foreach ($errores as $e) echo "<p style='color:red'>" . htmlspecialchars($e) . "</p>"; ?>
<form action="" method="POST">
    <label>Cédula (no editable):</label>
    <input type="text" value="<?php echo htmlspecialchars($data['cedula']); ?>" disabled><br><br>
    <label>Nombres:</label>
    <input type="text" name="nombres" value="<?php echo htmlspecialchars($data['nombres']); ?>"><br><br>
    <label>Apellidos:</label>
    <input type="text" name="apellidos" value="<?php echo htmlspecialchars($data['apellidos']); ?>"><br><br>
    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?php echo htmlspecialchars($data['direccion']); ?>"><br><br>
    <label>Teléfono:</label>
    <input type="text" name="telefono" value="<?php echo htmlspecialchars($data['telefono']); ?>"><br><br>
    <button type="submit" name="editar">Actualizar</button><br><br>
    <a href="../../PAG/socios.php">Volver</a>
</form>
</body>
</html>