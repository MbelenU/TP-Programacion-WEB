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

    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <div class="pb-5">
                <h1>Empleos</h1>
            </div>

            <!-- Formulario de búsqueda -->
            <form class="filtro d-flex mb-5" role="search" method="GET" action="buscar.php">
                <input class="form-control me-2" type="search" name="buscar" id="form-control" placeholder="Buscar">
                <button class="botonFiltro btn btn-light border border-success-subtle" type="submit">Filtrar</button>
            </form>

            <div class="row mb-5 list-group col-12 p-0">
                <?php foreach ($empleos as $empleo): 
                
                ?>
                    <div class="list-group-item list-group-item-action bg-white border border-success-subtle">
                        <div class="w-100 justify-content-between">
                        <button class="toggleButton btn border-0 w-100 d-flex flex-column text-start">
                        <h5 class="mb-1"><div class="titulo-empleo"><?php echo htmlspecialchars($empleo->getTitulo()); ?></div></h5>
                            <p class="mb-1"><?php echo htmlspecialchars($empleo->getDescripcion()); ?></p>
                            <small><?php echo htmlspecialchars($empleo->getUbicacion()); ?></small>
                            <div class="mt-4">   
                                    <?php echo htmlspecialchars($empleo->getEstadoEmpleo()->getEstado()); ?>
                                
                            </div>
                        </button>
                        </div>
                        <div class="empleo-details d-none">
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
                            </div>
                        <div class="mt-2">
                            <div class="d-flex align-items-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Acciones de empleo">
                                    <button type="button" class="btn btn-success btn-sm">Aplicar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>

</html>
