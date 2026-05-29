<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Librería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        /* Aplicamos la nueva tipografía y estilo al contenedor del usuario */
        .fuente-usuario {
            font-family: 'Poppins', sans-serif;
            font-weight: 600; /* Hace que resalte un poco más */
            font-size: 1.05rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        
        <div class="navbar-brand m-0">
            <a class="text-white text-decoration-none fw-bold" href="index.php">📚 Biblioteca</a>
        </div>

        <div class="text-center flex-grow-1 d-none d-md-block">
            <?php if (isset($_SESSION['usuario_nombre'])): ?>
                <span class="navbar-text text-white fuente-usuario m-0">
                    👤 <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="d-flex align-items-center">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <span class="navbar-text text-white fuente-usuario d-md-none me-3">
                    <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                </span>
                <a class="btn btn-danger btn-sm" href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                
                <?php if (!isset($ocultar_accesos) || $ocultar_accesos !== true): ?>
                    <a class="nav-link text-white me-3" href="login.php">Iniciar Sesión</a>
                    <a class="nav-link text-white" href="registro.php">Registrarse</a>
                <?php endif; ?>

            <?php endif; ?>
        </div>

    </div>
</nav>

<div class="container">