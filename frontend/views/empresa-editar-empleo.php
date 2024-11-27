<?php
require_once __DIR__ . '/../../controllers/EmpresaController.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['3'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}

$empresaController = new EmpresaDAO();

// Verifica si se recibe un ID de publicación
$idPublicacion = $_GET['id'] ?? null;

if ($idPublicacion) {
    $publicacion = $empresaController->obtenerPublicacion($idPublicacion);
} else {
    // Manejo del caso donde no se proporciona un ID
    echo "Error: No se ha proporcionado un ID válido para la publicación.";
    exit;
}
$titulo = $publicacion->getTitulo();
$descripcion = $publicacion->getDescripcion();
$modalidades = $empresaController->listarModalidades($getDescripcionModalidad);
$jornadas = $empresaController->listarJornadas($getDescripcionJornada);

$ubicacion = $publicacion->getUbicacion();
$habilidades = $publicacion->getHabilidades(); // Array de objetos Habilidad
//$materiasRequeridas = $publicacion->getMateriasRequeridas(); // Array de materias
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/global.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/empresa.css">
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/empresa-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="container mt-5">
            <div class="pb-5">
                <div class="editar-header">
                    <div class="editar">
                        <div class="nombre-editar">
                            <h1>Editar publicación</h1>
                        </div>
                    </div>
                </div>
            </div>
            <form class="row g-3">
                <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" value="<?php echo htmlspecialchars($titulo); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modalidad" class="form-label">Modalidad</label>
                            <select class="form-select" id="modalidad">
                                <option value="" disabled selected>Seleccione una modalidad</option>
                                <?php foreach ($modalidades as $modalidad) : ?>
                                    <option value="<?php echo $modalidad->getId(); ?>"><?php echo $modalidad->getDescripcionModalidad(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input class="form-control" list="datalistOptions" id="ubicacion" placeholder="Buscar" value="<?php echo htmlspecialchars($ubicacion); ?>">

                        </div>
                        <div class="col-md-6">
                            <label for="jornada" class="form-label">Jornada</label>
                            <select class="form-select" id="jornada">
                                <option value="" disabled selected>Seleccione un tipo de jornada</option>
                                <?php foreach ($jornadas as $jornada) : ?>
                                    <option value="<?php echo $jornada->getId(); ?>"><?php echo $jornada->getDescripcionJornada(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="text-area" class="form-label">Descripción</label>
                            <textarea class="form-control" id="text-area" rows="3"><?php echo htmlspecialchars($descripcion); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div>
                        <h2 class="datospersonales-header">Habilidades requeridas</h2>
                        <div id="habilidaderror" class="text-danger"></div>
                        <input class="form-control" list="datalistOptions" id="habilidad" placeholder="Buscar">
                        
                        <button type="button" class="btn btn-secondary mt-2" id="agregarHabilidad">Agregar
                            Habilidad</button>
                       
                            <?php foreach ($habilidades as $habilidad): ?>
                                <li><?php echo htmlspecialchars($habilidad->getDescripcion()); ?></li> <!-- Suponiendo que Habilidad tiene un método getDescripcion() -->
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="row justify-content-between">
                        <h2 class="datospersonales-header">Materias requeridas</h2>
                        <div class="col-md-6">
                            <div id="carreraerror" class="text-danger"></div>
                            <label for="carrera" class="form-label">Carrera</label>
                            <select class="form-select" id="carrera" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="Desarrollo de Software" <?php echo (in_array('Desarrollo de Software', $materiasRequeridas)) ? 'selected' : ''; ?>>Desarrollo de Software</option>
                                <option value="Turismo" <?php echo (in_array('Turismo', $materiasRequeridas)) ? 'selected' : ''; ?>>Turismo</option>
                                <option value="Comercio Internacional" <?php echo (in_array('Comercio Internacional', $materiasRequeridas)) ? 'selected' : ''; ?>>Comercio Internacional</option>
                                <option value="Gestión Aeroportuaria" <?php echo (in_array('Gestión Aeroportuaria', $materiasRequeridas)) ? 'selected' : ''; ?>>Gestión Aeroportuaria</option>
                                <option value="Logistica" <?php echo (in_array('Logistica', $materiasRequeridas)) ? 'selected' : ''; ?>>Logistica</option>
                                <option value="Higiene y Seguridad" <?php echo (in_array('Higiene y Seguridad', $materiasRequeridas)) ? 'selected' : ''; ?>>Higiene y Seguridad</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <ul id="materiasAprobadasList" class="mb-3">
                                <?php foreach ($materiasRequeridas as $materia): ?>
                                    <li><?php echo htmlspecialchars($materia); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Guardar</button>
                    <a href="<?php echo BASE_URL ?>views/empresa-visualizar-publicaciones.php">
                        <button type="button" class="btn btn-danger mt-2">Cancelar</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>