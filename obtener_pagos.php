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

// Consulta a la base de datos para obtener los pagos pendientes
$sql = "SELECT id, descripcion, monto FROM pagos WHERE estado = 'pendiente'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $pagos = [];
    while($row = $result->fetch_assoc()) {
        $pagos[] = $row;
    }
    echo json_encode($pagos);
} else {
    echo json_encode(["error" => "No hay pagos pendientes"]);
}

$conn->close();
?>
