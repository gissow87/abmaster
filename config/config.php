<?php
define('SECRET_KEY', 'putoelquelee');
define('ALGORITHM', 'HS256');
define('ISSUER', 'ABMaster');

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ABMaster');

function getPdo(){
    return 
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
}