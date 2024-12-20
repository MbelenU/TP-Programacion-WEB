<?php
require_once __DIR__ . '/../../controllers/AdministradorController.php';

$administradorController = new AdministradorController();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['1'];

    if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
        echo "Acceso denegado. No tienes permisos para acceder a esta página.";
        exit();
    }

    $evento = $administradorController->obtenerEventoPorId($_GET['id']);

    if(!$evento['status'] === "success"){
        echo "<div class='alert alert-danger'>Evento no encontrado</div>";
        exit();
    }else{
        $evento = $evento['body'];
    }

   // var_dump($evento);
    
    $inscriptos = $administradorController->obtenerInscriptos($evento->getId());
    
    if(!$inscriptos['success'] === "false"){
        echo "<div class='alert alert-danger'>Alumno no encontrado</div>";
        exit();
    }else{
        $inscriptos = $inscriptos['body'] ?? [];
    }
    //var_dump($inscriptos);

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['borrarInscripto'])){
        $alumnoId = $_POST['id_usuario'];
        $eventoId = $evento->getId();

       
        $resultado = $administradorController->eliminarInscripto($alumnoId, $eventoId);
    }
        //var_dump($resultado);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-detalle-evento.css">
    <script src="<?php echo BASE_URL ?>/scripts/admin-detalle-evento.js" defer></script>
</head>

<body class="p-0 bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <section class="container">
            <a href="<?php echo BASE_URL ?>views/admin-eventos.php" class="btn btn-light btn-reporte"><i class="bi bi-arrow-left"></i></a>
            <div class="titulo-header">
                <h1>Evento</h1>
            </div>
        
            <div class="container-background p-5">
                <div class="puesto-header mb-5 d-flex justify-content-between">
                    <div class="puesto-content">
                        <!-- Título del evento -->
                        <?php if (!empty($evento)): ?>
                        <div class="mb-5 list-group col-12 p-0">
                        
                        <h2><?php echo htmlspecialchars($evento->getNombreEvento()); ?></h2>
                        <div class="mt-4">
                            <i class="bi bi-calendar3"><strong> Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($evento->getFechaEvento())); ?> </i>
                        </div>
                        <div class="mt-4">
                            <strong>Descripción:</strong>
                            <p><?php echo htmlspecialchars($evento->getDescripcionEvento()); ?></p>
                        </div>
                       
                        <div class="mt-4">
                            <strong>Créditos:</strong>
                            <p><?php echo htmlspecialchars($evento->getCreditos()); ?></p>
                        </div>
                    </div>
                    <div class="button-container">
                        <a href="<?php echo BASE_URL ?>views/admin-editar-evento.php?id=<?php echo $evento->getId(); ?>" class="btn btn-success btn-reporte mb-2">Editar</a>
                        
                    </div>
                    
                        </div>
                    <?php else: ?>
                        <p>No hay eventos disponibles en este momento.</p>
                    <?php endif; ?>
                </div>
                

                <ul class="list-group">
                    <li class="list-group-item disabled bg-secondary-subtle" aria-disabled="true">Inscriptos</li>
                    <?php if (!empty($inscriptos)): ?>
                        <?php foreach ($inscriptos as $inscripto): ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span><?php echo htmlspecialchars($inscripto['nombre_alumno']) . ' ' . htmlspecialchars($inscripto['apellido_alumno']); ?></span>
                                    </div>
                                    <div>
            
                                            
                                    <div class="row mt-4 d-flex align-items-center">
                                        <button class="btn btn-danger" data-desuscribir-id="<?php echo htmlspecialchars($inscripto['id_usuario']); ?>" data-desuscribir-evento-id="<?php echo $evento->getId(); ?>">
                                            <i class="bi bi-bell"></i> Eliminar
                                            </button>
                                        </div>

                                       
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">No hay inscriptos para este evento.</li>
                    <?php endif; ?>
                </ul>


            </div>
        </section>
    </div>
</body>

</html>
