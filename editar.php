<?php

include 'includes/header.php';


include 'conexion.php';



$id = $_GET['id'];



$sql = "SELECT * FROM libros WHERE id = '$id'";
$resultado = mysqli_query($conexion, $sql);

$libro = mysqli_fetch_assoc($resultado);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $autor  = $_POST['autor'];
    $anio   = $_POST['anio'];
    $genero = $_POST['genero'];

    $update = "UPDATE libros SET
                titulo = '$titulo',
                autor = '$autor',
                anio = '$anio',
                genero = '$genero'
                WHERE id = '$id'";

    if (mysqli_query($conexion, $update)) {

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
                            value="<?php echo $libro['titulo']; ?>"
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
                            value="<?php echo $libro['autor']; ?>"
                            required
                        >

                    </div>

                   
                    <div class="row">

                       
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">
                                Año
                            </label>

                            <input
                                type="number"
                                name="anio"
                                class="form-control"
                                value="<?php echo $libro['anio']; ?>"
                            >

                        </div>

                        
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-bold">
                                Género
                            </label>

                            <input
                                type="text"
                                name="genero"
                                class="form-control"
                                value="<?php echo $libro['genero']; ?>"
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