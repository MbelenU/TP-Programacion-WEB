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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" defer></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="puesto.css">
	<link rel="stylesheet" href="/css/global.css">
	<script src="/Nav-bar/nav-bar.js" defer></script>
	<script src="puesto.js" defer></script>
</head>

<body class="bg-inicio">
	<header>
		<nav class="navbar sticky-top bg-navbar">
			<div class="container-fluid">
				<a class="navbar-brand" href="#"><img src="../../img/logo.png" alt="logo"></a>
				<form class="d-none d-sm-flex" role="search">
					<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success d-grid align-content-center" type="submit">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
							<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
						</svg>
					</button>
				</form>
				<button class="navbar-toggler shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
					<div class="offcanvas-header">
						<img src="../../img/logo.png" alt="logo">
						<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<div class="offcanvas-body">
						<ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
							<li class="nav-item">
								<a class="nav-link" href="/Empresa/Perfil-Empresa/perfil-empresa.html">Mi perfil</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/Empresa/Publicar-Empleo/publicar-empleo.html">Publicar empleo</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/Empresa/Publicaciones-Empresa/publicaciones-empresa.html">Publicaciones</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/Empresa/Reclutar-empresa/reclutar-empresa.html">Reclutar</a>
							</li>
						</ul>
						<form class="d-flex d-sm-none mt-3" role="search">
							<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
							<button class="btn btn-outline-success d-grid align-content-center" type="submit">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
									<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
								</svg>
							</button>
						</form>
					</div>
				</div>
			</div>
		</nav>
	</header>
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
			<div class="pb-5">
				<h1>Publicación</h1>
			</div>
		    <div class="puesto-header d-flex justify-content-between">
				<div class="puesto-content">
					<h3 class="">Desarrollador de Software</h3>
					<p>Responsable del diseño, desarrollo y mantenimiento de aplicaciones web y móviles.</p>
				</div>
				<div>
					<a href="/Empresa/Editar-Empleo/editar-empleo.html" class="btn btn-reporte">Editar publicación</a>
				</div>
			</div>
			<ul class="list-group">
				<li class="list-group-item disabled" aria-disabled="true">Postulaciones de Alumnos</li>
				<li class="list-group-item">
					<div class="d-flex justify-content-between">
						<div>
							<span>Laura Martínez</span>
							<p class="mb-1" style="margin-top: 10px;">Postulación enviada <strong>Hace 3 días</strong></p>
							<a href="/Empresa/Reclutar-empresa/perfil-alumno.html" class="btn btn-sm">Ver perfil</a>
						</div>
						<div class="d-flex align-items-center">
							<div class="btn-group btn-group-sm " role="group" aria-label="Estado de la postulación">
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Recibido</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">En proceso</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Rechazado</button>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="d-flex justify-content-between">
						<div>
							<span>Carlos Pérez</span>
							<p class="mb-1" style="margin-top: 10px;">Postulación enviada <strong>Hace 5 días</strong></p>
							<a href="/Empresa/Reclutar-empresa/perfil-alumno.html" class="btn btn-sm">Ver perfil</a>
						</div>
						<div class="d-flex align-items-center">
							<div class="btn-group btn-group-sm " role="group" aria-label="Estado de la postulación">
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Recibido</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">En proceso</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Rechazado</button>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="d-flex justify-content-between">
						<div>
							<span>Sofía González</span>
							<p class="mb-1" style="margin-top: 10px;">Postulación enviada <strong>Hace 1 semana</strong></p>
							<a href="/Empresa/Reclutar-empresa/perfil-alumno.html" class="btn btn-sm">Ver perfil</a>
						</div>
						<div class="d-flex align-items-center">
							<div class="btn-group btn-group-sm " role="group" aria-label="Estado de la postulación">
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Recibido</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">En proceso</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Rechazado</button>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="d-flex justify-content-between">
						<div>
							<span>Andrés Jiménez</span>
							<p class="mb-1" style="margin-top: 10px;">Postulación enviada <strong>Hace 2 días</strong></p>
							<a href="/Empresa/Reclutar-empresa/perfil-alumno.html" class="btn btn-sm">Ver perfil</a>
						</div>
						<div class="d-flex align-items-center">
							<div class="btn-group btn-group-sm " role="group" aria-label="Estado de la postulación">
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Recibido</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">En proceso</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Rechazado</button>
							</div>
						</div>
					</div>
				</li>
				<li class="list-group-item">
					<div class="d-flex justify-content-between">
						<div>
							<span>Valeria Ruiz</span>
							<p class="mb-1" style="margin-top: 10px;">Postulación enviada <strong>Hace 4 días</strong></p>
							<a href="/Empresa/Reclutar-empresa/perfil-alumno.html" class="btn btn-sm">Ver perfil</a>
						</div>
						<div class="d-flex align-items-center">
							<div class="btn-group btn-group-sm " role="group" aria-label="Estado de la postulación">
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Recibido</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">En proceso</button>
								<button type="button" class="btn btn-success btn-sm" onclick="setStatus(this)">Rechazado</button>
							</div>
						</div>
					</div>
				</li>
			</ul>
			
		</div>
	</div>
</body>

</html>