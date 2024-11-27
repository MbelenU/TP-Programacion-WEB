<?php
require_once __DIR__ . '/../../controllers/AdministradorController.php';

$administradorController = new AdministradorController();
$evento = null;

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Editar Eventos', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 


//datos del evento a editar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $eventoId = $_GET['id'];
    $evento = $administradorController->obtenerEventoPorId($eventoId)["body"];
    if (!$evento) {
        echo "Evento no encontrado.";
        exit();
    }
} else {
    echo "ID de evento inválido.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editarEvento'])) {
    $eventoId = $_POST['eventoId'];
    $actualizado = $administradorController->editarEvento($eventoId);
    if ($actualizado['success']) {
        header("Location: ./admin-eventos.php");
        exit();
    } else {
        echo "Error al actualizar el evento.";
    }
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
            <form class="g-3 pt-3" method="POST">
            <input type="hidden" name="eventoId" value="<?php echo $evento->getId(); ?>">
                <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" value="<?php echo htmlspecialchars($evento->getNombreEvento()); ?>">
                        
                        </div>
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="" disabled selected>Seleccione un tipo de evento</option>
                                <option value="capacitacion">Capacitación</option>
                                <option value="tutoria">Tutoría</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="text" class="form-control" id="fecha" name="fecha" placeholder="Fecha" value="<?php echo htmlspecialchars($evento->getFechaEvento()); ?>">
                        </div>

                    </div>
                    <div class="mb-3">
                        <div class="col-md-6">
                        <div class="col-md-6">
                            <label for="number" class="form-label">Créditos</label>
                            <input type="number" class="form-control" id="creditos" name="creditos" placeholder="Creditos" value="<?php echo htmlspecialchars($evento->getCreditos()); ?>">
                            </div>

                        <label for="text-area" class="form-label">Descripción</label>
                        </div>
                        
                        <textarea class="w-100" id="descripcion" name="descripcion" placeholder="Escriba una descripción del evento" value="<?php echo htmlspecialchars($evento->getDescripcionEvento()); ?>"></textarea>
                        </div>
                        
                    </div>
                </div>
               
                <button type="submit" class="btn btn-success mt-2" name="editarEvento" id="btn-editar">Guardar</button>
                <a href="<?php echo BASE_URL ?>views/admin-miseventos.php">
                                <button type="button" class="btn btn-danger mt-2"> Cancelar</button>
                </a>
            </form>
        </div>
    </div>
</body>


</html>