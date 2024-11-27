<?php
session_start();
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();

if (!isset($_SESSION['user'])) {
	header("Location: ./inicio.php");
	exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Visualizar Publicaciones', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 

$publicaciones = $empresaController->listarPublicaciones();
if ($publicaciones['success']) {
	$publicaciones = $publicaciones['body'];
} else {
	$publicaciones = null;
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
	<?php if ($_SESSION['user']['user_type'] == 1){
            require __DIR__ . '/../components/admin-navbar.php';
    } elseif ($_SESSION['user']['user_type'] == 3){
            require __DIR__ . '/../components/empresa-navbar.php';
    }
    ?>

	<div class="container p-sm-4 bg-white">
		<div class="container mt-5">
			<div class="pb-5">
				<h1>Mis publicaciones</h1>
			</div>
			<?php if (Permisos::tienePermiso('Generar reporte Publicaciones', $_SESSION['user']['user_id'])){ ?>
			<div class="puesto-header mb-2">
				<a href="#" class="btn btn-success">Reporte</a>
			</div>
			<?php } ?>
			<div class="mb-5 list-group col-12 p-0">
				<?php
				if ($publicaciones) {
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

						$estado = $publicacion->getEstadoEmpleo();
						$estadoId = $estado->getId();
						$estadoNombre = $estado->getEstado();
						echo '<div class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<a href="' . BASE_URL . 'views/empresa-visualizar-publicacion.php?id=' . $publicacion->getId() . '" class="text-body text-decoration-none">
						<h5 class="mb-1">' . htmlspecialchars($publicacion->getTitulo()) . '</h5>
					</a>
					<small>' . $tiempoTranscurrido . '</small>
				</div>
				<p class="mb-1">' . htmlspecialchars($publicacion->getDescripcion()) . '</p>
				<small>' . htmlspecialchars($publicacion->getUbicacion()) . '</small>
				<div class="mt-2">
					<div class="d-flex justify-content-between align-items-center">
						<div class="btn-group btn-group-sm" role="group" data-publicacion-id="'. $publicacion->getId() . '" aria-label="Estado de la publicacion">';
							echo '<button type="button" class="btn ' . ($estadoNombre == 'Abierta' ? 'btn-success' : 'btn-secondary') . ' btn-sm" data-estado-id="1">Abierta</button>';
							echo '<button type="button" class="btn ' . ($estadoNombre == 'Finalizada' ? 'btn-success' : 'btn-secondary') . ' btn-sm" data-estado-id="2">Finalizada</button>';
							echo '<button type="button" class="btn ' . ($estadoNombre == 'Deshabilitada' ? 'btn-success' : 'btn-secondary') . ' btn-sm" data-estado-id="3">Deshabilitada</button>';
							echo '</div>
								<button type="button" class="btn btn-danger btn-sm" data-borrar-publicacion="'. $publicacion->getId() . '">Eliminar</button>
						</div>
					</div>
				</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<script src="../scripts/empresa/borrarPublicacion.js"></script>

	<script src="../scripts/empresa/cambiar-estado-publicacion.js"></script>
</body>

</html>