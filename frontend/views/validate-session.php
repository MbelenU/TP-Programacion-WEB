<?php
session_start();

function validarSesion($allowedRoles) {
    if (!isset($_SESSION['user_type'])) {
        header("Location: ./inicio.php");
        exit();
    }

    if (!in_array($_SESSION['user_type'], $allowedRoles)) {
        http_response_code(403);
        echo "Acceso denegado. No tienes permisos para acceder a esta página.";
        exit();
    }
}
?>