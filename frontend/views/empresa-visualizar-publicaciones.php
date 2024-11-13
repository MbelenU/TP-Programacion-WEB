<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['Empresa'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
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
	<?php require __DIR__ . '/../components/empresa-navbar.php' ?>
	
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
			<div class="pb-5">
				<h1>Mis publicaciones</h1>
			</div>
		    <div class="puesto-header mb-5">
				<a href="#" class="btn">Reporte</a>
			</div>
			<div class="row mb-5">
				<div class="list-group col-12 p-0">
					<a href="<?php echo BASE_URL ?>views/empresa-visualizar-puesto.php" class="list-group-item list-group-item-action" aria-current="true">
						<div class="d-flex w-100 justify-content-between">
						  <h5 class="mb-1">Desarrollador de Software</h5>
						  <small>Hace 3 días</small>
						</div>
						<p class="mb-1">Responsable del diseño, desarrollo y mantenimiento de aplicaciones web y móviles.</p>
						<small>Conocimiento en lenguajes de programación como Java, Python y C#.</small>
					  </a>
					  <a href="<?php echo BASE_URL ?>views/empresa-visualizar-puesto.php" class="list-group-item list-group-item-action">
						<div class="d-flex w-100 justify-content-between">
						  <h5 class="mb-1">Especialista en Seguridad e Higiene</h5>
						  <small class="text-muted">Hace 5 días</small>
						</div>
						<p class="mb-1">Encargado de implementar y supervisar normas de seguridad en el lugar de trabajo.</p>
						<small class="text-muted">Certificaciones en normativas de seguridad industrial y ambiental.</small>
					  </a>
					  <a href="<?php echo BASE_URL ?>views/empresa-visualizar-puesto.php" class="list-group-item list-group-item-action">
						<div class="d-flex w-100 justify-content-between">
						  <h5 class="mb-1">Analista de Comercio Internacional</h5>
						  <small class="text-muted">Hace 1 semana</small>
						</div>
						<p class="mb-1">Gestiona operaciones de exportación e importación, asegurando el cumplimiento de regulaciones aduaneras.</p>
						<small class="text-muted">Experiencia en tratados internacionales y logística global.</small>
					  </a>
					  <a href="<?php echo BASE_URL ?>views/empresa-visualizar-puesto.php" class="list-group-item list-group-item-action" aria-current="true">
						<div class="d-flex w-100 justify-content-between">
						  <h5 class="mb-1">Guía Turístico</h5>
						  <small>Hace 2 días</small>
						</div>
						<p class="mb-1">Acompaña y asesora a grupos de turistas durante sus visitas a lugares de interés.</p>
						<small>Conocimiento en historia local y habilidad para comunicarse en varios idiomas.</small>
					  </a>
					  <a href="<?php echo BASE_URL ?>views/empresa-visualizar-puesto.php" class="list-group-item list-group-item-action">
						<div class="d-flex w-100 justify-content-between">
						  <h5 class="mb-1">Agente de Viajes</h5>
						  <small class="text-muted">Hace 4 días</small>
						</div>
						<p class="mb-1">Organiza paquetes turísticos y coordina reservas de vuelos, hoteles y actividades.</p>
						<small class="text-muted">Especialización en turismo nacional e internacional, y gestión de itinerarios.</small>
					  </a>
				  </div>
			</div>
		</div>
	</div>
</body>

</html>