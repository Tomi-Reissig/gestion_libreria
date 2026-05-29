<?php

    if (session_status() === PHP_SESSION_NONE) { // Si no hay una sesión iniciada se hace lo siguiente
        session_start(); // Se inicia una sesion para poder destruirla
    }

    
    session_unset(); // Se eliminan todas las variables guardadas dentro de $_SESSION
    session_destroy(); // Se destruye completamente la sesión actual del usuario | El ID de sesión deja de ser válido

    
    header("Location: login.php"); // Se envía al usuario automáticamente a la página de login
    exit();
?>