<?php
require_once 'includes/verificar_sesion.php';
// Activamos visualización de errores por si hay fallos con la conexión
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'clases/Database.php';

$database = new Database();
$db = $database->getConnection(); 

// Consulta real a tu tabla de MySQL
$sql = "SELECT id, titulo, autor, precio, stock FROM libros ORDER BY id DESC";
$stmt = $db->prepare($sql);
$stmt->execute();

include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📚 Listado de Libros</h2>
    <a href="agregar.php" class="btn btn-primary">
        + Nuevo Libro
    </a>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_GET['mensaje']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Precio</th> <th>Stock</th>  <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Verificamos si la base de datos tiene registros
            if ($stmt->rowCount() > 0): 
                // Recorremos fila por fila los libros guardados en MySQL
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($row['autor']); ?></td>
                    <td>$<?php echo number_format($row['precio'], 2, ',', '.'); ?></td>
                    <td><?php echo $row['stock']; ?> unidades</td>
                    <td class="text-center">
                        <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                            Editar
                        </a>
                        <button 
                            class="btn btn-danger btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalEliminar"
                            onclick="configurarEliminar(<?php echo $row['id']; ?>)">
                            Eliminar
                        </button>
                    </td>
                </tr>
            <?php 
                endwhile; 
            else: 
            ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No hay libros registrados actualmente. Hacé clic en "+ Nuevo Libro" para empezar.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>

<div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                ¿Seguro que deseas eliminar este libro? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btnConfirmarEliminar" class="btn btn-danger">Sí, eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
function configurarEliminar(id) {
    document.getElementById('btnConfirmarEliminar').href = 'eliminar.php?id=' + id;
}
</script>