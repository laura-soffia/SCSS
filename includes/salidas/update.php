<?php
require_once __DIR__ . "/../../db/conexion.php";
require_once __DIR__ . "/../funciones.php";
require_once __DIR__ . "/../barcos/create.php";
require_once __DIR__ . "/create.php";
validarSession();

$id = (int) $_GET['id'];
$resultado = mysqli_query($conex, "SELECT * FROM salidas WHERE IdSalida = $id");
$data = mysqli_fetch_assoc($resultado);
if (!$data) { header("Location: ../../PAG/salidas.php"); exit; }

$errores = [];
if (isset($_POST['editar'])) {
    $fecha     = trim($_POST['fecha']);
    $hora      = trim($_POST['hora']);
    $destino   = trim($_POST['destino']);
    $matricula = trim($_POST['matricula']);

    $errores = validar_salida($fecha, $hora, $destino, $matricula);

    if (empty($errores)) {
        $f = mysqli_real_escape_string($conex, $fecha);
        $h = mysqli_real_escape_string($conex, $hora);
        $d = mysqli_real_escape_string($conex, $destino);
        $m = mysqli_real_escape_string($conex, $matricula);
        $exito = mysqli_query($conex, "UPDATE salidas SET Fecha='$f', Hora='$h', Destino='$d', Barcos_Matricula='$m' WHERE IdSalida=$id");
        header("Location: ../../PAG/salidas.php?status=" . ($exito ? 2 : 3));
        exit;
    }
    $data = array_merge($data, ['Fecha' => $fecha, 'Hora' => $hora, 'Destino' => $destino, 'Barcos_Matricula' => $matricula]);
}
$barcos = obtener_barcos();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Actualizar salida</title></head>
<body>
<h2>Actualizar salida</h2>
<?php foreach ($errores as $error) echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>"; ?>
<form action="" method="POST">
    <label>Fecha:</label>
    <input type="date" name="fecha" value="<?php echo htmlspecialchars($data['Fecha']); ?>"><br><br>
    <label>Hora:</label>
    <input type="time" name="hora" value="<?php echo htmlspecialchars(substr($data['Hora'], 0, 5)); ?>"><br><br>
    <label>Destino:</label>
    <input type="text" name="destino" value="<?php echo htmlspecialchars($data['Destino']); ?>"><br><br>
    <label>Barco:</label>
    <select name="matricula">
        <?php while ($barco = mysqli_fetch_assoc($barcos)) { ?>
            <option value="<?php echo htmlspecialchars($barco['matricula']); ?>"
                <?php if ($barco['matricula'] === $data['Barcos_Matricula']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($barco['nombre'] . ' (' . $barco['matricula'] . ') - ' . $barco['nombres'] . ' ' . $barco['apellidos']); ?>
            </option>
        <?php } ?>
    </select><br><br>
    <button type="submit" name="editar">Actualizar</button><br><br>
    <a href="../../PAG/salidas.php">Volver</a>
</form>
</body>
</html>
