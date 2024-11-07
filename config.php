<?php
// Evitar que se muestren errores en producción
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de la base de datos
define('DB_HOST', 'localhost'); // Cambia esto si es necesario
define('DB_USER', 'root'); // Usuario de la base de datos
define('DB_PASS', ''); // Contraseña de la base de datos
define('DB_NAME', 'ADMINISTRACION'); // Nombre de la base de datos
define('DB_SOCKET', '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock'); // Ruta del socket

/**
 * Función para establecer la conexión a la base de datos
 *
 * @return PDO Objeto de conexión a la base de datos
 * @throws Exception Si hay un error en la conexión
 */
function conectarDB() {
    try {
        // Usamos el socket de MySQL en el DSN
        $dsn = "mysql:unix_socket=" . DB_SOCKET . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        
        // Opciones de configuración de PDO
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanza excepciones para errores
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Obtiene los resultados como arrays asociativos
            PDO::ATTR_EMULATE_PREPARES => false, // Utiliza declaraciones preparadas reales
        ];

        // Crear y devolver un nuevo objeto PDO
        return new PDO($dsn, DB_USER, DB_PASS, $opciones);
    } catch (PDOException $e) {
        // Registrar el error en el log del servidor
        error_log("Error de conexión: " . $e->getMessage());
        // Lanzar una excepción con un mensaje genérico
        throw new Exception("Error de conexión a la base de datos");
    }
}

// Ejemplo de uso
try {
    $pdo = conectarDB();
    // Aquí puedes realizar operaciones con la base de datos
} catch (Exception $e) {
    echo $e->getMessage(); // Mostrar un mensaje de error si la conexión falla
}
?>
