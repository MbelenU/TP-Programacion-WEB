<?php
require_once '../../controllers/AlumnoController.php';

$alumnoController = new AlumnoController();
$response = $alumnoController->listarPostulaciones();
if ($response['success']) {
	$postulaciones = $response['body'];
} else {
	$postulaciones = null;
}
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
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <script src="<?php echo BASE_URL ?>scripts/alumno/solicitudes.js" defer></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/alumno-solicitudes.css">
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="container mt-5">
            <div class="pb-5">
                <h1>Mis solicitudes</h1>
            </div>
            <div id="message-container" class="container mt-3"></div>
            <?php if ($postulaciones): ?>
                <ul class="mb-5 list-group col-12 p-0">
                    <?php foreach ($postulaciones as $postulacion): ?>
                        <li class="p-3 list-group-item list-group-item-action bg-white border" data-solicitud-id="<?php echo htmlspecialchars($postulacion->getId()); ?>">
                            <div class="w-100 justify-content-between">
                                <button class="toggleButton btn border-0 p-0 w-100 d-flex flex-column text-start">
                                    <h5 class="mb-1">
                                        <div class="titulo-solic"><?php echo htmlspecialchars($postulacion->getPuestoOfrecido()); ?></div>
                                    </h5>
                                    <small class="mb-1"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($postulacion->getUbicacion()); ?></small>
                                    <p class="my-4">Estado de la solicitud: <?php echo htmlspecialchars($postulacion->getEstadoPostulacion()->getEstado()) ?? null; ?></p>
                                </button>
                            </div>
                            <div class="solicitud-details d-none">
                                <div>
                                    <strong>Descripción:</strong>
                                    <p><?php echo htmlspecialchars($postulacion->getDescripcion()); ?></p>
                                </div>
                                <div class="mt-4">
                                    <strong>Habilidades Necesarias:</strong>
                                    <?php foreach ($postulacion->getHabilidades() as $habilidad): ?>
                                        <?php echo htmlspecialchars($habilidad); ?>
                                    <?php endforeach; ?>
                                </div>
                                <div class="mt-4">
                                    <strong>Disponibilidad Horaria:</strong>
                                    <?php echo htmlspecialchars($postulacion->getJornada()); ?>
                                </div>
                                <div class="mt-4">
                                    <strong>Modalidad:</strong>
                                    <?php echo htmlspecialchars($postulacion->getModalidad()); ?>
                                </div>
                                <div class="d-flex align-items-center mt-3">
                                    <button class="btn btn-outline-danger"  id="darBaja">
                                        Eliminar solicitud<i class="bi bi-person-fill-down fs-5"></i>
                                    </button>
                                </div>
                            </div>
                            
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No hay solicitudes disponibles en este momento.</p>
            <?php endif; ?>
            <a href="<?php echo BASE_URL ?>views/alumno-empleos.php">
                                <button type="button" class="btn btn-light mt-2"> Volver a Empleos</button>
                            </a>
        </div>
    </div>
    
    <script src="../scripts/alumno/darBaja.js"></script>
</body>

</html>