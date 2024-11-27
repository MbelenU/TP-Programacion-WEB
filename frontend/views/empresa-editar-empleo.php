<?php
require_once __DIR__ . '/../../controllers/EmpresaController.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Editar Empleo', $_SESSION['user']['user_id'])) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}

$empresaController = new EmpresaController();

$idPublicacion = $_GET['id'] ?? null;

if ($idPublicacion) {
    $publicacion = $empresaController->obtenerPublicacion($idPublicacion);
    $publicacion = $publicacion['body'];
} else {
    echo "Error: No se ha proporcionado un ID válido para la publicación.";
    exit;
}

$modalidades = $empresaController->listarModalidades();
$modalidades = $modalidades['body'];
$jornadas = $empresaController->listarJornadas();
$jornadas = $jornadas['body'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/global.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/empresa.css">
</head>

<body class="bg-inicio">
    <?php if ($_SESSION['user']['user_type'] == 1) {
        require __DIR__ . '/../components/admin-navbar.php';
    } elseif ($_SESSION['user']['user_type'] == 3) {
        require __DIR__ . '/../components/empresa-navbar.php';
    }
    ?>
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
            <form class="row g-3" id="publicarForm">
                <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" value="<?php echo htmlspecialchars($publicacion->getTitulo()); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modalidad" class="form-label">Modalidad</label>
                            <select class="form-select" id="modalidad">
                                <option value="" disabled selected>Seleccione una modalidad</option>
                                <?php foreach ($modalidades as $modalidad) : ?>
                                    <?php if ($publicacion->getModalidad()->getId() == $modalidad->getId()): ?>
                                        <option value="<?php echo $publicacion->getModalidad()->getId(); ?>" selected><?php echo $publicacion->getModalidad()->getDescripcionModalidad(); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $modalidad->getId(); ?>"><?php echo $modalidad->getDescripcionModalidad(); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input class="form-control" list="datalistOptions" id="ubicacion" placeholder="Buscar" value="<?php echo htmlspecialchars($publicacion->getUbicacion()); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="jornada" class="form-label">Jornada</label>
                            <select class="form-select" id="jornada">
                                <option value="" disabled selected>Seleccione un tipo de jornada</option>
                                <?php foreach ($jornadas as $jornada) : ?>
                                    <?php if ($publicacion->getJornada()->getId() == $jornada->getId()): ?>
                                        <option value="<?php echo $publicacion->getJornada()->getId(); ?>" selected><?php echo $publicacion->getJornada()->getDescripcionJornada(); ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $jornada->getId(); ?>"><?php echo $jornada->getDescripcionJornada(); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="text-area" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" rows="3"><?php echo htmlspecialchars($publicacion->getDescripcion()); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-success mt-2" data-empleo-id="<?php echo $publicacion->getId() ?>" id='guardarPublicacion'>Guardar</button>
                    <a href="<?php echo BASE_URL ?>views/empresa-visualizar-publicaciones.php">
                        <button type="button" class="btn btn-danger mt-2">Cancelar</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script src="../scripts/empresa/editar-empleo.js"></script>
</body>

</html>
