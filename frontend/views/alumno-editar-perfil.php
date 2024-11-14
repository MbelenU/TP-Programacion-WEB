<?php
require_once __DIR__ . '/../../controllers/AlumnoController.php';
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarPerfil'])) {

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $alumnoController->editarPerfilAlumno($_SESSION['user']['user_id']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php'; ?>
    <script src="<?php echo BASE_URL ?>scripts/alumno/editar-perfil.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php'; ?>
    <div class="container bg-white p-3">
        <div class="row px-4">
            <div class="col h1">
                <h1>Editar perfil</h1>
            </div>
        </div>
        <form method="post" class="row row-cols-1 g-3 px-4">
            <div class="col">
                <div class="bg-navbar rounded-3 p-3">
                    <div class="fw-bold mb-2">DATOS PERSONALES</div>
                    <div class="row mb-2">
                        <div class="col-md-auto d-flex justify-content-center align-items-center">
                            <img src="<?php echo BASE_URL ?>img/perfil.jpg" alt="Foto de perfil" id="foto-perfil"
                                class="img-fluid perfil-imagen">
                        </div>
                        <div class="col-md-9 d-inline-block align-self-center pt-md-0 ">
                            <label for="fotoPerfil" class="form-label">Foto de Perfil</label>
                            <input class="form-control form-control-sm" type="file" id="fotoPerfil" accept="image/*">
                        </div>
                    </div>
                    <div class="row row-gap-2">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="username" class="form-control" id="username" name="username">
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono">
                        </div>

                        <div class="col-md-6">
                            <label for="contraseña" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contraseña" name="contraseña">
                        </div>

                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>

                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido">
                        </div>

                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Direccion</label>
                            <input type="direccion" class="form-control" id="direccion" name="direccion">
                        </div>


                    </div>
                </div>
            </div>


            <input type="hidden" id="habilidadesSeleccionadas" name="habilidadesSeleccionadas">

            <div class="col">
                <div class="bg-navbar rounded-3 p-3">
                    <label for="habilidad" class="form-label fw-bold">HABILIDADES</label>
                    <div id="habilidaderror" class="text-danger"></div>

                    <select class="form-select" id="habilidad" name="habilidad">
                        <option value="" disabled selected>Seleccione una habilidad</option>

                        <?php
                        $habilidades = $alumnoController->getHabilidades();

                        if (!empty($habilidades)) {
                            foreach ($habilidades as $habilidad) {
                                echo "<option value=\"" . htmlspecialchars($habilidad->getId()) . "\">" . htmlspecialchars($habilidad->getNombreHabilidad()) . "</option>";
                            }
                        } else {
                            echo "<option value=\"\" disabled>No hay habilidades disponibles</option>";
                        }
                        ?>
                    </select>

                    <button type="button" class="btn btn-secondary mt-2" id="agregarHabilidad">Agregar Habilidad</button>
                    
                    <div id="listaHabilidades" class="mt-3"></div>
                </div>
            </div>

            <div class="col">
                <div class="bg-navbar rounded-3 p-3">
                    <div class="fw-bold">EXPERIENCIA ACADÉMICA</div>
                    <div id="carreraerror" class="text-danger"></div>
                    <label for="carrera" class="form-label">Carrera</label>
                    <select class="form-select" id="carrera">
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
                    <select class="form-select d-none" id="planEstudios">
                        <option value="" disabled selected>Seleccione un plan de estudios</option>
                    </select>

                    <label for="materia" class="form-label mt-3 d-none" id="materiaLabel">Materia</label>
                    <select class="form-select d-none" id="materia">
                        <option value="" disabled selected>Seleccione una materia</option>
                    </select>
                    <button type="button" class="btn btn-secondary mt-2 d-none" id="agregarMateria">Agregar Materia
                        Aprobada</button>
                    <div class="my-2">
                        <div class="fw-bold">MATERIAS APROBADAS:</div>
                        <ul id="materiasAprobadasList" class="mb-3"></ul>
                    </div>
                </div>
            </div>
            <div class="col d-grid">
                <button type="submit" name="guardarPerfil" class="btn btn-success mt-3">Guardar Perfil</button>
            </div>
        </form>
    </div>
</body>

</html>