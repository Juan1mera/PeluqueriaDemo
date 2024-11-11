<?php

// Datos de conexión a la base de datos
// $db_host = 'sfo1.clusters.zeabur.com';
// $db_port = 31309;
// $db_user = 'root';
// $db_password = 'cvjMqnYeS8aU5r467flgzDwO1A032Es9';
// $db_name = 'zeabur';

// Crear conexión usando mysqli
$db = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME'], $_ENV['DB_PORT']);

$db->set_charset('utf8');

// Verificar si la conexión fue exitosa
if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}
