<?php
// 1. Incluimos los archivos de la lógica
include_once 'clases/Database.php';
include_once 'clases/Producto.php';

// 2. Iniciamos la base de datos y el objeto Producto
$database = new Database();
$db = $database->getConnection();
$producto = new Producto($db);

// 3. Verificamos si el usuario apretó el botón de enviar (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Le asignamos a los atributos de TU clase lo que el usuario escribió
    $producto->nombre = $_POST['nombre'];
    $producto->descripcion = $_POST['descripcion'];
    $producto->precio = $_POST['precio'];
    $producto->stock = $_POST['stock'];

    // 4. Ejecutamos TU método crear()
    if ($producto->crear()) {
        // Si sale bien, lo mandamos de vuelta al index con un aviso de éxito
        header("Location: index.php?status=success");
        exit;
    } else {
        echo "<div class='alert alert-danger'>No se pudo guardar el producto.</div>";
    }
}
?>