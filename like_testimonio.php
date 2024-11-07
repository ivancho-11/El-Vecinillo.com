<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $testimonioId = isset($_POST['testimonio_id']) ? $_POST['testimonio_id'] : '';

    if ($testimonioId) {
        $pdo = conectarDB();
        
        // Suponiendo que tienes una tabla 'likes' para registrar los likes
        $stmt = $pdo->prepare("INSERT INTO likes (testimonio_id) VALUES (:testimonio_id)");
        $stmt->bindParam(':testimonio_id', $testimonioId);
        
        if ($stmt->execute()) {
            // Contar el número total de likes
            $countStmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE testimonio_id = :testimonio_id");
            $countStmt->bindParam(':testimonio_id', $testimonioId);
            $countStmt->execute();
            $likeCount = $countStmt->fetchColumn();

            echo json_encode(['status' => 'success', 'like_count' => $likeCount]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo registrar el like.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de testimonio no válido.']);
    }
}
?>
