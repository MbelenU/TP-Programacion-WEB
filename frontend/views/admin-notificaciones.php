<?php
require_once __DIR__ . '/../../controllers/AdministradorController.php';
$administradorController = new AdministradorController();

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

$response = $administradorController->obtenerNotificaciones($_SESSION['user']['user_id']);

if (isset($response['body'])) {
    $notificaciones = $response['body']; 
} else {
    $notificaciones = []; 
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
            <?php if (!empty($notificaciones)) : ?>
            <?php foreach ($notificaciones as $notif) : ?>
                <div class="container-notif">
                    <div class="notif-item mb-6">
                        <div class="notif-titulo">
                            <i class="bi bi-bell-fill"></i>
                            <?php echo htmlspecialchars($notif->getDescripcion()); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="container-notif">
                <p>No tienes notificaciones</p>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>