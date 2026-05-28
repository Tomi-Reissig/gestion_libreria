<?php
// 1. Conectamos las clases
include_once 'clases/Database.php';
include_once 'clases/Producto.php';

// 2. Iniciamos la base de datos y el objeto Producto
$database = new Database();
$db = $database->getConnection();
$producto = new Producto($db);

// 3. Verificamos si el usuario apretó el botón de enviar (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Le asignamos a los atributos de clase 
    $producto->nombre = $_POST['nombre'];
    $producto->descripcion = $_POST['descripcion'];
    $producto->precio = $_POST['precio'];
    $producto->stock = $_POST['stock'];

    if ($producto->crear()) {
        header("Location: index.php?status=success");
        exit;
    } else {
        echo "<div class='alert alert-danger'>No se pudo guardar el producto.</div>";
    }
}
?>