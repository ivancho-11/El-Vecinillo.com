<?php
session_start();
header('Content-Type: application/json');

// Verificar autenticación
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "error" => "No autorizado"]);
    exit();
}

// Recibir los datos de la venta
$datos = json_decode(file_get_contents('php://input'), true);

if (!$datos) {
    echo json_encode(["success" => false, "error" => "Datos inválidos"]);
    exit();
}

// Crear nombre de archivo con fecha
$archivo = 'ventas_' . date('Y-m-d') . '.txt';

// Formatear datos para el registro
$registro = date('Y-m-d H:i:s') . " | ";
$registro .= "Total: $" . number_format($datos['total'], 2) . " | ";
$registro .= "Items: ";

foreach ($datos['items'] as $item) {
    $registro .= "{$item['nombre']}(x{$item['cantidad']}) ";
}

$registro .= "\n";

// Guardar en archivo
if (file_put_contents($archivo, $registro, FILE_APPEND)) {
    // También guardar en la base de datos si es necesario
    guardarEnBaseDeDatos($datos);
    
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Error al guardar el registro"]);
}

function guardarEnBaseDeDatos($datos) {
    // Conexión a la base de datos
    $servername = "127.0.0.1";
    $username = "LINA";
    $password_db = "1234";
    $dbname = "ADMINISTRACION";

    try {
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        if ($conn->connect_error) {
            throw new Exception("Conexión fallida: " . $conn->connect_error);
        }

        // Insertar la venta
        $sql = "INSERT INTO ventas (fecha, total, usuario_id) VALUES (NOW(), ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $datos['total'], $_SESSION['user']['id']);
        $stmt->execute();
        
        $venta_id = $stmt->insert_id;

        // Insertar los items de la venta
        $sql = "INSERT INTO ventas_items (venta_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        foreach ($datos['items'] as $item) {
            $stmt->bind_param("iiid", $venta_id, $item['id'], $item['cantidad'], $item['precio']);
            $stmt->execute();
        }

        $conn->close();
    } catch (Exception $e) {
        error_log("Error en base de datos: " . $e->getMessage());
        // Continuar aunque haya error en BD, ya que tenemos el registro en archivo
    }
}
?>