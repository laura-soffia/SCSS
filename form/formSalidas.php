<?php
require "../db/conexion.php";
require "../includes/funciones.php";
require "../includes/barcos/create.php";
require "../includes/salidas/create.php";
validarSession();

$errores = [];
$fecha = $hora = $destino = $matricula = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fecha     = trim($_POST["fecha"]);
    $hora      = trim($_POST["hora"]);
    $destino   = trim($_POST["destino"]);
    $matricula = trim($_POST["matricula"]);

    $errores = validar_salida($fecha, $hora, $destino, $matricula);

    if (empty($errores)) {
        $exito = insertar_salida($fecha, $hora, $destino, $matricula);
        header("Location: ../PAG/salidas.php?status=" . ($exito ? 0 : 1));
        exit;
    }
}
$barcos = obtener_barcos();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Nueva salida</title></head>
<body>
<h2>Nueva salida</h2>
<?php foreach ($errores as $error) echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>"; ?>
<form action="" method="POST">
    <label>Fecha:</label>
    <input type="date" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>"><br><br>
    <label>Hora:</label>
    <input type="time" name="hora" value="<?php echo htmlspecialchars($hora); ?>"><br><br>
    <label>Destino:</label>
    <input type="text" name="destino" value="<?php echo htmlspecialchars($destino); ?>"><br><br>
    <label>Barco:</label>
    <select name="matricula">
        <option value="">-- Seleccione un barco --</option>
        <?php while ($barco = mysqli_fetch_assoc($barcos)) { ?>
            <option value="<?php echo htmlspecialchars($barco['matricula']); ?>"
                <?php if ($barco['matricula'] === $matricula) echo 'selected'; ?>>
                <?php echo htmlspecialchars($barco['nombre'] . ' (' . $barco['matricula'] . ') - ' . $barco['nombres'] . ' ' . $barco['apellidos']); ?>
            </option>
        <?php } ?>
    </select><br><br>
    <button type="submit">Agregar</button><br><br>
    <a href="../PAG/salidas.php">Volver</a>
</form>
</body>
</html>