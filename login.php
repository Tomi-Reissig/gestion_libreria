<?php
require_once 'clases/Database.php';
require_once 'clases/Usuario.php';

$error = ""; // Se crea variable vacía para guardar mensajes de error

// VERIFICAR SI EL FORMULARIO FUE ENVIADO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $database = new Database(); // Crea el objeto Database
    $db = $database->getConnection(); // Obtiene la conexión a MySQL
    $usuario = new Usuario($db); // Crea el objeto Usuario y se le pasa la conexión

    // OBTENER DATOS DEL FORMULARIO
    $email = $_POST['email']; // Obtiene el email ingresado
    $password = $_POST['password']; // Obtiene la contraseña ingresada

    // INTENTAR INICIAR SESIÓN
    if ($usuario->login($email, $password)) { // Ejecuta el método login()
        // LOGIN CORRECTO
        header("Location: index.php"); // Redirige al usuario a index.php
        exit(); // Detiene la ejecución de este código
    } else {
        // LOGIN INCORRECTO
        $error = "Correo electrónico o contraseña incorrectos."; // Guarda mensaje de error
    }
}

include 'includes/header.php'; // Incluye menú, Bootstrap y comienzo del HTML
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Iniciar Sesión</h3> <!-- Título del formulario -->
                
                <?php if (!empty($error)): ?> <!-- Si la variable $error no está vacía hace lo siguiente -->
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>
                <p class="text-center mt-3">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php';?>