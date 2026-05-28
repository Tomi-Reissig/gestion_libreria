<?php include 'includes/header.php'; ?>

<?php

include_once 'clases/Database.php';
include_once 'clases/Producto.php';


$database = new Database();
$db = $database->getConnection(); 


$producto = new Producto($db);


$stmt = $producto->listar(); 

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Listado de Libros</h2>

    <a href="agregar.php" class="btn btn-primary">
        + Nuevo Libro
    </a>
</div>


<div class="alert alert-success alert-dismissible fade show" role="alert">
    Libro agregado correctamente.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<div class="table-responsive">

    <table class="table table-hover table-bordered align-middle">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Año</th>
                <th>Género</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>1</td>
                <td>El Principito</td>
                <td>Antoine de Saint-Exupéry</td>
                <td>1943</td>
                <td>Ficción</td>

                <td class="text-center">

                    <a href="editar.php?id=1" class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <button
                        class="btn btn-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEliminar">
                        Eliminar
                    </button>

                </td>
            </tr>

        </tbody>

    </table>

</div>

<?php include 'includes/footer.php'; ?>



<div class="modal fade" id="modalEliminar" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar eliminación</h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                ¿Seguro que deseas eliminar este libro?
            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancelar
                </button>

                <a href="eliminar.php?id=1" class="btn btn-danger">
                    Sí, eliminar
                </a>

            </div>

        </div>

    </div>

</div>