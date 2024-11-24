<?php
require_once '../../controllers/AlumnoController.php';



$alumnoController = new AlumnoController();
$response = $alumnoController->listarEventos();
$eventos = $response['body'];

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

$userId = $_SESSION['user']['user_id'];
$response = $alumnoController->listarSuscripciones($userId);
$suscripciones = $response['body'];

function filtrarEventosNoSuscritos($eventos, $suscripciones) {

    $idsEventosSuscritos = array_map(function($suscripcion) {
        return $suscripcion['id'];
    }, $suscripciones);

    $eventosNoSuscritos = array_filter($eventos, function($evento) use ($idsEventosSuscritos) {
        return !in_array($evento['idEvento'], $idsEventosSuscritos);
    });

    return $eventosNoSuscritos;
}
$eventosNoSuscritos = filtrarEventosNoSuscritos($eventos, $suscripciones);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <script src="<?php echo BASE_URL ?>scripts/alumno/eventos.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="container mt-5">
            <div class="pb-5">
                <h1>Eventos</h1>
            </div>

            <form class="filtro d-flex mb-5" role="search">
                <input class="form-control me-2 border-success-subtle" type="search"
                    id="form-control" placeholder="Carreras | Nombre del evento | Fecha | Ubicación | Modalidad"
                    aria-label="Search">
                <button class="botonFiltro btn btn-light border border-success-subtle" type="submit">Filtrar</button>
            </form>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item " role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Nuevos Eventos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Suscripciones</button>
                </li>
            </ul>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <?php if (!empty($eventosNoSuscritos)): ?>
                        <div class="row mb-5 list-group col-12 p-0">
                            <?php foreach ($eventosNoSuscritos as $evento) : ?>
                                <div class="list-group-item list-group-item-action bg-white border border-success-subtle">
                                    <div class="w-100 justify-content-between">
                                        <button class="toggleButton btn border-0 w-100 d-flex flex-column text-start">
                                            <h5 class="mb-1">
                                                <div class="evento-titulo"><?php echo htmlspecialchars($evento['nombreEvento']); ?></div>
                                            </h5>
                                            <small class="mb-1"><i class="bi bi-calendar3"></i> <?php echo htmlspecialchars($evento['fechaEvento']); ?></small>
                                            <div class="mt-4"><?php echo htmlspecialchars($evento['tipoEvento']); ?></div>
                                        </button>
                                    </div>
                                    <div class="evento-details d-none">
                                        <div class="mt-4">
                                            <p><strong>Descripción:</strong></p>
                                            <p><?php echo htmlspecialchars($evento['descripcionEvento']); ?></p>
                                        </div>
                                        <div class="mt-4">
                                            <strong>Créditos:</strong>
                                            <div><?php echo htmlspecialchars($evento['creditosEvento']); ?></div>
                                        </div>
                                        <div class="row mt-4 d-flex align-items-center">
                                            <button class="btn btn-success">
                                                <i class="bi bi-bell"></i> Suscribirme
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="pt-3 text-center ">
                            <h5 class="d-grid justify-content-center align-items-center "> <i class="bi bi-emoji-frown fs-1"></i> "Actualmente no hay evento disponibles."</h5>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <?php if (!empty($suscripciones)): ?>
                        <div class="row mb-5 list-group col-12 p-0">
                            <?php foreach ($suscripciones as $evento) :
                            ?>
                                <div class="list-group-item list-group-item-action bg-white border border-success-subtle">
                                    <div class="w-100 justify-content-between">
                                        <button class="toggleButton btn border-0 w-100 d-flex flex-column text-start">
                                            <h5 class="mb-1">
                                                <div class="evento-titulo"><?php echo htmlspecialchars($evento['nombre']); ?></div>
                                            </h5>
                                            <small class="mb-1"><i class="bi bi-calendar3"></i> <?php echo htmlspecialchars($evento['fecha']); ?></small>
                                            <div class="mt-4"><?php echo htmlspecialchars($evento['tipo']); ?></div>
                                        </button>
                                    </div>
                                    <div class="evento-details d-none">
                                        <div class="mt-4">
                                            <p><strong>Descripción:</strong></p>
                                            <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                                        </div>
                                        <div class="mt-4">
                                            <strong>Créditos:</strong>
                                            <div><?php echo htmlspecialchars($evento['creditos']); ?></div>
                                        </div>
                                        <div class="row mt-4 d-flex align-items-center">
                                            <button class="btn btn-danger">
                                                <i class="bi bi-bell"></i> Desuscribirme
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="pt-3 text-center ">
                            <h5 class="d-grid justify-content-center align-items-center "> <i class="bi bi-emoji-frown fs-1"></i> "Actualmente no estás suscrito a ningún evento."</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
</body>

</html>