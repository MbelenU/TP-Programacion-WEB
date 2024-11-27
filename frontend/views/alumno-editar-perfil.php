<?php
require_once __DIR__ . '/../../controllers/AlumnoController.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$alumno = null;

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Editar Perfil', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} else {
    $alumno = $alumnoController->obtenerAlumnoPorId($_SESSION['user']['user_id'])["body"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarPerfil'])) {
    $alumno = $alumnoController->editarPerfilAlumno($_SESSION['user']['user_id']);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/global.css">
    <script src="<?php echo BASE_URL ?>scripts/alumno/editar-perfil.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php'; ?>
    <div class="container p-sm-4 bg-white rounded-bottom-1 ">
        <div class="container">
            <div class="bg-light rounded p-4 shadow">
                <h1 class="mb-4">Editar Perfil</h1>
                <form method="post" enctype="multipart/form-data">
                    <label for="datosPersonales" class="form-label fw-bold">DATOS PERSONALES</label>
                    <div class="row align-items-center mb-3">
                        <div class="col-md-3 text-center text-md-start">
                            <img src="<?php echo ($alumno->getFotoPerfil()) ? BASE_URL . 'img/' . htmlspecialchars($alumno->getFotoPerfil()) : BASE_URL . 'img/perfil.jpg'; ?>" class="rounded-circle img-fluid" style="width: 120px; height: 120px; object-fit: cover; margin-right: 20px;" alt="Foto de perfil">
                        </div>
                        <div class="col-md-9 mt-3 mt-md-0">
                            <input class="form-control" type="file" id="fotoPerfil" name="fotoPerfil">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo htmlspecialchars($alumno ? $alumno->getEmail() : ''); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono"
                                value="<?php echo htmlspecialchars($alumno ? $alumno->getTelefono() : ''); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="<?php echo htmlspecialchars($alumno ? $alumno->getNombreAlumno() : ''); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido"
                                value="<?php echo htmlspecialchars($alumno ? $alumno->getApellidoAlumno() : ''); ?>">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3 w-100">
                            <label for="direccion" class="form-label">Direccion</label>
                            <input type="direccion" class="form-control" id="direccion" name="direccion"
                                value="<?php echo htmlspecialchars($alumno ? $alumno->getUbicacion() : ''); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <div class="col">
                            <textarea name="descripcion" id="descripcion" class="w-100 form-control " placeholder="Introduzca una descripción para el perfil"><?php echo htmlspecialchars($alumno ? $alumno->getDescripcion() : ''); ?></textarea>

                        </div>
                    </div>
                    <hr>
                    <input type="hidden" id="habilidadesSeleccionadas" name="habilidadesSeleccionadas">
                    <div id="alumnoId" data-id="<?php echo $_SESSION['user']['user_id']; ?>"></div>
                    <div class="row">
                        <label for="habilidad" class="form-label fw-bold">HABILIDADES</label>
                        <div id="habilidaderror" class="text-danger"></div>

                        <!-- Selección de habilidad -->
                        <div class="hstack gap-2">
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

                            <!-- Botón para agregar habilidad -->
                            <button type="button" class="btn btn-primary" id="agregarHabilidad">Agregar</button>
                        </div>

                        <!-- Lista de habilidades agregadas -->
                        <div id="listaHabilidades" class="mt-3 d-flex flex-wrap gap-3">
                            <?php if (!empty($alumno->getHabilidades())): {
                                    foreach ($alumno->getHabilidades() as $habilidad): { ?>
                                            <div class="habilidad-item d-grid align-items-center justify-content-start bg-light p-2 rounded mb-2" data-id="<?= htmlspecialchars($habilidad->getId()) ?>">
                                                <span class="habilidad-nombre fw-bold text-center"><?= htmlspecialchars($habilidad->getNombreHabilidad()) ?></span>
                                                <!-- Estrellas para calificar el nivel -->
                                                <div class="stars" data-id="<?= htmlspecialchars($habilidad->getId()) ?>">
                                                    <?php foreach (range(1, 5) as $i): ?>
                                                        <i class="star checked bi <?= $i <= $habilidad->getNivelHabilidad() ? 'bi-star-fill' : 'bi-star' ?>"
                                                            data-value="<?= $i ?>"
                                                            data-id="<?= htmlspecialchars($habilidad->getId()) ?>"></i>
                                                    <?php endforeach; ?>
                                                </div>

                                                <button type="button" class="btn btn-danger btn-sm eliminarHabilidad">Eliminar</button>
                                            </div>
                                    <?php }
                                    endforeach; ?>
                            <?php }
                            endif; ?>
                        </div>
                        <input type="hidden" id="habilidadesSeleccionadas" name="habilidadesSeleccionadas">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="fw-bold mb-3">EXPERIENCIA ACADÉMICA</div>
                        <div id="carreraerror" class="text-danger"></div>

                        <!-- Etiqueta y selección de carrera -->
                        <label for="carrera" class="form-label">Carrera</label>
                        <select class="form-select " id="carrera" name="carrera" disabled>
                            <option value="" disabled <?php echo !$alumno || !$alumno->getCarrera() ? 'selected' : ''; ?>>Seleccione una carrera</option>

                            <?php
                            $carreras = $alumnoController->listarCarreras()["body"];

                            if (!empty($carreras)) {
                                foreach ($carreras as $carrera) {
                                    // Si el alumno ya tiene carrera, marcarla como seleccionada
                                    $selected = ($alumno && $alumno->getCarrera() && $alumno->getCarrera()->getId() == $carrera->getId()) ? 'selected' : '';
                                    echo "<option value=\"" . htmlspecialchars($carrera->getId()) . "\" $selected>" . htmlspecialchars($carrera->getNombreCarrera()) . "</option>";
                                }
                            } else {
                                echo "<option value=\"\" disabled>No hay carreras disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="text-end">
                            <button type="submit" class="btn btn-success border border-dark mt-3" name="guardarPerfil">Guardar</button>
                            <a href="<?php echo BASE_URL ?>views/alumno-perfil.php">
                                <button type="button" class="btn btn-danger mt-3"> Cancelar</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>