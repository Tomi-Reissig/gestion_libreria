<?php
class Producto {
    // 1. Atributos de conexión y tabla
    private $conn;
    private $table_name = "libros"; // Nombre de la tabla de base de datos

    // Propiedades adaptadas a la estructura de la base de datos
    public $id;
    public $titulo;
    public $autor;
    public $precio;
    public $stock;

    // 2. Constructor: Recibe y guarda la conexión PDO
    public function __construct($db) {
        $this->conn = $db; 
    }

    // Método para crear un nuevo registro (Alta)
    public function crear() {
        // Consulta SQL adaptada con 'titulo' y 'autor'
        $query = "INSERT INTO " . $this->table_name . " (titulo, autor, precio, stock) VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);

        // Sanitizamos los datos para evitar inyecciones de código
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));

        // Ejecutamos pasando los parámetros en el orden correspondiente
        if ($stmt->execute([$this->titulo, $this->autor, $this->precio, $this->stock])) {
            return true; 
        }
        return false; 
    }

    // Método para listar todos los libros (Listado)
    public function listar() {
        // Consulta SQL adaptada con 'titulo' y 'autor' ordenados por ID descendente
        $query = "SELECT id, titulo, autor, precio, stock FROM " . $this->table_name . " ORDER BY id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt; // Retorna el objeto con los resultados
    }

    // Método para actualizar los datos de un libro (Modificación)
    public function actualizar() {
        // Consulta SQL adaptada con 'titulo' y 'autor'
        $query = "UPDATE " . $this->table_name . " 
                  SET titulo = ?, autor = ?, precio = ?, stock = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);

        // Sanitización de seguridad
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->autor = htmlspecialchars(strip_tags($this->autor));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Ejecutamos pasando las variables (el ID va al final por el orden del WHERE)
        if ($stmt->execute([$this->titulo, $this->autor, $this->precio, $this->stock, $this->id])) {
            return true;
        }
        return false;
    }

    // Método para eliminar un registro
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);

        // Sanitizamos el ID
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Ejecutamos pasando solo el ID
        if ($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
} 
?>