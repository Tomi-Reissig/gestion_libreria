<?php

class Usuario {
    private $conn; // Variable donde se guardará la conexión a la base de datos
    private $table_name = "usuarios"; // Nombre de la tabla de MySQL que contiene los usuarios

    
    public function __construct($db) { // Recibe la conexión a la base de datos

        $this->conn = $db; // Guarda la conexión en la variable $conn
    }

    // MÉTODO PARA REGISTRAR NUEVOS USUARIOS

    public function registrar($nombre, $email, $password) {

        try { // verifica si el email ya existe para no duplicarlo
            
            $query_check = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1"; // Crea la consulta sql
            $stmt_check = $this->conn->prepare($query_check); // Prepara la consulta para que ingresen datos
            $stmt_check->bindParam(":email", $email); // Reemplaza ":email" por el valor real del email
            $stmt_check->execute(); // Ejecuta la consulta

            if ($stmt_check->rowCount() > 0) { // Si encontró un usuario con ese email hace lo siguiente
                return "El correo electrónico ya está registrado.";
            }

            // INSERTAR NUEVO USUARIO

            $query = "INSERT INTO " . $this->table_name . " (nombre, email, password) VALUES (:nombre, :email, :password)"; // Consulta para guardar el usuario 
            $stmt = $this->conn->prepare($query); // Prepara la consulta

            // LIMPIAR DATOS POR SEGURIDAD

            // Elimina etiquetas peligrosas o código malicioso
            $nombre = htmlspecialchars(strip_tags($nombre));
            $email = htmlspecialchars(strip_tags($email));

            // ENCRIPTAR CONTRASEÑA
            $password_encriptada = password_hash($password, PASSWORD_DEFAULT); // Convierte la contraseña en un hash (texto codificado) seguro

            // UNIR DATOS A LA CONSULTA

            // Se reemplazan los valores por datos reales.
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password_encriptada);


            // EJECUTAR CONSULTA

            if ($stmt->execute()) { // Si se ejecuta correctamente la consulta se hace lo siguiente
                return true; // Registro exitoso
            } else{
                return "Hubo un error al procesar el registro.";
            }

        } catch (PDOException $e) { // Se capturan errores graves de PDO
            return "Error: " . $e->getMessage(); // Se guarda el mensaje del error
        }
    }


    // Método para INICIAR SESIÓN 
    public function login($email, $password) {
        try {

            $query = "SELECT id, nombre, password FROM " . $this->table_name . " WHERE email = :email LIMIT 1"; // Se crea la consulta
            
            $stmt = $this->conn->prepare($query); // Prepara la consulta
            
            $email = htmlspecialchars(strip_tags($email)); // Elimina etiquetas peligrosas o código malicioso del mail por seguridad
            
            $stmt->bindParam(":email", $email); // Reemplazar ":email" por su valor real
            $stmt->execute(); // Ejecuta la consulta


            // SI EL USUARIO EXISTE
            if ($stmt->rowCount() == 1) { 
                $row = $stmt->fetch(PDO::FETCH_ASSOC); //Obtiene los datos del usuario
                
                // VERIFICAR CONTRASEÑA
                if (password_verify($password, $row['password'])) { // Compara la contraseña ingresada con la contraseña encriptada guardada
                    

                    // INICIAR SESIÓN
                    // Si no hay sesión iniciada
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start(); //Inicia una sesión
                    }
                    
                    $_SESSION['usuario_id'] = $row['id']; // Guarda el ID del usuario en la sesión
                    $_SESSION['usuario_nombre'] = $row['nombre']; // Guarda el nombre del usuario en la sesión
                    
                    return true; // Credenciales válidas
                }
            }
            return false; // Credenciales incorrectas

        } catch (PDOException $e) { // Si hay algun error
            return false;
        }
    }
}
?>