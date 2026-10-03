<?php
require_once __DIR__ . "/../../db/conexion.php";
require_once __DIR__ . "/../funciones.php";
require_once __DIR__ . "/../socios/create.php";
require_once __DIR__ . "/create.php";
validarSession();

$id = mysqli_real_escape_string($conex, $_GET['id']);
$resultado = mysqli_query($conex, "SELECT * FROM barco WHERE matricula = '$id'");
$data = mysqli_fetch_assoc($resultado);
if (!$data) { header("Location: ../../PAG/barcos.php"); exit; }

$errores = [];
if (isset($_POST['editar'])) {
    $nombre       = trim($_POST['nombre']);
    $n_amarre     = trim($_POST['n_amarre']);
    $cuota        = trim($_POST['cuota_amarre']);
    $socio_cedula = trim($_POST['socio_cedula']);

    $errores = validar_barco($data['matricula'], $nombre, $n_amarre, $cuota, $socio_cedula, true);

    if (empty($errores)) {
        $n = mysqli_real_escape_string($conex, $nombre);
        $a = mysqli_real_escape_string($conex, $n_amarre);
        $s = mysqli_real_escape_string($conex, $socio_cedula);
        $c = (float) $cuota;
        $exito = mysqli_query($conex, "UPDATE barco SET nombre='$n', n_amarre='$a', cuota_amarre=$c, socio_cedula='$s' WHERE matricula='$id'");
        header("Location: ../../PAG/barcos.php?status=" . ($exito ? 2 : 3));
        exit;
    }
    $data = array_merge($data, ['nombre' => $nombre, 'n_amarre' => $n_amarre, 'cuota_amarre' => $cuota, 'socio_cedula' => $socio_cedula]);
}
$socios = obtener_socios();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Actualizar barco</title></head>
<body>
<h2>Actualizar barco</h2>
<?php foreach ($errores as $error) echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>"; ?>
<form action="" method="POST">
    <label>Matrícula (no editable):</label>
    <input type="text" value="<?php echo htmlspecialchars($data['matricula']); ?>" disabled><br><br>
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($data['nombre']); ?>"><br><br>
    <label>Número de amarre:</label>
    <input type="text" name="n_amarre" value="<?php echo htmlspecialchars($data['n_amarre']); ?>"><br><br>
    <label>Cuota de amarre:</label>
    <input type="number" step="0.01" min="0" name="cuota_amarre" value="<?php echo htmlspecialchars($data['cuota_amarre']); ?>"><br><br>
    <label>Socio:</label>
    <select name="socio_cedula">
        <?php while ($socio = mysqli_fetch_assoc($socios)) { ?>
            <option value="<?php echo htmlspecialchars($socio['cedula']); ?>"
                <?php if ($socio['cedula'] === $data['socio_cedula']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($socio['nombres'] . ' ' . $socio['apellidos'] . ' (' . $socio['cedula'] . ')'); ?>
            </option>
        <?php } ?>
    </select><br><br>
    <button type="submit" name="editar">Actualizar</button><br><br>
    <a href="../../PAG/barcos.php">Volver</a>
</form>
</body>
</html>