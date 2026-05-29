<?php
require_once 'verificar_sesion.php'; 
// Agregamos las clases
include_once 'clases/Database.php';
include_once 'clases/Producto.php';

$database = new Database();
$db = $database->getConnection();
$producto = new Producto($db);

// Capturamos el ID y el botón del index
$id_producto = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_producto) {
    // Le pasamos el ID de la clase
    $producto->id = $id_producto;
    
    // Ejecutamos eliminar
    if ($producto->eliminar()) {
        // Si sale bien, vuelve al index con un aviso de éxito
        header("Location: index.php?mensaje=eliminado");
        exit;
    } else {
        echo "Error al intentar eliminar el producto.";
    }
} else {
    header("Location: index.php");
    exit;
}
?>
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