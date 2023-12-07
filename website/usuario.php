<?php
    // Importar la conexión
    require_once __DIR__ . '/includes/app.php';

    // Crear email y password
    $username = "andrew";
    $password = "Gualbert456";

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Query para crear el usuario
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$passwordHash')";
    // debuggear($query);
    // echo $query;

    // Agregarlo a la base de datos
    $db->query($query);