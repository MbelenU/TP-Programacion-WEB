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

$userId = $_SESSION['user'];

function estaSuscripto($eventoId, $userId) {
    global $alumnoController;
    $suscripcion = $alumnoController->verificarSuscripcion($eventoId, $userId);
    return $suscripcion;  // Retorna el objeto Suscripcion si está suscrito, o null si no lo está
}
?> 


<!DOCTYPE html>
<html lang="es">
<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/alumno-eventos.css">
    <script src="<?php echo BASE_URL ?>scripts/alumno/eventos.js" defer></script>
</head>
<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <div class="pb-5">
                <h1>Eventos</h1>
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
                        $suscripcion = estaSuscripto($eventos, $userId); 
                    ?>
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
                                <div class="mt-4 d-flex justify-content-center align-items-center">
                                    <?php if ($suscripcion !== null): ?>
                                        <button class="btn btn-danger">Desuscribirme</button>
                                    <?php else: ?>
                                        <button class="btn btn-success">Suscribirme</button>
                                    <?php endif; ?>
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

