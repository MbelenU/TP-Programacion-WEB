<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/notificaciones.css">

</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-secondary-subtle">
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