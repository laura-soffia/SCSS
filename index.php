<?php
//login

include "./db/conexion.php";
include "PAG/sigIn.php";

// $errores = [];
// $exito = false;
// if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nombre'])) {
//     $name = trim($_POST["nombre"]);
//     $last_name = trim($_POST["apellido"]);
//     $documento = trim($_POST["documento"]);
//     $email = trim($_POST["email"]);
//     $password = trim($_POST["password"]);
//     $c_password = trim($_POST["c_password"]);
//     $telefono = trim($_POST["telefono"]);
//     $errores = Validar_usuario($name, $last_name, $documento, $email, $telefono, $password, $c_password);
//     if (empty($errores)) {
//         $exit = insertar_usuarios($name, $last_name, $documento, $email, $telefono, $password);
//         if ($exit) {
//             $name = $last_name = $documento = $email = $password = $c_password = $telefono = '';
//         }
//     }
// }

//usuarios
// include "includes/users/create.php";
// $usuarios = obtener_usuarios();
//SI EXISTE

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexion DB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body>

    <body class="login">
        <div class="caja-login">
            <h1>Login</h1>
            <?php if (!empty($error_login)) { ?>
                <p class="error-login"><?php echo $error_login; ?></p>
            <?php } ?>
            <form action="" method="POST">
                <label for="dni-form">Documento</label>
                <input type="number" name="dni-form" id="dni-form">
                <label for="pw-form">Contraseña</label>
                <input type="password" name="pw-form" id="pw-form">
                <input type="submit" value="Ingresar" name="validar-usuario">
            </form>
        </div>
    </body>
</body>

</html>