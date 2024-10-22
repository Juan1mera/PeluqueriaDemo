<?php

$db = mysqli_connect('localhost', 'root', 'merabarrera14', 'leos_style');


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
