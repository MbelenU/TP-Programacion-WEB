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
$allowedRoles = ['Alumno'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
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
    <div class="container p-sm-4 bg-white">
        <div class="row mb-3">
            <h1>Eventos</h1>
            <form class="filtro d-flex mb-sm-3" role="search">
                <input class="form-control me-2 border-success-subtle" type="search" id="form-control"
                    placeholder="Carreras | Nombre del evento | Fecha | Ubicación | Modalidad" aria-label="Search">
                <button class="botonFiltro btn btn-light border border-success-subtle " type="submit">Filtrar</button>
            </form>
        </div>
        
        <?php if (!empty($eventos)): ?>
           
            <?php foreach ($eventos as $evento): ?>
              
                <div class="container-evento bg-navbar border border-success-subtle">
                    <div class="evento-item mb-6">
                        <div class="row px-2">
                            <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                                <div class="evento-titulo"><?php echo htmlspecialchars($evento['nombreEvento']); ?></div>
                                <i class="arrowIcon fas fa-chevron-left"></i>
                            </button>
                        </div>
                        <div class="evento-details d-none">
                            <div>
                                <i class="bi bi-calendar3"></i>
                                <strong>Fecha:</strong>
                                <ul>
                                    <li><?php echo htmlspecialchars($evento['fechaEvento']); ?></li>
                                  
                                </ul>
                            </div>
                            <div class="mt-4">
                                <p><strong>Descripción:</strong></p>
                                <p><?php echo htmlspecialchars($evento['descripcionEvento']); ?></p>
                            </div>
                            <div class="mt-4">
                                <strong>Modalidad:</strong>
                               <!-- <div><?php echo htmlspecialchars($evento['modalidad']); ?></div>-->
                            </div>
                            <!--<div class="mt-4">
                                <strong>Ubicación:</strong>
                                <div><?php echo htmlspecialchars($evento['ubicacion']); ?></div>
                            </div>-->
                            <div class="mt-4">
                                <strong>Tipo:</strong>
                                <div><?php echo htmlspecialchars($evento['tipoEvento']); ?></div>
                            </div>
                            <div class="mt-4">
                                <strong>Créditos:</strong>
                                <div><?php echo htmlspecialchars($evento['creditosEvento']); ?></div>
                            </div>
                            <div class="vstack gap-0 col-md-5 mx-auto">
                                <button class="btn btn-success mt-3">SUSCRIBIRME</button>
                                <button class="btn btn-danger mt-3">DESUSCRIBIRME</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay eventos disponibles en este momento.</p>
        <?php endif; ?>
        
    </div>
</body>
</html>
