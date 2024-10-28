<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['Alumno'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__ . '/../components/admin-navbar.php'; ?>
    <div class="container p-sm-4 bg-white">
        <div class="row p-3">
            <h1>Editar evento</h1>
            <form class="g-3 pt-3">
                <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" required>
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
                            <input type="date" class="form-control" id="fecha" required>
                        </div>

                        <div class="col-md-6">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="hora" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="text-area" class="form-label">Descripción</label>
                            <textarea class="form-control" id="text-area" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" id="btn-editar">Editar Evento</button>
            </form>
        </div>
    </div>
</body>


</html>