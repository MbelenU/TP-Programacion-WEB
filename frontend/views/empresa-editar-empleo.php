<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Editar Empleo', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
$publicacion = $empresaController->obtenerPublicacion($_GET['id']);
$publicacion = $publicacion['body'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/global.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/empresa.css">
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
                            <input type="text" class="form-control" id="titulo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modalidad" class="form-label">Modalidad</label>
                            <select class="form-select" id="modalidad" required>
                                <option value="" disabled selected>Seleccione una modalidad</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Remoto">Remoto</option>
                                <option value="Hibrido">Hibrido</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ubicación" class="form-label">Ubicación</label>
                            <input class="form-control" list="datalistOptions" id="ubicacion" placeholder="Buscar">
                            <datalist id="datalistOptions">
                                <option value="CABA">
                                <option value="Ezeiza">
                                <option value="Montegrande">
                                <option value="Cañuelas">
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="modalidad" class="form-label">Jornada</label>
                            <select class="form-select" id="jornada" required>
                                <option value="" disabled selected>Seleccione un tipo de jornada</option>
                                <option value="jornada-completa">Jornada completa</option>
                                <option value="media-jornada">Media jornada</option>
                                <option value="practicas">Practicas</option>
                                <option value="voluntario">Voluntario</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="text-area" class="form-label">Descripción</label>
                            <textarea class="form-control" id="text-area" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div>
                        <h2 class="datospersonales-header">Habilidades requeridas</h2>
                        <div id="habilidaderror" class="text-danger"></div>
                        <input class="form-control" list="datalistOptions" id="habilidad" placeholder="Buscar">
                        <datalist id="datalistOptions">
                            <option value="HTML">
                            <option value="CSS">
                            <option value="JavaScript">
                            <option value="Base de Datos">
                        </datalist>
                        <button type="button" class="btn btn-secondary mt-2" id="agregarHabilidad">Agregar
                            Habilidad</button>
                        <ul id="listaHabilidades" class="mb-3"></ul>
                    </div>
                    <div class="row justify-content-between">
                        <h2 class="datospersonales-header">Materias requeridas</h2>
                        <div class="col-md-6">
                            <div id="carreraerror" class="text-danger"></div>
                            <label for="carrera" class="form-label">Carrera</label>
                            <select class="form-select" id="carrera" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                <option value="Desarrollo de Software">Desarrollo de Software</option>
                                <option value="Turismo">Turismo</option>
                                <option value="Comercio Internacional">Comercio Internacional</option>
                                <option value="Gestión Aeroportuaria">Gestión Aeroportuaria</option>
                                <option value="Logistica">Logistica</option>
                                <option value="Higiene y Seguridad">Higiene y Seguridad</option>
                            </select>

                            <label for="planEstudios" class="form-label mt-3 d-none" id="planEstudiosLabel">Plan de
                                Estudios</label>
                            <div id="planerror" class="text-danger"></div>
                            <select class="form-select d-none" id="planEstudios" required>
                                <option value="" disabled selected>Seleccione un plan de estudios</option>
                            </select>

                            <label for="materia" class="form-label mt-3 d-none" id="materiaLabel">Materia</label>
                            <select class="form-select d-none" id="materia">
                                <option value="" disabled selected>Seleccione una materia</option>
                            </select>
                            <button type="button" class="btn btn-secondary mt-2 d-none" id="agregarMateria">Agregar
                                Materia
                                Aprobada</button>
                        </div>
                        <div class="col-md-6">
                            <ul id="materiasAprobadasList" class="mb-3"></ul>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Guardar</button>
                    <a href="<?php echo BASE_URL ?>views/empresa-visualizar-publicaciones.php">
                                <button type="button" class="btn btn-danger mt-2"> Cancelar</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>


</html>