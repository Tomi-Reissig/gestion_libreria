<?php
include 'includes/header.php';

require_once 'clases/Database.php';

$database = new Database();
$db = $database->getConnection();

/* =========================
   VALIDAR ID
========================= */

if (!isset($_GET['id'])) {

    echo "
    <div class='alert alert-danger'>
        ID no válido.
    </div>
    ";

    exit();
}

$id = $_GET['id'];

/* =========================
   OBTENER LIBRO
========================= */

$sql = "SELECT * FROM libros WHERE id = :id";

$stmt = $db->prepare($sql);

$stmt->bindParam(':id', $id);

$stmt->execute();

$libro = $stmt->fetch(PDO::FETCH_ASSOC);

/* =========================
   VALIDAR SI EXISTE LIBRO
========================= */

if (!$libro) {

    echo "
    <div class='alert alert-danger'>
        Libro no encontrado.
    </div>
    ";

    exit();
}

/* =========================
   ACTUALIZAR LIBRO
========================= */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $autor  = $_POST['autor'];
    $precio = $_POST['precio']; 
    $stock  = $_POST['stock'];  

    $update = "UPDATE libros SET
                titulo = :titulo,
                autor = :autor,
                precio = :precio,
                stock = :stock
                WHERE id = :id";

    $stmt = $db->prepare($update);

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {

        header("Location: index.php?mensaje=Libro actualizado correctamente");

        exit();

    } else {

        echo "
        <div class='alert alert-danger'>
            Error al actualizar el libro.
        </div>
        ";
    }
} 

?>

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow-lg border-0">

            <div class="card-header bg-warning text-dark">

                <h3 class="mb-0">
                    ✏️ Editar Libro
                </h3>

            </div>

            <div class="card-body">

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Título
                        </label>

                        <input
                            type="text"
                            name="titulo"
                            class="form-control"
                            value="<?php echo htmlspecialchars($libro['titulo']); ?>"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Autor
                        </label>

                        <input
                            type="text"
                            name="autor"
                            class="form-control"
                            value="<?php echo htmlspecialchars($libro['autor']); ?>"
                            required
                        >

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">
                                Precio ($)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="precio"
                                class="form-control"
                                value="<?php echo htmlspecialchars($libro['precio']); ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">
                                Stock (Cantidad)
                            </label>

                            <input
                                type="number"
                                name="stock"
                                class="form-control"
                                value="<?php echo htmlspecialchars($libro['stock']); ?>"
                                required
                            >

                        </div>

                    </div>

                    <div class="d-flex gap-2 mt-4">

                        <button
                            type="submit"
                            class="btn btn-success"
                        >
                            💾 Actualizar Libro
                        </button>

                        <a
                            href="index.php"
                            class="btn btn-secondary"
                        >
                            ⬅ Volver
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>