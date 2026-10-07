<?php
require "../db/conexion.php";
require "../includes/funciones.php";
require "../includes/salidas/create.php";
validarSession();
$salidas = obtener_salidas();

$mensajes = [
    0 => 'Salida agregada', 1 => 'Error al guardar',
    2 => 'Salida actualizada', 3 => 'Error al actualizar',
    4 => 'Salida eliminada', 5 => 'Error al eliminar',
];
$status = isset($_GET['status']) ? (int) $_GET['status'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Salidas</title></head>
<body>
<h1>Salidas</h1>
<?php if ($status !== null && isset($mensajes[$status])) echo "<p><b>" . $mensajes[$status] . "</b></p>"; ?>
<a href="../form/formSalidas.php">Nueva salida</a>
<table>
    <thead>
        <tr><th>ID</th><th>Fecha</th><th>Hora</th><th>Destino</th><th>Barco</th><th>Socio</th><th>Opciones</th></tr>
    </thead>
    <tbody>
    <?php while ($salida = mysqli_fetch_assoc($salidas)) { ?>
        <tr>
            <td><?php echo $salida['IdSalida']; ?></td>
            <td><?php echo htmlspecialchars($salida['Fecha']); ?></td>
            <td><?php echo htmlspecialchars(substr($salida['Hora'], 0, 5)); ?></td>
            <td><?php echo htmlspecialchars($salida['Destino']); ?></td>
            <td><?php echo htmlspecialchars($salida['barco'] . ' (' . $salida['matricula'] . ')'); ?></td>
            <td><?php echo htmlspecialchars($salida['nombres'] . ' ' . $salida['apellidos']); ?></td>
            <td>
                <a href="../includes/salidas/delete.php?id=<?php echo $salida['IdSalida']; ?>" onclick="return confirm('¿Eliminar esta salida?')">Eliminar</a>
                <a href="../includes/salidas/update.php?id=<?php echo $salida['IdSalida']; ?>">Actualizar</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<br><a href="dashboard.php">Volver al panel principal</a>
</body>
</html>