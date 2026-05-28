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
    // Método para listar todos los productos (Listado)
    public function listar() {
        // Consulta SQL para traer todo ordenado por ID descendente
        $query = "SELECT id, nombre, descripcion, precio, stock FROM " . $this->table_name . " ORDER BY id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt; // Retorna el objeto con los resultados
    }
    // Método para actualizar los datos de un producto (Modificación)
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nombre = ?, descripcion = ?, precio = ?, stock = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);

        // Sanitización de seguridad
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Ejecutamos pasando las variables (el ID va al final por el orden del WHERE)
        if ($stmt->execute([$this->nombre, $this->descripcion, $this->precio, $this->stock, $this->id])) {
            return true;
        }
        return false;
    }
    // Método para eliminar un registro (Baja)
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
} // Fin de la clase Producto
?>