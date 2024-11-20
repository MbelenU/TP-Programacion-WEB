<?php
require_once '../../controllers/AlumnoController.php';

$alumnoController = new AlumnoController();
$response = $alumnoController->listarPostulaciones();
$postulaciones = $response['body'];


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
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <div class="pb-5">
                <h1>Mis solicitudes</h1>
            </div>

            <?php if (!empty($postulaciones)): ?>
                <div class="row mb-5 list-group col-12 p-0">
                    <?php foreach ($postulaciones as $postulacion): ?>
                        <div class="list-group-item list-group-item-action bg-white border border-success-subtle">
                            <div class="w-100 justify-content-between">
                                <button class="toggleButton btn border-0 w-100 d-flex flex-column text-start">
                                    <h5 class="mb-1">
                                        <div class="titulo-solic"><?php echo htmlspecialchars($postulacion->getPuestoOfrecido()); ?></div>
                                    </h5>
                                    <small class="mb-1"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($postulacion->getUbicacion()); ?></small>
                                    <div class="mt-4"><?php echo htmlspecialchars($postulacion->getEstadoPostulacion()->getEstado()) ?? null; ?></div>
                                </button>
                            </div>
                            <div class="solicitud-details d-none">
                                <div class="mt-4">
                                    <strong>Descripción:</strong>
                                    <p><?php echo htmlspecialchars($postulacion->getDescripcion()); ?></p>
                                </div>
                                <div class="mt-4">
                                    <strong>Habilidades Necesarias:</strong>
                                    <ul>
                                        <?php foreach ($postulacion->getHabilidades() as $habilidad): ?>
                                            <li><?php echo htmlspecialchars($habilidad); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="mt-4">
                                    <strong>Disponibilidad Horaria:</strong>
                                    <ul>
                                        <li><?php echo htmlspecialchars($postulacion->getJornada()); ?></li>
                                    </ul>
                                </div>
                                <div class="mt-4">
                                    <strong>Modalidad:</strong>
                                    <ul>
                                        <li><?php echo htmlspecialchars($postulacion->getModalidad()); ?></li>
                                    </ul>
                                </div>
                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <button class="btn btn-outline-danger">
                                        Dar de baja <i class="bi bi-person-fill-down fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No hay solicitudes disponibles en este momento.</p>
            <?php endif; ?>

        </div>
    </div>
</body>

</html>