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
          <!-- <form class="filtro d-flex" role="search">
                <input class="form-control me-2" type="search" id="form-control"
                    placeholder="Rubro | Nombre del empleo | Disponibilidad horaria | Ubicación | Modalidad"
                    aria-label="Search">
                <button class="botonFiltro btn btn-light border border-success-subtle" type="submit">Filtrar</button>
            </form>-->
            <form class="filtro d-flex" role="search" method="GET" action="buscar.php">
            <input class="form-control me-2" type="search" name="buscar" id="form-control" placeholder="Buscar">
            <button class="botonFiltro btn btn-light border border-success-subtle" type="submit">Filtrar</button>
            </form>

            <!-- <ul>
             <?php foreach ($buscar as $empleo): ?>
            <li>
                <h2><?php echo $empleo['titulo']; ?></h2>
                <p><?php echo $empleo['descripcion']; ?></p>
                </li>
              <?php endforeach; ?>
            </ul> -->
                    

            
        </div>
        
        <?php foreach ($empleos as $empleo): ?>
            <div class="container-empleo bg-navbar border border-success-subtle">
                <div class="empleo-item mb-6">
                    <div class="row px-2">
                        <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                            <div class="titulo-empleo"><?php echo htmlspecialchars($empleo['titulo']); ?></div>
                            <i class="bi bi-geo-alt"><?php echo htmlspecialchars($empleo['ubicacion']); ?></i>
                            <i class="arrowIcon fas fa-chevron-left "></i>
                        </button>
                    </div>
                    <div class="empleo-details d-none">
                        <div>
                            <strong>Descripción:</strong>
                            <p><?php echo htmlspecialchars($empleo['descripcion']); ?></p>
                        </div>
                        <div class="mt-4">
                            <strong>Habilidades Necesarias:</strong>
                            <ul>
                                <?php foreach ($empleo['habilidades'] as $habilidad): ?>
                                    <li><?php echo htmlspecialchars($habilidad->getNombreHabilidad());?></li>
                                <?php endforeach; ?>
                            </ul>
                            
                        </div>
                        <div class="mt-4">
                            <strong>Disponibilidad Horaria:</strong>
                            <ul>
                                <?php if (isset($empleo['jornada'])): ?>
                                    <li><?php echo htmlspecialchars($empleo['jornada']); ?></li>
                                <?php else: ?>
                                    <li>No disponible</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <strong>Modalidad:</strong>
                            <ul>
                                <?php if (isset($empleo['modalidad'])): ?>
                                    <li><?php echo htmlspecialchars($empleo['modalidad']); ?></li>
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
