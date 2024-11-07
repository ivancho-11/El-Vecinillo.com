<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['user'])) {
    header('HTTP/1.0 403 Forbidden');
    echo json_encode(["error" => "No autorizado"]);
    exit();
}

// Conexión a la base de datos
$servername = "127.0.0.1";
$username = "LINA";
$password_db = "1234";
$dbname = "ADMINISTRACION";

// Crear conexión
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Obtener productos
$sql = "SELECT id, nombre, precio FROM productos";
$result = $conn->query($sql);

if (!$result) {
    die(json_encode(["error" => "Error en la consulta: " . $conn->error]));
}

// Obtener todos los productos
$productos = $result->fetch_all(MYSQLI_ASSOC);

// Verificar si hay productos
header('Content-Type: application/json');
if (empty($productos)) {
    echo json_encode(["error" => "No hay productos disponibles"]);
} else {
    // Devolver los productos en formato JSON
    echo json_encode($productos);
}

// Cerrar conexión
$conn->close();
?>
