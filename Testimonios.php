<?php
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] === 'success') {
        echo '<div class="alert alert-success">¡Like registrado con éxito!</div>';
    } elseif ($_GET['mensaje'] === 'error') {
        echo '<div class="alert alert-danger">Ha ocurrido un error. Intenta nuevamente.</div>';
    }
}

require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <img class="logo-2" src="images/el vecinillo.png" alt="">
    
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png" sizes="180x180">
    <style>
        body {
  background-color: #1877f2;
  font-family: "Poppins", sans-serif;
}
        .logo-2 {
            display: block;
            margin: 0 auto;
            width: 150px;
            border-radius: 50%;
        }
        .card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: none;
            margin-top: 30px;
        }
        .comentarios {
            margin-top: 50px;
        }
        .comentario {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .comentario h5 {
            margin: 0;
            font-weight: 500;
        }
        .comentario p {
            margin: 10px 0 0;
            font-size: 15px;
            color: #555;
        }
        .comentario time {
            font-size: 12px;
            color: #aaa;
        }
        .btn-like {
            color: #1877f2;
            background-color: transparent;
            border: none;
            padding: 0;
        }
        .btn-like:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php
                if (isset($_GET['mensaje'])) {
                    if ($_GET['mensaje'] == 'success') {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                ¡Gracias! Tu comentario ha sido enviado correctamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    } else if ($_GET['mensaje'] == 'error') {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Hubo un error al enviar tu comentario. Por favor, intenta nuevamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    }
                }
                ?>
                <div class="card">
                    <div class="card-header text-center">
                        <h1 class="h3">Dejanos tus comentarios</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="procesar_testimonio.php">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Deja tu comentario aquí" id="comentario" name="comentario" style="height: 150px" required></textarea>
                                <label for="comentario">Tu opinión nos importa</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="comentarios">
                    <h3 class="text-center mt-5">Comentarios recientes</h3>
                    <?php
                    $pdo = conectarDB();
                    if (!$pdo) {
                        echo "No se pudo conectar a la base de datos.";
                        exit();
                    }
                    
                    try {
                        $sql = "SELECT id, nombre, comentario, fecha, likes FROM testimonios ORDER BY fecha DESC LIMIT 10";
                        $stmt = $pdo->query($sql);

                        if ($stmt && $stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch()) {
                                echo '<div class="comentario">
                                        <h5>' . htmlspecialchars($row['nombre']) . '</h5>
                                        <p>' . htmlspecialchars($row['comentario']) . '</p>
                                        <time>' . date('d/m/Y H:i', strtotime($row['fecha'])) . '</time>
                                        <div class="d-flex justify-content-between mt-2">
                                            <form method="POST" action="dar_like.php" style="display:inline;">
                                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                                <button type="submit" class="btn-like">👍 Like (' . $row['likes'] . ')</button>
                                            </form>
                                        </div>
                                      </div>';
                            }
                        } else {
                            echo '<p class="text-center">Aún no hay comentarios. ¡Sé el primero en dejar uno!</p>';
                        }
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">Error al cargar los comentarios: ' . $e->getMessage() . '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
