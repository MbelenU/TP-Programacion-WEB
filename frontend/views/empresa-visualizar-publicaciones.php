<?php
session_start();
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();

if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['3'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
$publicaciones = $empresaController->listarPublicaciones();
$publicaciones = $publicaciones['body']; 
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
                <h1>Mis publicaciones</h1>
            </div>
            <div class="puesto-header mb-5">
                <a href="#" class="btn btn-success">Reporte</a>
            </div>
            <div class="row mb-5">
                <?php
                    foreach ($publicaciones as $publicacion) {
                        $fechaPublicacion = $publicacion->getFecha();
                        $hace = $fechaPublicacion->diff(new DateTime());
                        if ($hace->y > 0) {
                            $tiempoTranscurrido = $hace->y . ' años';
                        } elseif ($hace->m > 0) {
                            $tiempoTranscurrido = $hace->m . ' meses';
                        } elseif ($hace->d > 0) {
                            $tiempoTranscurrido = $hace->d . ' días';
                        } elseif ($hace->h > 0) {
                            $tiempoTranscurrido = $hace->h . ' horas';
                        } elseif ($hace->i > 0) {
                            $tiempoTranscurrido = $hace->i . ' minutos';
                        } else {
                            $tiempoTranscurrido = 'hace menos de un minuto';
                        }
                    
                        $estado = $publicacion->getEstadoEmpleo()->getEstado();
                        $estadoTexto = '';

                        switch ($estado) {
                            case 'Abierta':
                                $estadoTexto = '<span class="badge bg-success">Abierta</span>';
                                break;
                            case 'Cerrada':
                                $estadoTexto = '<span class="badge bg-warning">Cerrada</span>';
                                break;
                            case 'Finalizada':
                                $estadoTexto = '<span class="badge bg-info">Finalizada</span>';
                                break;
                            case 'Deshabilitada':
                                $estadoTexto = '<span class="badge bg-secondary">Deshabilitada</span>';
                                break;
                            default:
                                $estadoTexto = '<span class="badge bg-dark">Desconocido</span>';
                                break;
                        }

                        echo '<a href="' . BASE_URL . 'views/empresa-visualizar-publicacion.php?id=' . $publicacion->getId() . '" class="mb-4 list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">' . htmlspecialchars($publicacion->getTitulo()) . '</h5>
                                <small>' . $tiempoTranscurrido . '</small>
                            </div>
                            <p class="mb-1">' . htmlspecialchars($publicacion->getDescripcion()) . '</p>
                            <small>' . htmlspecialchars($publicacion->getUbicacion()) . '</small>
                            <div class="mt-2">' . $estadoTexto . '</div>
                        </a>';
                    }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
