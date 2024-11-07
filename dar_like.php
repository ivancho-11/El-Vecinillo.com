<?php
require_once 'config.php'; // Asegúrate de incluir tu archivo de configuración para la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si el ID del testimonio se ha enviado
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Conectar a la base de datos
        $pdo = conectarDB();
        if (!$pdo) {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo conectar a la base de datos.']);
            exit();
        }

        try {
            // Incrementa el contador de likes en la base de datos
            $sql = "UPDATE testimonios SET likes = likes + 1 WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirecciona de vuelta a la página de testimonios
            header("Location: testimonios.php?mensaje=success");
            exit();
        } catch (Exception $e) {
            // Redirecciona de vuelta a la página de testimonios con un mensaje de error
            header("Location: testimonios.php?mensaje=error");
            exit();
        }
    } else {
        // Redirecciona si no se recibe el ID
        header("Location: testimonios.php?mensaje=error");
        exit();
    }
} else {
    // Si no es un POST, redirecciona a la página de testimonios
    header("Location: testimonios.php");
    exit();
}
?>
