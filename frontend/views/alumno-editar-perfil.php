<?php
require_once __DIR__ . '/../../controllers/AlumnoController.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$alumno = null;
$allowedRoles = ['2'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
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
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/global.css">
    <script src="<?php echo BASE_URL ?>scripts/alumno/editar-perfil.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php'; ?>
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <h1 class="mb-4">Editar Perfil</h1>
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="mb-3">
                            <img src="<?php echo ($alumno->getFotoPerfil()) ? BASE_URL . 'img/' . htmlspecialchars($alumno->getFotoPerfil()) : BASE_URL . 'img/perfil.jpg'; ?>" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; margin-right: 20px;" alt="Foto de perfil">
                        </div>
                        <input class="form-control" type="file" id="fotoPerfil" name="fotoPerfil">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
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

                    <div class="col-md-6 mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="direccion" class="form-control" id="direccion" name="direccion"
                            value="<?php echo htmlspecialchars($alumno ? $alumno->getUbicacion() : ''); ?>">
                    </div>
                </div>

        </div>


        <input type="hidden" id="habilidadesSeleccionadas" name="habilidadesSeleccionadas">

        <div class="col">
            <div class="bg-light rounded-3 p-4 shadow-sm">
                <label for="habilidad" class="form-label fw-bold">HABILIDADES</label>
                <div id="habilidaderror" class="text-danger mb-3"></div>

                <!-- Selección de habilidad -->
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
                <button type="button" class="btn btn-primary mt-3" id="agregarHabilidad">Agregar Habilidad</button>

                <!-- Lista de habilidades agregadas -->
                <div id="listaHabilidades" class="mt-3">
                    <?php
                    if (!empty($alumno->getHabilidades())) {
                        foreach ($alumno->getHabilidades() as $habilidad) {
                            echo '<div class="habilidad-item d-flex align-items-center justify-content-between bg-light p-2 rounded mb-2" data-id="' . htmlspecialchars($habilidad->getId()) . '">';
                            echo '<span class="habilidad-nombre">' . htmlspecialchars($habilidad->getNombreHabilidad()) . '</span>';
                            echo '<button type="button" class="btn btn-danger btn-sm eliminarHabilidad">Eliminar</button>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>


        <div class="col">
            <div class="bg-light rounded-3 p-4 shadow-sm">
                <div class="fw-bold mb-3">EXPERIENCIA ACADÉMICA</div>
                <div id="carreraerror" class="text-danger mb-3"></div>

                <!-- Etiqueta y selección de carrera -->
                <label for="carrera" class="form-label">Carrera</label>
                <select class="form-select" id="carrera" name="carrera" disabled>
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
        </div>


        <div class="text-end">
            <button type="submit" class="btn btn-success border border-dark" name="guardarPerfil">Guardar</button>
        </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>