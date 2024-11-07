<?php

// Datos de conexión a la base de datos
$db_host = 'sfo1.clusters.zeabur.com';
$db_port = 31309;
$db_user = 'root';
$db_password = 'cvjMqnYeS8aU5r467flgzDwO1A032Es9';
$db_name = 'zeabur';

// Crear conexión usando mysqli
$db = mysqli_connect($db_host, $db_user, $db_password, $db_name, $db_port);

// Verificar si la conexión fue exitosa
if (!$db) {
    die("Error de conexión: " . mysqli_connect_error());
}
