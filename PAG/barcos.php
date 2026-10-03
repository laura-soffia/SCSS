<?php
require "../db/conexion.php";
require "../includes/funciones.php";
require "../includes/barcos/create.php";
validarSession();
$barcos = obtener_barcos();

$mensajes = [
    0 => 'Barco agregado', 1 => 'Error al guardar',
    2 => 'Barco actualizado', 3 => 'Error al actualizar',
    4 => 'Barco eliminado', 5 => 'No se puede eliminar: el barco tiene salidas asociadas',
];
$status = isset($_GET['status']) ? (int) $_GET['status'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Barcos</title></head>
<body>
<h1>Barcos</h1>
<?php if ($status !== null && isset($mensajes[$status])) echo "<p><b>" . $mensajes[$status] . "</b></p>"; ?>
<a href="../form/formBarcos.php">Nuevo barco</a>
<table>
    <thead>
        <tr><th>Matrícula</th><th>Nombre</th><th>Amarre</th><th>Cuota</th><th>Socio</th><th>Opciones</th></tr>
    </thead>
    <tbody>
    <?php while ($barco = mysqli_fetch_assoc($barcos)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($barco['matricula']); ?></td>
            <td><?php echo htmlspecialchars($barco['nombre']); ?></td>
            <td><?php echo htmlspecialchars($barco['n_amarre']); ?></td>
            <td><?php echo number_format($barco['cuota_amarre'], 2); ?></td>
            <td><?php echo htmlspecialchars($barco['nombres'] . ' ' . $barco['apellidos']); ?></td>
            <td>
                <a href="../includes/barcos/delete.php?id=<?php echo urlencode($barco['matricula']); ?>" onclick="return confirm('¿Eliminar este barco?')">Eliminar</a>
                <a href="../includes/barcos/update.php?id=<?php echo urlencode($barco['matricula']); ?>">Actualizar</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<br><a href="dashboard.php">Volver al panel principal</a>
</body>
</html>