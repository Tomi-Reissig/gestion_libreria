<?php
    // clases/Database.php

    class Database {
        private $host = "localhost"; // Dirección donde está la base de datos
        private $db_name = "gestion_libreria"; // Nombre de la base de datos que se va a usar
        private $username = "root"; // Usuario de MySQL
        private $password = ""; // Contraseña de MySQL
        private $conn; // Variable donde se guardará la conexión

        public function getConnection() {
            $this->conn = null;

            try { // TRY intenta ejecutar el código

                $this->conn = new PDO( // Se crea una nueva conexión usando PDO

                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                    $this->username,
                    $this->password

                );
                
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activa los mensajes de error de SQL

            } catch(PDOException $exception) { // Si ocurre un error en la conexión hace lo siguiente

                echo "Error de conexión: " . $exception->getMessage(); //Muestra el mensaje de error
            }

            return $this->conn; // Devuelve la conexión creada
        }
    }
?>