<?php
// 1. Conecta las clases 
include_once 'clases/Database.php';
include_once 'clases/Producto.php';

// 2. Instancia la base de datos y obtiene la conexión activa
$database = new Database();
$db = $database->getConnection(); // O el método que use su Database.php

// 3. La conexion de instructor
$producto = new Producto($db);

// 4. Llama a tu método para traer los registros
$stmt = $producto->listar(); 

?>