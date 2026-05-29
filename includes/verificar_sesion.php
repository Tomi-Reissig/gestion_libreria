<?php

if (session_status() === PHP_SESSION_NONE) { // Si no hay ninguna sesión iniciada se hace lo siguiente
    session_start(); // Se inicia la sesión
}

if (!isset($_SESSION['usuario_id'])) { // Pregunta si existe un valor del id de usuario dentro del array $_SESSION
    
    header("Location: login.php"); // Si se cumple la condicional se direcciona al usuario
    exit(); 
}
?>