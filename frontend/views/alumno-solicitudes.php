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
    <div class="container p-4 bg-white">
        <div class="row">
            <div class="col">
                <h1>Mis solicitudes</h1>
            </div>
        </div>



        <?php if (!empty($postulaciones)): ?>
           
           <?php foreach ($postulaciones as $postulacion): ?>
             

        <div class="container-solic border border-success-subtle">
            <div class="solic-item">
                <div class="row px-2">
                    <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                        <div class="col">
                            <div class="titulo-solic"><?php echo htmlspecialchars($postulacion->getPuestoOfrecido()); ?></div>
                            <i class="bi bi-geo-alt"><?php echo htmlspecialchars($postulacion->getUbicacion()); ?></i>
                        </div>
                        <div class="estado-empleo"><?php echo htmlspecialchars($postulacion->getEstadoPostulacion()->getEstado()); ?></div>
                        <i class="arrowIcon fas fa-chevron-left "></i>
                    </button>
                </div>
                <div class="solicitud-details d-none">
                    <div>
                        <strong>Descripción:</strong>
                        <p><?php echo htmlspecialchars($postulacion->getDescripcion()); ?></p>
                    </div>
                    <div class="mt-4">
                        <strong>Habilidades Necesarias:</strong>
                        <ul>
                            <?php
                                $habilidades = $postulacion->getHabilidades();  // Ya es un array
                                foreach ($habilidades as $habilidad) {
                                    echo "<li>" . htmlspecialchars($habilidad) . "</li>";
                                }
                            ?>
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
                    <div class="d-flex justify-content-center align-items-center ">
                        <button class="btn btn-outline-danger mt-3 d-flex justify-content-center align-items-center">
                            DAR DE BAJA <i class="bi bi-person-fill-down fs-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <?php endforeach; ?>
        <?php else: ?>
            <p>No hay solicitudes disponibles en este momento.</p>
        <?php endif; ?>
        

    </div>

</body>

</html>