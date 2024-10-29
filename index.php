<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require __DIR__.'/frontend/components/header.php'; ?>
    <title>Inicio</title>
</head>
<body>
    <?php
        if (!isset($_SESSION['user'])) {
            Header("Location: ./frontend/views/inicio.php");
            exit();
        }
    ?>
</body>
</html>