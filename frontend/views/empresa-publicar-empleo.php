<?php
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['Empresa'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publicarEmpleo'])){
   $result = $empresaController->publicarEmpleo();
}
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
    <div class="container p-sm-4 bg-secondary-subtle">
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
            <form method="POST" class="row g-3">
                <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modalidad" class="form-label">Modalidad</label>
                            <select class="form-select" id="modalidad" name="modalidad" required>
                                <option value="" disabled selected>Seleccione una modalidad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input class="form-control" list="datalistOptions" id="ubicacion" name="ubicacion" placeholder="Buscar">
                            <datalist id="datalistOptions">
                                <option value="CABA">
                                <option value="Ezeiza">
                                <option value="Montegrande">
                                <option value="Cañuelas">
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="jornada" class="form-label">Jornada</label>
                            <select class="form-select" id="jornada" name="jornada" required>
                                <option value="" disabled selected>Seleccione un tipo de jornada</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div>
                        <h2 class="datospersonales-header">Habilidades requeridas</h2>
                        <div id="habilidaderror" class="text-danger"></div>
                        <input class="form-control" list="datalistOptions" id="habilidad" name="habilidad" placeholder="Buscar">
                        <datalist id="datalistOptions">
                            <option value="HTML">
                            <option value="CSS">
                            <option value="JavaScript">
                            <option value="Base de Datos">
                        </datalist>
                        <button type="button" class="btn btn-secondary my-2" id="agregarHabilidad">Agregar
                            Habilidad</button>
                        <ul id="listaHabilidades" class="p-0 mb-3 d-flex gap-2"></ul>
                    </div>
                    <div class="row justify-content-between">
                        <h2 class="datospersonales-header">Materias requeridas</h2>
                        <div class="col-md-6">
                            <div id="carreraerror" class="text-danger"></div>
                            <label for="carrera" class="form-label">Carrera</label>
                            <select class="form-select" id="carrera" name="carrera" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                            </select>

                            <label for="planEstudios" class="form-label mt-3 d-none" id="planEstudiosLabel">Plan de Estudios</label>
                            <div id="planerror" class="text-danger"></div>
                            <select class="form-select d-none" id="planEstudios" name="plan_estudios" required>
                                <option value="" disabled selected>Seleccione un plan de estudios</option>
                            </select>

                            <label for="materia" class="form-label mt-3 d-none" id="materiaLabel">Materia</label>
                            <select class="form-select d-none" id="materia" name="materia">
                                <option value="" disabled selected>Seleccione una materia</option>
                            </select>
                            <button type="button" class="btn btn-secondary my-2 d-none" id="agregarMateria">Agregar
                                Materia Aprobada</button>
                        </div>
                        <div class="col-md-6 p-0">
                            <ul id="materiasAprobadasList" class="mb-3 p-0"></ul>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary mt-2" name="publicar_empleo">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../scripts/empresa/publicar-empleo.js"></script>
</body>
</html>
