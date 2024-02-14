<?php

require_once('./models/UserModel.php');
require_once('./jwt/JwtHandler.php');

class UserController
{
    public function login()
    {
        // Recibir datos del formulario o de la aplicación móvil
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Verificar credenciales en el modelo
        $userModel = new UserModel();
        $userData = $userModel->verifyCredentials($username, $password);

        if ($userData) {
            // Generar token y devolverlo como respuesta
            $jwt = JwtHandler::encode(['user_id' => $userData['id'], 'username' => $userData['username']]);
            echo json_encode(['token' => $jwt]);
        } else {
            // Credenciales inválidas
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales incorrectas']);
        }
    }

    public function registrar()
    {
        // Recibir datos del formulario de registro
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $username = $_POST['username_registro'];
        $password = $_POST['password_registro'];
        $fechaNacimiento = $_POST['fecha_nacimiento'];

        // Validar campos (puedes agregar más validaciones según tus necesidades)

        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Lógica para insertar el nuevo usuario en la base de datos
        $userModel = new UserModel();
        $registroExitoso = $userModel->registrarNuevoUsuario($nombre, $apellido, $email, $username, $hashedPassword, $fechaNacimiento);

        if ($registroExitoso) {
            // Registro exitoso
            return ['mensaje' => 'Registro exitoso. Ahora puedes iniciar sesión.'];
        } else {
            // Error en el registro
            return ['error' => 'Error al registrar el usuario. Por favor, intenta nuevamente.'];
        }
    }
}
