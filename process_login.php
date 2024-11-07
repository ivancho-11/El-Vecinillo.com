<?php
session_start();

// Obtener datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Conexión a la base de datos
    $servername = "127.0.0.1";
    $username = "LINA";        // Usar 'LINA' en lugar de 'root'
    $password_db = "1234";     // Contraseña de 'LINA'
    $dbname = "ADMINISTRACION"; // Asegúrate de que este nombre sea correcto

    // Crear conexión
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para verificar usuario
    $sql = "SELECT * FROM usuarios WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $email;  // Guardar sesión del usuario
        header("Location: panel_admin.php"); // Redirigir a la página admin
        exit();
    } else {
        echo "Credenciales incorrectas.";
    }

    $stmt->close();
    $conn->close();
}
?>
