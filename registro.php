<?php
// registro.php
require_once 'clases/Database.php';
require_once 'clases/Usuario.php';

// Se crean variables vacías para futuros mensajes
$mensaje = "";
$tipo_alerta = "";


// VERIFICAR SI EL FORMULARIO FUE ENVIADO
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Se pregunta si se envió el formulario
    $database = new Database(); // Crea el objeto Database
    $db = $database->getConnection();  // Obtiene la conexión a MySQL
    $usuario = new Usuario($db); // Crea el objeto Usuario y se le pasa la conexión

    // OBTENER DATOS DEL FORMULARIO
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // REGISTRAR USUARIO
    $resultado = $usuario->registrar($nombre, $email, $password); // Llama al método registrar() y guarda el resultado

    
    if ($resultado === true) { // SI EL REGISTRO FUE EXITOSO
        $mensaje = "¡Usuario registrado con éxito! Ya puedes iniciar sesión.";
        $tipo_alerta = "success"; // Alerta verde de Bootstrap 
    } else { // SI HUBO ERROR
        $mensaje = $resultado;
        $tipo_alerta = "danger"; // Alerta roja de Bootstrap 
    }
}
$ocultar_accesos = true;
include 'includes/header.php'; // Incluye el menú y el inicio del HTML
?>

<div class="row justify-content-center mt-5"> 
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Registro de Usuario</h3> <!-- Título del formulario -->
                

                <!-- MOSTRAR MENSAJES-->
                <?php if (!empty($mensaje)): ?> <!-- Si la variable $mensaje no está vacía hace lo siguiente -->
                    <div class="alert alert-<?php echo $tipo_alerta; ?> alert-dismissible fade show" role="alert"> <!-- Crea la alerta --> 
                        <?php echo $mensaje; ?> <!-- Muestra el mensaje -->
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> <!-- Crea la "X" para cerrar la alerta -->
                    </div>
                <?php endif; ?>

                <form action="registro.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Registrarse</button>
                </form>
                <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; // Incluye le footer?>