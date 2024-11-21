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

$userId = $_SESSION['user'];

$eventos = $administradorController->getEventosDeAdmin();

?> 


<!DOCTYPE html>
<html lang="es">
<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-eventos.css">
    <script src="<?php echo BASE_URL ?>scripts/admin/eventos.js" defer></script>
    <script src="<?php echo BASE_URL ?>scripts/admin/eventos-admin.js" defer></script>
</head>
<body class="bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="container mt-5">
            <div class="pb-5">
                <h1>Mis Eventos</h1>
            </div>

            <!-- Formulario de búsqueda -->
            <form class="filtro d-flex mb-5" role="search">
                <input class="form-control me-2 border-success-subtle" type="search"
                    id="form-control" placeholder="Carreras | Nombre del evento | Fecha | Ubicación | Modalidad" 
                    aria-label="Search">
                <button class="botonFiltro btn btn-light border border-success-subtle" type="submit">Filtrar</button>
            </form>

            <?php if (!empty($eventos)): ?>
                <div class="row mb-5 list-group col-12 p-0">
                    <?php foreach ($eventos as $evento): 
                    ?>
                        <div class="list-group-item list-group-item-action bg-white border border-success-subtle">
                            <div class="w-100 justify-content-between">
                                <button class="toggleButton btn border-0 w-100 d-flex flex-column text-start">
                                    <h5 class="mb-1">
                                        <div class="evento-titulo"><?php echo htmlspecialchars($evento->getNombreEvento()); ?></div>
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
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No hay eventos disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>