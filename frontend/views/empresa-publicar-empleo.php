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
	<link rel="stylesheet" href="/Empresa/Publicar-Empleo/publicar-empleo.css">
	<link rel="stylesheet" href="/css/global.css">
	<script src="/Nav-bar/nav-bar.js" defer></script>
	<script src="publicar-empleo.js" defer></script>
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
				<div class="editar-header">
					<div class="editar">
						<div class="nombre-editar">
							<h1>Publicar empleo</h1>
						</div>
					</div>
				</div>
			</div>
			<form class="row g-3">
				<div class="col-md-12">
					<div class="row mb-3">
						<div class="col-md-6">
							<label for="titulo" class="form-label">Titulo</label>
							<input type="text" class="form-control" id="titulo" required>
						</div>
						<div class="col-md-6">
							<label for="modalidad" class="form-label">Modalidad</label>
							<select class="form-select" id="modalidad" required>
								<option value="" disabled selected>Seleccione una modalidad</option>
								<option value="Presencial">Presencial</option>
								<option value="Remoto">Remoto</option>
								<option value="Hibrido">Hibrido</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label for="ubicación" class="form-label">Ubicación</label>
							<input class="form-control" list="datalistOptions" id="ubicacion" placeholder="Buscar">
							<datalist id="datalistOptions">
								<option value="CABA">
								<option value="Ezeiza">
								<option value="Montegrande">
								<option value="Cañuelas">
							</datalist>
						</div>
						<div class="col-md-6">
							<label for="modalidad" class="form-label">Jornada</label>
							<select class="form-select" id="jornada" required>
								<option value="" disabled selected>Seleccione un tipo de jornada</option>
								<option value="jornada-completa">Jornada completa</option>
								<option value="media-jornada">Media jornada</option>
								<option value="practicas">Practicas</option>
								<option value="voluntario">Voluntario</option>
								<option value="otro">Otro</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-md-6">
							<label for="text-area" class="form-label">Descripción</label>
							<textarea class="form-control" id="text-area" rows="3"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-12 mb-3">
					<div>
						<h2 class="datospersonales-header">Habilidades requeridas</h2>
						<div id="habilidaderror" class="text-danger"></div>
						<input class="form-control" list="datalistOptions" id="habilidad" placeholder="Buscar">
						<datalist id="datalistOptions">
							<option value="HTML">
							<option value="CSS">
							<option value="JavaScript">
							<option value="Base de Datos">
						</datalist>
						<button type="button" class="btn btn-secondary mt-2" id="agregarHabilidad">Agregar
							Habilidad</button>
						<ul id="listaHabilidades" class="mb-3"></ul>
					</div>
					<div class="row justify-content-between">
						<h2 class="datospersonales-header">Materias requeridas</h2>
						<div class="col-md-6">
							<div id="carreraerror" class="text-danger"></div>
							<label for="carrera" class="form-label">Carrera</label>
							<select class="form-select" id="carrera" required>
								<option value="" disabled selected>Seleccione una opción</option>
								<option value="Desarrollo de Software">Desarrollo de Software</option>
								<option value="Turismo">Turismo</option>
								<option value="Comercio Internacional">Comercio Internacional</option>
								<option value="Gestión Aeroportuaria">Gestión Aeroportuaria</option>
								<option value="Logistica">Logistica</option>
								<option value="Higiene y Seguridad">Higiene y Seguridad</option>
							</select>

							<label for="planEstudios" class="form-label mt-3 d-none" id="planEstudiosLabel">Plan de
								Estudios</label>
							<div id="planerror" class="text-danger"></div>
							<select class="form-select d-none" id="planEstudios" required>
								<option value="" disabled selected>Seleccione un plan de estudios</option>
							</select>

							<label for="materia" class="form-label mt-3 d-none" id="materiaLabel">Materia</label>
							<select class="form-select d-none" id="materia">
								<option value="" disabled selected>Seleccione una materia</option>
							</select>
							<button type="button" class="btn btn-secondary mt-2 d-none" id="agregarMateria">Agregar
								Materia
								Aprobada</button>
						</div>
						<div class="col-md-6">
							<ul id="materiasAprobadasList" class="mb-3"></ul>
						</div>
					</div>
					<button type="submit" class="btn mt-2">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</body>


</html>