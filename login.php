<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000; /* Fondo negro */
            color: #fff; /* Texto blanco */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Altura completa de la ventana */
            font-family: 'Poppins', sans-serif; /* Fuente Poppins */
            flex-direction: column; /* Colocar elementos en columna */
        }

        h2 {
            margin-bottom: 20px; /* Espacio debajo del título */
        }

        .logo-2 {
            max-width: 150px; /* Ajusta el tamaño del logo */
            margin-bottom: 20px; /* Espacio debajo del logo */
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.1); /* Fondo semitransparente */
            padding: 30px; /* Espaciado interno */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Sombra del cuadro */
            width: 300px; /* Ancho fijo del formulario */
        }

        input[type="submit"] {
            background-color: #db241b; /* Color de fondo del botón */
            color: #fff; /* Color del texto del botón */
            border: none; /* Sin borde */
            padding: 10px; /* Espaciado interno del botón */
            border-radius: 5px; /* Bordes redondeados del botón */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
        }

        input[type="submit"]:hover {
            background-color: #f40d0d; /* Color al pasar el mouse */
        }
    </style>
</head>
<body>
    <img class="logo-2" src="images/el vecinillo.png" alt="Logo alternativo">
    
    <div class="form-container">
        <h2>Hey tú, ingresa a tu administrador</h2>
        <form action="process_login.php" method="POST">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="" required>
                <label for="floatingInput">Correo</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Contraseña" required>
                <label for="floatingPassword">Contraseña</label>
            </div>
            <input type="submit" value="Iniciar sesión" class="btn btn-block">
        </form>
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>