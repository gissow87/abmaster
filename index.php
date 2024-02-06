<?php

require_once 'config.php';
require_once 'vendor/autoload.php';  // Asegúrate de incluir la biblioteca JWT

// Iniciar sesión si es necesario
session_start();

// Lógica para manejar las rutas y solicitudes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar la solicitud de inicio de sesión
    $userController = new UserController();
    $userController->login();
} else {
    // Manejar otras rutas o solicitudes
    // Puedes implementar más lógica aquí según tus necesidades
}