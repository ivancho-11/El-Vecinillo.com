<?php
// Conectar a la base de datos
$servername = "127.0.0.1";
$username = "LINA";
$password_db = "1234";
$dbname = "ADMINISTRACION";

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conn->connect_error]));
}

// Obtener el cuerpo de la solicitud POST
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['pagos'])) {
    // Preparar la consulta SQL para evitar inyección de SQL
    $stmt = $conn->prepare("UPDATE pagos SET estado = 'pagado' WHERE id = ?");
    
    foreach ($data['pagos'] as $pago) {
        // Asignar el valor del pago ID al parámetro de la consulta
        $stmt->bind_param("i", $pago['id']);
        
        // Ejecutar la consulta preparada
        if (!$stmt->execute()) {
            die(json_encode(["error" => "Error al actualizar el pago con ID: " . $pago['id']]));
        }
    }
    
    // Cerrar la declaración preparada
    $stmt->close();
    
    // Cerrar la conexión
    $conn->close();
    
    // Devolver una respuesta exitosa
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "No se recibieron pagos para actualizar"]);
}
?>

