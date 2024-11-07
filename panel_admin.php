<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$servername = "127.0.0.1";
$username = "LINA";        // Usar 'LINA' en lugar de 'root'
$password_db = "1234";     // Contraseña de 'LINA'
$dbname = "ADMINISTRACION";

// Crear conexión
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para obtener todos los productos
function obtenerProductos() {
    global $conn;
    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}

// Función para actualizar el precio de un producto

function actualizarPrecio($id, $precio) {
    global $conn;

    $sql = "UPDATE productos SET precio = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("di", $precio, $id);

    if ($stmt->execute()) {
        echo "<p>Precio actualizado correctamente.</p>";
    } else {
        echo "<p>Error al actualizar el precio: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Función para insertar un nuevo producto

function insertarProducto($nombre, $precio) {
    global $conn;

    $sql = "INSERT INTO productos (nombre, precio) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("sd", $nombre, $precio);

    if ($stmt->execute()) {
        echo "<p>Producto añadido correctamente.</p>";
    } else {
        echo "<p>Error al añadir el producto: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Lógica para actualizar el precio de un producto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nuevo_producto'])) {
        // Añadir nuevo producto
        $nombre = $_POST['nombre'];
        $precio = floatval($_POST['precio']);

        if (!empty($nombre) && $precio > 0) {
            insertarProducto($nombre, $precio);
        } else {
            echo "<p>Por favor, ingresa un nombre válido y un precio mayor a 0.</p>";
        }
    } else {
        // Actualizar precio de producto
        $id = intval($_POST['id']);
        $precio = floatval($_POST['precio']);

        if ($id > 0 && $precio >= 0) {
            actualizarPrecio($id, $precio);
        } else {
            echo "<p>Datos inválidos.</p>";
        }
    }
}

// Obtener productos
$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Vecinillo</title>
    <style>
        body {
            background-color: #f4f4f4; /* Color de fondo gris claro */
            font-family: Arial, sans-serif; /* Fuente general */
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333; /* Fondo oscuro para la cabecera */
            color: white; /* Color del texto en la cabecera */
            padding: 20px; /* Espaciado interno */
            text-align: center; /* Centrar texto */
        }

        .logo-2 {
            max-width: 150px; /* Ajusta el tamaño del logo */
            margin-bottom: 10px; /* Espacio debajo del logo */
        }

        h2 {
            margin-top: 0; /* Eliminar margen superior del título */
        }

        h3 {
            text-align: center;
        }

        table {
    width: 100%; /* La tabla sigue ocupando el 100% del ancho */
    border-collapse: collapse;
    margin-top: 20px;
    table-layout: fixed; /* Permite definir anchos específicos para las columnas */
}

th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    overflow: hidden; /* Oculta el desbordamiento de texto */
    white-space: nowrap; /* Evita que el texto se divida en varias líneas */
    text-overflow: ellipsis; /* Agrega puntos suspensivos si el texto es muy largo */
}

th {
    background-color: #333;
    color: white;
}

td:nth-child(2) {
    width: 40%; /* Ancho fijo para la columna de nombre */
}

td:nth-child(3) {
    width: 20%; /* Ancho fijo para la columna de precio */
}

input[type="text"] {
    width: 100%; /* El campo de texto ocupa todo el espacio disponible */
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box; /* Incluye el padding dentro del ancho del input */
}


        input[type="submit"]:hover {
            background-color: #218838; /* Color más oscuro al pasar el mouse sobre el botón */
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #007bff; /* Color azul para el enlace de cerrar sesión */
        }

        a:hover {
            text-decoration: underline; /* Subrayar enlace al pasar el mouse */
        }
    </style>
</head>
<body>
    <div class="header">
        <img class="logo-2" src="images/el vecinillo.png" alt="Logo alternativo">
        <h2>Panel de Administración - Vecinillo</h2>
    </div>

    <!-- Formulario para añadir nuevos productos -->
    <h3>Añadir nuevo producto</h3>
    <form method="POST">
        <label for="nombre">Nombre del producto:</label>
        <input type="text" name="nombre" id="nombre" required>
        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" required>
        <input type="hidden" name="nuevo_producto" value="1">
        <input type="submit" value="Añadir Producto">
    </form>

    <!-- Tabla para mostrar y actualizar productos existentes -->
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?php echo htmlspecialchars($producto['id']); ?></td>
            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            <td><?php echo htmlspecialchars($producto['precio']); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
                    <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
                    <input type="submit" value="Actualizar">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
