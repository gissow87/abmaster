<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/index.css">
    <title>Iniciar Sesión / Registrarse</title>
</head>

<body>

    <?php
    require_once 'config/config.php';
    require_once 'vendor/autoload.php';
    require_once 'controllers/UserController.php';

    // Iniciar sesión si es necesario
    session_start();

    // Lógica para manejar las rutas y solicitudes
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController();

        if (isset($_POST['login'])) {
            // Manejar la solicitud de inicio de sesión
            $loginResult = $userController->login();
        } elseif (isset($_POST['registro'])) {
            // Manejar la solicitud de registro
            $registroResult = $userController->registrar();
        }
    }
    // Comprobar si el usuario está logado
    $usuarioLogado = isset($_SESSION['user_id']);

    // Determinar qué vista mostrar
    if ($usuarioLogado) {
        // Usuario logado, muestra la pantalla principal o cualquier otra vista que necesites
        require_once 'vistas/HomeView.php'; // Reemplaza con el nombre de tu vista principal
    } else {
        // Usuario no logado, muestra la pantalla de inicio de sesión
        require_once 'view/User/Login.php'; // Reemplaza con el nombre de tu vista de inicio de sesión
    }
    ?>


    <?php if (isset($loginResult['error'])) : ?>
        <p style="color: red;"><?php echo $loginResult['error']; ?></p>
    <?php elseif (isset($loginResult['token'])) : ?>
        <p style="color: green;">Inicio de sesión exitoso. Token: <?php echo $loginResult['token']; ?></p>
    <?php endif; ?>


    <?php if (isset($registroResult['error'])) : ?>
        <p style="color: red;"><?php echo $registroResult['error']; ?></p>
    <?php elseif (isset($registroResult['mensaje'])) : ?>
        <p style="color: green;"><?php echo $registroResult['mensaje']; ?></p>
    <?php endif; ?>
</body>

</html>