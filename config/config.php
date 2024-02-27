<?php
define('METHOD','AES-256-CBC');
define('SECRET_KEY','@#cats@#programming@#');
define('SECRET_IV','070707');
define('ISSUER', 'ABMaster');
define('COMPANY', "By Cats Programming");
define('SERVERURL', "http://localhost/ABMaster/");

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ABMaster');

define('SGDB', "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME);