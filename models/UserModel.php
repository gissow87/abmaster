<?php

class UserModel
{
    public function verifyCredentials($username, $password)
    {
        // Lógica para verificar las credenciales en la base de datos
        // Devuelve los datos del usuario si las credenciales son válidas, o null en caso contrario
        // Aquí puedes usar consultas SQL para verificar las credenciales en una base de datos
        // No olvides aplicar medidas de seguridad como password_hash y consultas preparadas

        // Ejemplo básico utilizando PDO y consultas preparadas
        $pdo = getPdo();

        $stmt = $pdo->prepare("SELECT id, username, password FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró un usuario y si la contraseña coincide
        if ($userData && password_verify($password, $userData['password'])) {
            return $userData;
        } else {
            return null;
        }
    }

    public function registrarNuevoUsuario($nombre, $apellido, $email, $username, $hashedPassword, $fechaNacimiento)
    {
        // Lógica para insertar el nuevo usuario en la base de datos
        $pdo = getPdo();

        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, username, password, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?)");
        $registroExitoso = $stmt->execute([$nombre, $apellido, $email, $username, $hashedPassword, $fechaNacimiento]);

        return $registroExitoso;
    }
}
