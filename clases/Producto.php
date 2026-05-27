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
    // Método para crear un nuevo registro (Alta)
    public function crear() {
        // Consulta SQL con marcadores de posición (?) por seguridad
        $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
        
        // Preparamos la consulta
        $stmt = $this->conn->prepare($query);

        // Sanitizamos los datos para evitar inyecciones de código o scripts maliciosos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));

        // Ejecutamos pasando los parámetros en el mismo orden que los '?'
        if ($stmt->execute([$this->nombre, $this->descripcion, $this->precio, $this->stock])) {
            return true; // Si salió bien
        }
        return false; // Si hubo un error
    }
}