<?php
require_once '../../controllers/AlumnoController.php';

$alumnoController = new AlumnoController();
$response = $alumnoController->listarEmpleos();
$empleos = $response['body'];
$response_buscar = $alumnoController->buscarEmpleos();
$buscar = $response_buscar['body'];

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
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/alumno-empleos.css">
    <script src="<?php echo BASE_URL ?>scripts/alumno/empleos.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="row mb-3">
            <h1>Empleos</h1>
            <!-- Formulario de búsqueda -->
            <form class="filtro d-flex" role="search" method="GET" action="buscar.php">
                <input class="form-control me-2" type="search" name="buscar" id="form-control" placeholder="Buscar">
                <button class="botonFiltro btn btn-light border border-success-subtle" type="submit">Filtrar</button>
            </form>
        </div>
        
        <?php foreach ($empleos as $empleo): ?>
            <div class="container-empleo bg-navbar border border-success-subtle">
                <div class="empleo-item mb-6">
                    <div class="row px-2">
                        <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                            <div class="titulo-empleo"><?php echo htmlspecialchars($empleo->getTitulo()); ?></div>
                            <i class="bi bi-geo-alt"><?php echo htmlspecialchars($empleo->getUbicacion()); ?></i>
                            <i class="arrowIcon fas fa-chevron-left "></i>
                        </button>
                    </div>
                    <div class="empleo-details d-none">
                        <div>
                            <strong>Descripción:</strong>
                            <p><?php echo htmlspecialchars($empleo->getDescripcion()); ?></p>
                        </div>
                        <div class="mt-4">
                            <strong>Habilidades Necesarias:</strong>
                            <ul>
                                <?php foreach ($empleo->getHabilidades() as $habilidad): ?>
                                    <li><?php echo htmlspecialchars($habilidad->getNombreHabilidad()); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <strong>Disponibilidad Horaria:</strong>
                            <ul>
                                <?php if ($empleo->getJornada()): ?>
                                    <li><?php echo htmlspecialchars($empleo->getJornada()->getDescripcionJornada()); ?></li>
                                <?php else: ?>
                                    <li>No disponible</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <strong>Modalidad:</strong>
                            <ul>
                                <?php if ($empleo->getModalidad()): ?>
                                    <li><?php echo htmlspecialchars($empleo->getModalidad()->getDescripcionModalidad()); ?></li>
                                <?php else: ?>
                                    <li>No disponible</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="vstack col-md-5 mx-auto">
                            <button class="btn btn-light mt-3 border border-success-subtle">Enviar Solicitud</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
    </div>
</body>

</html>