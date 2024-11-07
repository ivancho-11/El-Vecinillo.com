<?php
require_once 'config.php'; // Incluye el archivo de configuración

try {
    $pdo = conectarDB(); // Llama a la función conectarDB desde config.php
    
    // Validar y limpiar datos de entrada
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_STRING);
    
    if (!$nombre || !$email || !$comentario) {
        throw new Exception("Datos de formulario inválidos");
    }
    
    // Preparar la consulta
    $sql = "INSERT INTO testimonios (nombre, email, comentario, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    
    // Ejecutar la consulta
    if ($stmt->execute([$nombre, $email, $comentario])) {
        header("Location: Testimonios.php?mensaje=success");
    } else {
        throw new Exception("Error al insertar el comentario");
    }
    
} catch (Exception $e) {
    error_log($e->getMessage());
    header("Location: Testimonios.php?mensaje=error");
    exit();
}
