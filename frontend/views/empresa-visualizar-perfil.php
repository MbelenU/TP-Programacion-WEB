<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['3'];
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
				<h1>Mi Perfil</h1>
			</div>
			<div class="perfil-header">
				<img src="../Nav-bar/perfil.jpg" alt="Foto de perfil" id="foto-perfil">
				<div class="info">
					<div class="nombre">
						<h3>Empresa S.A.</h3>
					</div>
					<div class="descripcion">
						<p>Descripción de empresa</p>
					</div>
					<a href="<?php echo BASE_URL ?>views/empresa-editar-perfil.php" class="btn btn-outline-success">Editar perfil</a>
				</div>
			</div>
			<div class="mt-4">
				<h3>Información de Contacto</h3>
				<ul class="list-unstyled">
					<li><strong>Email:</strong> contacto@empresa.com</li>
					<li><strong>Teléfono:</strong> +11 111 111 111</li>
					<li><strong>Sitio web:</strong> <a href="https://www.empresa.com" target="_blank">www.empresa.com</a></li>
				</ul>
			</div>
			<div class="mt-4">
				<h3>Dirección</h3>
				<p>Calle Ejemplo, 123, Ciudad, País</p>
			</div>
			<div class="mt-4">
				<h3>Publicaciones Recientes</h3>
				<div class="list-group col-12 p-0">
					<a href="/Empresa/Publicaciones-Empresa/puesto.html" class="list-group-item list-group-item-action" aria-current="true">
						<div class="d-flex w-100 justify-content-between">
						  <h5 class="mb-1">Desarrollador de Software</h5>
						  <small>Hace 3 días</small>
						</div>
						<p class="mb-1">Responsable del diseño, desarrollo y mantenimiento de aplicaciones web y móviles.</p>
						<small>Conocimiento en lenguajes de programación como Java, Python y C#.</small>
					</a>
					<a href="/Empresa/Publicaciones-Empresa/puesto.html" class="list-group-item list-group-item-action">
						<div class="d-flex w-100 justify-content-between">
						  <h5 class="mb-1">Especialista en Seguridad e Higiene</h5>
						  <small class="text-muted">Hace 5 días</small>
						</div>
						<p class="mb-1">Encargado de implementar y supervisar normas de seguridad en el lugar de trabajo.</p>
						<small class="text-muted">Certificaciones en normativas de seguridad industrial y ambiental.</small>
					</a>
					<a href="/Empresa/Publicaciones-Empresa/puesto.html" class="list-group-item list-group-item-action">
						<div class="d-flex w-100 justify-content-between">
						  <h5 class="mb-1">Analista de Comercio Internacional</h5>
						  <small class="text-muted">Hace 1 semana</small>
						</div>
						<p class="mb-1">Gestiona operaciones de exportación e importación, asegurando el cumplimiento de regulaciones aduaneras.</p>
						<small class="text-muted">Experiencia en tratados internacionales y logística global.</small>
					</a>
				</div>
			</div>
		</div>
	</div>
</body>

</html>