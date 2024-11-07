<?php
// Conexión a la base de datos
$servername = "127.0.0.1"; // o "localhost"
$username = "root";
$password = "1111"; // Asegúrate de que esta sea la contraseña correcta
$dbname = "ADMINISTRACION";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos: " . $dbname;
}

// Aquí puedes continuar con tus operaciones en la base de datos

// Cerrar conexión al final del script (opcional)
$conn->close();
?>