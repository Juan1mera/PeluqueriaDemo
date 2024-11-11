<?php

// Datos de conexión a la base de datos
// $db_host = 'sfo1.clusters.zeabur.com';
// $db_port = 31309;
// $db_user = 'root';
// $db_password = 'cvjMqnYeS8aU5r467flgzDwO1A032Es9';
// $db_name = 'zeabur';

// Crear conexión usando mysqli
$db_host = $_ENV['DB_HOST'] ?? 'localhost';
$db_user = $_ENV['DB_USER'] ?? 'root';
$db_password = $_ENV['DB_PASSWORD'] ?? '';
$db_name = $_ENV['DB_NAME'] ?? 'database';
$db_port = $_ENV['DB_PORT'] ?? 3306; 

// Crear conexión usando mysqli
$db = mysqli_connect($db_host, $db_user, $db_password, $db_name, $db_port);

$db->set_charset('utf8');

// Verificar si la conexión fue exitosa
if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}
