<?php
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
</head>


<body class="bg-inicio">
	<?php require __DIR__ . '/../components/empresa-navbar.php' ?>
	<div class="container p-sm-4 bg-secondary-subtle">
		<div class="container mt-5">
			<div class="pb-5">
				<h1>Publicación</h1>
			</div>
			<div class="puesto-header d-flex justify-content-between">
				<div class="puesto-content">
					<h3 class=""><?php echo $publicacion->getTitulo() ?></h3>
					<p><?php echo $publicacion->getDescripcion() ?></p>
				</div>
				<div>
					<a href="<?php echo BASE_URL ?>views/empresa-editar-empleo.php" class="btn btn-reporte">Editar publicación</a>
				</div>
			</div>
			<ul class="list-group">
				<li class="list-group-item disabled" aria-disabled="true">Postulaciones de Alumnos</li>
				<li class="list-group-item">
					<div class="d-flex justify-content-between">
						<div>
							<?php
							$postulaciones = $publicacion->getPostulacion();
							if ($postulaciones && count($postulaciones) > 0) {
								foreach ($postulaciones as $postulacion) {
									$postulante = $postulacion->getPostulante();
									$nombrePostulante = $postulante->getNombreAlumno() . ' ' . $postulante->getApellidoAlumno();
									$estadoPostulacion = $postulacion->getEstadoPostulacion()->getEstado();
									$fechaPostulacion = $postulacion->getFechaPostulacion();
									$fechaPostulacionFormatted = $fechaPostulacion->format('d/m/Y');

									$hoy = new DateTime();
									$intervalo = $hoy->diff($fechaPostulacion);
									$diasTranscurridos = $intervalo->days;

									echo '<span>' . $nombrePostulante . '</span>
                    				<p class="mb-1" style="margin-top: 10px;">Postulación enviada <strong>Hace ' . $diasTranscurridos . ' días</strong></p>
                    				<a href="' . BASE_URL . 'views/empresa-visualizar-alumno.php?id=' . $postulante->getId() . '" class="btn btn-sm">Ver perfil</a>';
								}
							}
							?>
						</div>
						<div class="d-flex align-items-center">
							<div class="btn-group btn-group-sm" role="group" aria-label="Estado de la postulación">
								<button type="button" class="btn btn-success btn-sm">Recibido</button>
								<button type="button" class="btn btn-warning btn-sm">En proceso</button>
								<button type="button" class="btn btn-danger btn-sm">Rechazado</button>
							</div>
						</div>
					</div>
				</li>
			</ul>

		</div>
	</div>
</body>

</html>