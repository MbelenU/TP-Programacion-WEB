<?php
session_start();
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();
if (!isset($_SESSION['user'])) {
	header("Location: ./inicio.php");
	exit();
}
require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Visualizar Publicacion', $_SESSION['user']['user_id'])) {
	echo "Acceso denegado. No tienes permisos para acceder a esta página.";
	exit();
} elseif (!isset($_GET['id'])) {
	echo "Publicacion no encontrada";
	exit();
}
$publicacion = $empresaController->obtenerPublicacion($_GET['id']);
$publicacion = $publicacion['body'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<?php require __DIR__ . '/../components/header.php' ?>
	<link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/global.css">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/empresa.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-inicio">
	<?php if ($_SESSION['user']['user_type'] == 1) {
		require __DIR__ . '/../components/admin-navbar.php';
	} elseif ($_SESSION['user']['user_type'] == 3) {
		require __DIR__ . '/../components/empresa-navbar.php';
	}
	?>
	<div class="container p-sm-4 bg-white">
		<div class="container mt-5">
			<div class="pb-5">
				<h1>Publicación</h1>
			</div>
			<div class="puesto-header d-flex justify-content-between">
				<div class="puesto-content">
					<a href="<?php echo BASE_URL ?>views/empresa-visualizar-publicacion.php?id=<?php echo $_GET['id']; ?>" class="text-decoration-none text-body">
						<h3 class=""><?php echo $publicacion->getTitulo() ?></h3>
					</a>
					<p><?php echo $publicacion->getDescripcion() ?></p>

					<div class="mb-2">
						<label for="modalidad"><strong>Modalidad:</strong></label>
						<p id="modalidad"><?php echo $publicacion->getModalidad()->getDescripcionModalidad(); ?></p>
					</div>

					<div class="mb-2">
						<label for="jornada"><strong>Jornada:</strong></label>
						<p id="jornada"><?php echo $publicacion->getJornada()->getDescripcionJornada(); ?></p>
					</div>

					<div class="mb-2">
						<label for="ubicacion"><strong>Ubicación:</strong></label>
						<p id="ubicacion"><?php echo $publicacion->getUbicacion(); ?></p>
					</div>

				</div>
				<?php if (Permisos::tienePermiso('Editar Empleo', $_SESSION['user']['user_id'])) { ?>
					<div>
						<a href="<?php echo BASE_URL ?>views/empresa-editar-empleo.php?id=<?php echo $_GET['id']; ?>" class="btn btn-success">Editar publicación</a>
					</div>
				<?php } ?>
			</div>

			<ul class="list-group">
				<li class="list-group-item disabled" aria-disabled="true">Postulaciones de Alumnos</li>

				<?php
				$postulaciones = $publicacion->getPostulacion();
				if ($postulaciones && count($postulaciones) > 0) {
					foreach ($postulaciones as $postulacion) {
						$postulante = $postulacion->getPostulante();
						$nombrePostulante = $postulante->getNombreAlumno() . ' ' . $postulante->getApellidoAlumno();
						$estadoPostulacion = $postulacion->getEstadoPostulacion()->getEstado();
						$estadoPostulacionId = $postulacion->getEstadoPostulacion()->getId();
						$fechaPostulacion = $postulacion->getFechaPostulacion();
						$fechaPostulacionFormatted = $fechaPostulacion->format('d/m/Y');

						$hoy = new DateTime();
						$intervalo = $hoy->diff($fechaPostulacion);
						$diasTranscurridos = $intervalo->days;
				?>

						<li class="list-group-item d-flex justify-content-between">
							<div>
								<span><?php echo $nombrePostulante; ?></span>
								<p class="mb-1" style="margin-top: 10px;">Postulación enviada <strong>Hace <?php echo $diasTranscurridos; ?> días</strong></p>
								<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php?id=<?php echo $postulante->getId(); ?>" class="btn btn-success btn-sm">Ver perfil</a>
							</div>
							<div class="d-flex align-items-center">
								<div class="btn-group btn-group-sm" role="group" aria-label="Estado de la postulación" data-postulacion-id="<?php echo $postulacion->getId(); ?>">

									<button type="button" class="btn <?php echo ($estadoPostulacionId == 1 ? 'btn-primary' : 'btn-secondary'); ?> btn-sm" data-estado-id="1">Recibido</button>
									<button type="button" class="btn <?php echo ($estadoPostulacionId == 2 ? 'btn-primary' : 'btn-secondary'); ?> btn-sm" data-estado-id="2">En evaluación</button>
									<button type="button" class="btn <?php echo ($estadoPostulacionId == 3 ? 'btn-success' : 'btn-secondary'); ?> btn-sm" data-estado-id="3">Reclutado</button>
									<button type="button" class="btn <?php echo ($estadoPostulacionId == 4 ? 'btn-danger' : 'btn-secondary'); ?> btn-sm" data-estado-id="4">Finalizado</button>
								</div>
							</div>
						</li>
				<?php
					}
				}
				?>
			</ul>

			<?php if (Permisos::tienePermiso('Generar reporte Postulaciones', $_SESSION['user']['user_id'])) { ?>
				<div class="puesto-header mt-3">
					<a href="#" class="btn btn-success">Generar reporte</a>
				</div>
			<?php } ?>
		</div>
	</div>
	<script src="../scripts/empresa/cambiar-estado-postulacion.js"></script>
</body>

</html>