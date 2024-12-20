<?php
session_start();
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Publicar Empleo', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 


$modalidades = $empresaController->listarModalidades();
$modalidades = $modalidades['body'];
$jornadas = $empresaController->listarJornadas();
$jornadas = $jornadas['body'];
$carreras = $empresaController->listarCarreras(); 
$carreras = $carreras['body'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/global.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/empresa.css">
</head>

<body class="bg-inicio">
    <?php if ($_SESSION['user']['user_type'] == 1){
            require __DIR__ . '/../components/admin-navbar.php';
    } elseif ($_SESSION['user']['user_type'] == 3){
            require __DIR__ . '/../components/empresa-navbar.php';
    }
    ?>
    <div class="container p-sm-4 bg-white">
        <div class="container mt-5">
            <div class="pb-5">
                <div class="editar-header">
                    <div class="editar">
                        <div class="nombre-editar">
                            <h1>Publicar empleo</h1>
                        </div>
                    </div>
                </div>
            </div>
            <form class="row g-3" id="publicarForm">
                <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo">
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
                            <input class="form-control" list="datalistOptions" id="ubicacion" placeholder="Buscar">
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
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div>
                        <h3 class="datospersonales-header">Habilidades deseadas (opcional)</h3>
                        <div id="habilidaderror" class="text-danger"></div>
                        <input class="form-control" id="habilidad" placeholder="Buscar">
                        <button type="button" class="btn btn-success my-2" id="agregarHabilidad">Agregar
                            Habilidad</button>
                        <ul id="listaHabilidades" class="p-0 mb-3 d-flex gap-2"></ul>
                    </div>
                    <div class="row justify-content-between">
                        <h3 class="datospersonales-header">Materias requeridas (opcional)</h3>
                        <div class="col-md-6">
                            <div id="carreraerror" class="text-danger"></div>
                            <label for="carrera" class="form-label">Carrera</label>
                            <select class="form-select" id="carrera">
                                <option value="" disabled selected>Seleccione una opción</option>
                                <?php foreach ($carreras as $carrera) : ?>
                                    <option value="<?php echo $carrera->getId(); ?>"><?php echo $carrera->getNombreCarrera(); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="planEstudios" class="form-label mt-3 d-none" id="planEstudiosLabel">Plan de Estudios</label>
                            <div id="planerror" class="text-danger"></div>
                            <select class="form-select d-none" id="planEstudios">
                                <option value="" disabled selected>Seleccione un plan de estudios</option>
                            </select>
                            <label for="materia" class="form-label mt-3 d-none" id="materiaLabel">Materia</label>
                            <select class="form-select d-none" id="materia">
                                <option value="" disabled selected>Seleccione una materia</option>
                            </select>
                            <button type="button" class="btn btn-secondary my-2 d-none" id="agregarMateria">Agregar
                                Materia Aprobada</button>
                        </div>
                        <div class="col-md-6 p-0">
                            <ul id="materiasAprobadasList" class="mb-3 p-0"></ul>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3" id='guardarPublicacion'>Guardar</button>
                    <a href="<?php echo BASE_URL ?>views/empresa-visualizar-publicaciones.php">
                                <button type="button" class="btn btn-danger mt-3"> Cancelar</button>
                    </a>
                   
                </div>
            </form>
        </div>
    </div>
    <script src="../scripts/empresa/publicar-empleo.js"></script>
</body>
</html>
