<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'application/config/database.php';

// Conectar a la base de datos usando CI
$mysqli = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);

if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

// Datos del usuario admin
$username = 'admin';
$password = 'admin'; // contraseña en texto plano
$nombre_completo = 'Administrador';
$rol = 'admin';
$activo = 1;

// Generar hash de la contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar en la tabla usuarios
$sql = "INSERT INTO usuarios (username, password, nombre_completo, rol, activo)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ssssi', $username, $hash, $nombre_completo, $rol, $activo);

if ($stmt->execute()) {
    echo "Usuario admin creado correctamente.\n";
    echo "Usuario: admin\nContraseña: admin\n";
} else {
    echo "Error al crear el usuario: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
