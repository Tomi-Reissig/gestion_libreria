<?php
class Producto {
    // 1. Atributos privados (Encapsulamiento)
    private $conn;
    private $table_name = "productos"; // Nombre de la tabla en la BD

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;

    // 2. Constructor: Se ejecuta automáticamente al instanciar la clase
    public function __construct($db) {
        $this->conn = $db; // Recibe y guarda la conexión PDO
    }
}