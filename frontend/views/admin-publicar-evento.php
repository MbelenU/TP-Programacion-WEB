<?php

require_once __DIR__ . '/../../controllers/AdministradorController.php';

$administradorController = new AdministradorController();


session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Publicar Eventos', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarEvento'])) {
    $evento = $administradorController->crearEvento();
    header("Location: ./admin-eventos.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="row p-3">
            <h1>Nuevo evento</h1>
            <form method="POST" class="g-3 pt-3">
                <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modalidad" class="form-label">Tipo</label>
                            <select class="form-select" id="modalidad" required>
                                <option value="" disabled selected>Seleccione un tipo de evento</option>
                                <option value="capacitacion">Capacitación</option>
                                <option value="tutoria">Tutoría</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>

                        <div class="col-md-6">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="hora" name="hora" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="text-area" class="form-label">Descripción</label>
                            <textarea class="form-control" id="text-area" rows="3" name="descripcion"></textarea>
                        </div>

                        <div class="col-md-6">
                        <label for="number" class="form-label">Créditos</label>
                        <input type="number" class="form-control" id="credito" name="number" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-2" id="btn-crear" name="guardarEvento">Publicar Evento</button>
                <a href="<?php echo BASE_URL ?>views/admin-eventos.php">
                                <button type="button" class="btn btn-danger mt-2"> Cancelar</button>
                </a>
            </form>
        </div>
    </div>
</body>

</html>