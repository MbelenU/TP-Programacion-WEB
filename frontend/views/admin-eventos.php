<?php
require_once __DIR__ . '/../../controllers/AdministradorController.php';
require_once __DIR__ . '/../utils/paginacion.php';

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

$userId = $_SESSION['user'];
$administradorController = new AdministradorController();

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

$eventos = $administradorController->getEventos();
if ($searchQuery !== '') {
    $eventos = array_filter($eventos, function ($evento) use ($searchQuery) {
        return stripos($evento->getNombreEvento(), $searchQuery) !== false;
    });
}

$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$paginationData = paginateArray($eventos, $itemsPerPage, $currentPage);
$paginatedEventos = $paginationData['items'];
$totalPages = $paginationData['totalPages'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-eventos.css">
    <script src="<?php echo BASE_URL ?>scripts/admin/eventos.js" defer></script>
    <script src="<?php echo BASE_URL ?>scripts/admin/eventos-admin.js" defer></script>
    <script src="<?php echo BASE_URL ?>scripts/admin/pagination.js" defer></script>
    <script src="../scripts/alumno/buscarEvento.js" defer></script>
    <script src="../scripts/admin/borrarEventos.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="container mt-5">
            <div class="evento mb-5 d-flex justify-content-between align-items-center">
                <div class="nombre-evento">
                    <h1>Eventos</h1>
                </div>
                <a href="<?php echo BASE_URL ?>views/admin-publicar-evento.php"><button class="btn btn-success">Publicar evento</button></a>
            </div>

            <!-- Formulario de búsqueda -->
            <form class="filtro d-flex mb-4" role="search" method="get">
                <input
                    class="form-control me-2 border-success-subtle"
                    type="search"
                    name="search"
                    id="form-control"
                    placeholder="Buscar eventos"
                    value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button
                    class="botonFiltro btn btn-light border border-success-subtle me-2"
                    type="submit">
                    Filtrar
                </button>
                <!-- Botón para limpiar el filtro -->
                <a href="?" class="btn btn-secondary">Limpiar</a>
            </form>


            <?php if (!empty($paginatedEventos)): ?>
                <div class="mb-5 list-group col-12 p-0">
                    <?php foreach ($paginatedEventos as $evento): ?>
                        <div class="list-group-item list-group-item-action bg-white border border-success-subtle">
                            <div class="w-100 justify-content-between">
                                <button class="toggleButton btn border-0 w-100 d-flex flex-column text-start">
                                    <h5 class="mb-1 evento-titulo text-decoration-none">
                                        <a href="<?php echo BASE_URL . 'views/admin-detalle-evento.php?id=' . $evento->getId(); ?>" class="text-decoration-none"><?php echo htmlspecialchars($evento->getNombreEvento()); ?></a>
                                    </h5>
                                    <small class="mb-1"><i class="bi bi-calendar3"></i> <?php echo htmlspecialchars($evento->getFechaEvento()); ?></small>
                                    <div class="mt-4"><?php echo htmlspecialchars($evento->getTipoEvento()); ?></div>
                                </button>
                            </div>
                            <div class="evento-details d-none">
                                <div class="mt-4">
                                    <p><strong>Descripción:</strong></p>
                                    <p><?php echo htmlspecialchars($evento->getDescripcionEvento()); ?></p>
                                </div>
                                <div class="mt-4">
                                    <strong>Créditos:</strong>
                                    <div><?php echo htmlspecialchars($evento->getCreditos()); ?></div>
                                </div>
                            </div>
                            <a href="<?php echo BASE_URL . 'views/admin-editar-evento.php?id=' . $evento->getId(); ?>" class="btn btn-light mt-2 mb-3">Editar evento</a>
                                                                                   
                            <button type="button" class="btn btn-outline-danger mt-2 mb-3" title="Eliminar evento" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $evento->getId(); ?>" data-evento-id="<?php echo $evento->getId(); ?>">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>

                        </div>

                        <!-- Modal de Confirmación de Eliminación -->
                        <div class="modal fade" id="modalEliminar<?php echo $evento->getId(); ?>" tabindex="-1" aria-labelledby="modalEliminarLabel<?php echo $evento->getId(); ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEliminarLabel<?php echo $evento->getId(); ?>">Confirmación de eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar este evento?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" data-borrar-id="<?php echo $evento->getId(); ?>" data-borrar-nombre="<?php echo $evento->getNombreEvento(); ?>">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i === $currentPage ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchQuery); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php else: ?>
                <p>No hay eventos disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>