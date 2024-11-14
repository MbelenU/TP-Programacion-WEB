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
    <?php require __DIR__ . '/../components/header.php'?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-eventos.css">
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="eventos-header">
            <div class="evento d-flex justify-content-between align-items-center">
                <div class="nombre-evento">
                    <h1>Eventos</h1>
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
                        <a href="<?php echo BASE_URL ?>views/admin-detalle-evento.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Explorando la Deep Web: entre mitos y realidades</h5>
                            </div>
                            <div class="mt-4">
                                <strong>Tipo de evento:</strong>
                                <div>Capacitación</div>
                            </div>
                            <div class="mt-4">
                                <i class="bi bi-calendar3"><strong> Fecha:</strong> 19/09/2024 19 hs. </i>
                            </div>
                        </a>
                        <a href="<?php echo BASE_URL ?>views/admin-detalle-evento.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Tutorías - Desarrollo de Software</h5>
                            </div>
                            <div class="mt-4">
                                <strong>Tipo de evento:</strong>
                                <div>Tutoría</div>
                            </div>
                            <div class="mt-4">
                                <i class="bi bi-calendar3"><strong> Fecha:</strong> 23/10/2024 18 hs. </i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>