<?php
// 1. Activamos errores para ver si la base de datos rechaza la consulta
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';

// 2. Conectamos la base de datos
require_once 'clases/Database.php';

$database = new Database();
$db = $database->getConnection();

// 3. Verificamos si el usuario apretó el botón de enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Capturamos EXACTAMENTE lo que viene del formulario HTML
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
    $autor  = isset($_POST['autor']) ? $_POST['autor'] : '';
    $precio = isset($_POST['precio']) ? $_POST['precio'] : 0;
    $stock  = isset($_POST['stock']) ? $_POST['stock'] : 0;

    // Ejecutamos la consulta usando las columnas reales de tu MySQL (precio y stock)
    $sql = "INSERT INTO libros (titulo, autor, precio, stock) VALUES (:titulo, :autor, :precio, :stock)";
    
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':stock', $stock);

    if ($stmt->execute()) {
        // Redirecciona al listado principal con mensaje de éxito
        header("Location: index.php?mensaje=Libro agregado correctamente");
        exit();
    } else {
        echo "
        <div class='alert alert-danger'>
            Error interno: No se pudo guardar el libro en la base de datos.
        </div>
        ";
    }
}
?>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow-lg border-0">

            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    📘 Agregar Nuevo Libro
                </h3>
            </div>

            <div class="card-body">

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Título</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: El Principito" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Autor</label>
                        <input type="text" name="autor" class="form-control" placeholder="Ej: Antoine de Saint-Exupéry" required>
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Precio ($) / Año</label>
                            <input type="number" step="0.01" name="precio" class="form-control" placeholder="0.00" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stock / Género</label>
                            <input type="number" name="stock" class="form-control" placeholder="0" required>
                        </div>

                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-success">
                            💾 Guardar Libro
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            ⬅ Volver
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>