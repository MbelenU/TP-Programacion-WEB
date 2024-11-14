<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['1'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/notificaciones.css">

</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="notif-header">
            <div class="notificaciones">
                <div class="nombre-notif">
                    <h1>Notificaciones</h1>
                </div>
            </div>

        </div>
        <div class="container-notif">
            <div class="notif-titulo">
                <i class="bi bi-bell-fill"></i>
                Un alumno ha solicitado cambio de contraseña
            </div>
        </div>

        <div class="container-notif">
            <div class="notif-titulo">
                <i class="bi bi-bell-fill"></i>
                Una Empresa ha solicitado cambio de contraseña
            </div>
        </div>
    </div>
</body>

</html>