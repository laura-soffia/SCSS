<?php
require "../db/conexion.php";
require "../includes/funciones.php";
require "../includes/socios/create.php";
validarSession();
$socios = obtener_socios();

$mensajes = [
    0 => 'Socio agregado', 1 => 'Error al guardar',
    2 => 'Socio actualizado', 3 => 'Error al actualizar',
    4 => 'Socio eliminado', 5 => 'No se puede eliminar: el socio tiene barcos asociados',
];
$status = isset($_GET['status']) ? (int) $_GET['status'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Socios</title></head>
<body>
<h1>Clientes (socios)</h1>
<?php if ($status !== null && isset($mensajes[$status])) echo "<p><b>" . $mensajes[$status] . "</b></p>"; ?>
<a href="../form/formSocios.php">Nuevo socio</a>
<table border="1" cellpadding="5">
    <thead>
        <tr><th>Cédula</th><th>Nombres</th><th>Apellidos</th><th>Dirección</th><th>Teléfono</th><th>Opciones</th></tr>
    </thead>
    <tbody>
    <?php while ($s = mysqli_fetch_assoc($socios)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($s['cedula']); ?></td>
            <td><?php echo htmlspecialchars($s['nombres']); ?></td>
            <td><?php echo htmlspecialchars($s['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($s['direccion']); ?></td>
            <td><?php echo htmlspecialchars($s['telefono']); ?></td>
            <td>
                <a href="../includes/socios/delete.php?id=<?php echo urlencode($s['cedula']); ?>" onclick="return confirm('¿Eliminar este socio?')">Eliminar</a>
                <a href="../includes/socios/update.php?id=<?php echo urlencode($s['cedula']); ?>">Actualizar</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<br><a href="dashboard.php">Volver al panel principal</a>
</body>
</html>