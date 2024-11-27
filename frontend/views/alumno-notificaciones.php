<?php
require_once '../../controllers/AlumnoController.php';
require_once __DIR__ . '/../utils/paginacion.php';

$alumnoController = new AlumnoController();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['2'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}

$response = $alumnoController->obtenerNotificaciones($_SESSION['user']['user_id']);
$notificaciones = isset($response['body']) ? $response['body'] : [];

$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$paginationData = paginateArray($notificaciones, $itemsPerPage, $currentPage);
$paginatedNotificaciones = $paginationData['items'];
$totalPages = $paginationData['totalPages'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/notificaciones.css">
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="notif-header">
            <div class="notificaciones">
                <div class="nombre-notif">
                    <h1>Notificaciones</h1>
                </div>
            </div>
            <?php if (!empty($paginatedNotificaciones)) : ?>
                <?php foreach ($paginatedNotificaciones as $notif) : ?>
                    <div class="container-notif">
                        <div class="notif-item mb-6">
                            <div class="notif-titulo">
                                <i class="bi bi-bell-fill"></i>
                                <?php echo htmlspecialchars($notif->getDescripcion()); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php else : ?>
                <div class="container-notif">
                    <p>No tienes notificaciones</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
