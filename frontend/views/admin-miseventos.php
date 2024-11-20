<?php

require_once __DIR__ . '/../../controllers/AdministradorController.php';

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

$eventos = $administradorController->getEventosDeAdmin();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-eventos.css">
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="eventos-header">
            <div class="evento d-flex justify-content-between align-items-center">
                <div class="nombre-evento">
                    <h1>Mis Eventos</h1>
                </div>
                <a href="<?php echo BASE_URL ?>views/admin-publicar-evento.php"><button class="btn btn-success">Publicar
                        evento</button></a>
            </div>
            <form class="filtro d-flex mb-sm-3" role="search">
                <input class="form-control me-2" type="search" id="form-control"
                    placeholder="Tipo del evento | Nombre del evento | Fecha | Horario" aria-label="Search">
                <button class="botonFiltro btn btn-light border border-success-subtle " type="submit">Filtrar</button>
            </form>
        </div>

        <div class="container-evento">
            <div class="evento-item mb-6">
                <div class="row mb-5">
                    <div class="list-group col-12 p-0">
                        <?php foreach ($eventos as $evento): ?>
                            <a href="<?php echo BASE_URL ?>views/admin-detalle-evento.php?id=<?php echo $evento->getId(); ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($evento->getNombreEvento()); ?></h5>
                                </div>
                                <div class="mt-4">
                                    <strong>Tipo de evento:</strong>
                                    <div><?php echo htmlspecialchars($evento->getTipoEvento()); ?></div>
                                </div>
                                <div class="mt-4">
                                    <i class="bi bi-calendar3">
                                        <strong> Fecha:</strong> <?php echo htmlspecialchars($evento->getFechaEvento()); ?>
                                    </i>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>