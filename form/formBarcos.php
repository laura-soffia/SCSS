<?php
require "../db/conexion.php";
require "../includes/funciones.php";
require "../includes/socios/create.php";
require "../includes/barcos/create.php";
validarSession();

$errores = [];
$matricula = $nombre = $n_amarre = $cuota = $socio_cedula = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricula    = trim($_POST["matricula"]);
    $nombre       = trim($_POST["nombre"]);
    $n_amarre     = trim($_POST["n_amarre"]);
    $cuota        = trim($_POST["cuota_amarre"]);
    $socio_cedula = trim($_POST["socio_cedula"]);

    $errores = validar_barco($matricula, $nombre, $n_amarre, $cuota, $socio_cedula);

    if (empty($errores)) {
        $exito = insertar_barco($matricula, $nombre, $n_amarre, $cuota, $socio_cedula);
        header("Location: ../PAG/barcos.php?status=" . ($exito ? 0 : 1));
        exit;
    }
}
$socios = obtener_socios();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Nuevo barco</title></head>
<body>
<h2>Nuevo barco</h2>
<?php foreach ($errores as $error) echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>"; ?>
<form action="" method="POST">
    <label>Matrícula:</label>
    <input type="text" name="matricula" value="<?php echo htmlspecialchars($matricula); ?>"><br><br>
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"><br><br>
    <label>Número de amarre:</label>
    <input type="text" name="n_amarre" value="<?php echo htmlspecialchars($n_amarre); ?>"><br><br>
    <label>Cuota de amarre:</label>
    <input type="number" step="0.01" min="0" name="cuota_amarre" value="<?php echo htmlspecialchars($cuota); ?>"><br><br>
    <label>Socio:</label>
    <select name="socio_cedula">
        <option value="">-- Seleccione un socio --</option>
        <?php while ($socio = mysqli_fetch_assoc($socios)) { ?>
            <option value="<?php echo htmlspecialchars($socio['cedula']); ?>"
                <?php if ($socio['cedula'] === $socio_cedula) echo 'selected'; ?>>
                <?php echo htmlspecialchars($socio['nombres'] . ' ' . $socio['apellidos'] . ' (' . $socio['cedula'] . ')'); ?>
            </option>
        <?php } ?>
    </select><br><br>
    <button type="submit">Agregar</button><br><br>
    <a href="../PAG/barcos.php">Volver</a>
</form>
</body>
</html>