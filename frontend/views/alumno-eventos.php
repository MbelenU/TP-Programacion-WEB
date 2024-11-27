<?php
require_once '../../controllers/AlumnoController.php';
require_once __DIR__ . '/../utils/paginacion.php';

$alumnoController = new AlumnoController();
$responseEventos = $alumnoController->listarEventos();
$eventos = isset($responseEventos['body']) && is_array($responseEventos['body']) ? $responseEventos['body'] : [];

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
$responseSuscripciones = $alumnoController->listarSuscripciones($userId);
$suscripciones = isset($responseSuscripciones['body']) && is_array($responseSuscripciones['body']) ? $responseSuscripciones['body'] : [];

if (isset($_GET['tab'])) {
    $_SESSION['currentTab'] = $_GET['tab'];
} else {
    $_SESSION['currentTab'] = $_SESSION['currentTab'] ?? 'events';
}

function filtrarEventosNoSuscritos($eventos, $suscripciones) {
    if (empty($suscripciones)) {
        return $eventos;
    }

    $idsEventosSuscritos = array_map(function($suscripcion) {
        return $suscripcion['id'];
    }, $suscripciones);

    $eventosNoSuscritos = array_filter($eventos, function($evento) use ($idsEventosSuscritos) {
        return !in_array($evento['idEvento'], $idsEventosSuscritos);
    });

    return $eventosNoSuscritos;
}

$eventosNoSuscritos = filtrarEventosNoSuscritos($eventos, $suscripciones);

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($searchQuery !== '') {

    if($_SESSION['currentTab'] === 'events'){
        $eventosNoSuscritos = array_filter($eventosNoSuscritos, function ($evento) use ($searchQuery) {
            return stripos($evento['nombreEvento'], $searchQuery) !== false;
        });
    }else{
        $eventosNoSuscritos = array_filter($eventosNoSuscritos, function ($evento) use ($searchQuery) {
        return stripos($evento['nombreEvento'], $searchQuery) !== false;
    });
}

    $suscripciones = array_filter($suscripciones, function ($suscripcion) use ($searchQuery) {
        return stripos($suscripcion['nombre'], $searchQuery) !== false;
    });
}

$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$paginationData = paginateArray($eventosNoSuscritos, $itemsPerPage, $currentPage);
$paginatedEventosNoSuscritos = $paginationData['items'];
$totalPagesEventosNoSuscritos = $paginationData['totalPages'];

$paginatedSuscripciones = [];
$totalPagesSuscripciones = 0;

if (!empty($suscripciones)) {
    $paginationSuscripcionesData = paginateArray($suscripciones, $itemsPerPage, $currentPage);
    $paginatedSuscripciones = $paginationSuscripcionesData['items'];
    $totalPagesSuscripciones = $paginationSuscripcionesData['totalPages'];
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <script src="<?php echo BASE_URL ?>scripts/alumno/eventos.js" defer></script>
    <script src="<?php echo BASE_URL ?>scripts/alumno/borrarSuscripcion.js" defer></script>
    <script src="<?php echo BASE_URL ?>scripts/alumno/agregarSuscripcion.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="container mt-5">
            <div class="pb-5">
                <h1>Eventos</h1>
            </div>
            <form class="filtro d-flex mb-5" role="search" method="get">
                <input class="form-control me-2 border-success-subtle" type="search"
                    name="search" id="form-control" placeholder="Carreras | Nombre del evento | Fecha | Ubicación | Modalidad"
                    aria-label="Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button class="botonFiltro btn btn-light border border-success-subtle" type="submit">Filtrar</button>
            </form>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item " role="presentation">
                       <a class="nav-link <?php echo $_SESSION['currentTab'] === 'events' ? 'active' : ''; ?>" 
                       href="?tab=events">
                       Nuevos Eventos
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php echo $_SESSION['currentTab'] === 'subscriptions' ? 'active' : ''; ?>" 
                       href="?tab=subscriptions">
                        Suscripciones
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show <?php echo $_SESSION['currentTab'] === 'events' ? 'active' : ''; ?>" 
                     id="home-tab-pane" 
                     role="tabpanel" 
                     aria-labelledby="home-tab" 
                     tabindex="0">
                    <?php if (!empty($paginatedEventosNoSuscritos)): ?>
                        <div class="mb-5 list-group col-12 p-0">
                            <?php foreach ($paginatedEventosNoSuscritos as $evento) : ?>
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
                                            <button class="btn btn-success" data-suscribir-usuario="<?php echo $userId; ?>" data-suscribir-id="<?php echo htmlspecialchars($evento['idEvento']); ?>">
                                                <i class="bi bi-bell"></i> Suscribirme
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalPagesEventosNoSuscritos; $i++): ?>
                                    <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchQuery); ?>&tab=events">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php else: ?>
                        <div class="pt-3 text-center ">
                            <h5 class="d-grid justify-content-center align-items-center "> <i class="bi bi-emoji-frown fs-1"></i> "Actualmente no hay evento disponibles."</h5>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="tab-pane fade <?php echo $_SESSION['currentTab'] === 'subscriptions' ? 'show active' : ''; ?>" 
                     id="profile-tab-pane" 
                     role="tabpanel" 
                     aria-labelledby="profile-tab" 
                     tabindex="0">
                    <?php if (!empty($paginatedSuscripciones)): ?>
                        <div class="mb-5 list-group col-12 p-0">
                            <?php foreach ($paginatedSuscripciones as $suscripcion) : ?>
                                <div class="list-group-item list-group-item-action bg-white border border-success-subtle">
                                    <div class="w-100 justify-content-between">
                                        <button class="toggleButton btn border-0 w-100 d-flex flex-column text-start">
                                            <h5 class="mb-1">
                                                <div class="evento-titulo"><?php echo htmlspecialchars($suscripcion['nombre']); ?></div>
                                            </h5>
                                            <small class="mb-1"><i class="bi bi-calendar3"></i> <?php echo htmlspecialchars($suscripcion['fecha']); ?></small>
                                            <div class="mt-4"><?php echo htmlspecialchars($suscripcion['tipo']); ?></div>
                                        </button>
                                    </div>
                                    <div class="evento-details d-none">
                                        <div class="mt-4">
                                            <p><strong>Descripción:</strong></p>
                                            <p><?php echo htmlspecialchars($suscripcion['descripcion']); ?></p>
                                        </div>
                                        <div class="row mt-4 d-flex align-items-center">
                                        <button class="btn btn-danger" data-desuscribir-id="<?php echo $suscripcion['id']; ?>">
                                            <i class="bi bi-bell"></i> Desuscribirme
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalPagesSuscripciones; $i++): ?>
                                    <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchQuery); ?>&tab=subscriptions">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php else: ?>
                        <div class="pt-3 text-center ">
                            <h5 class="d-grid justify-content-center align-items-center "> <i class="bi bi-emoji-frown fs-1"></i> "Actualmente no estás suscripto a ningún evento."</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
