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
			<div class="d-flex justify-content-between pb-5">
				<h1>Reclutar alumnos</h1>
				<form class="d-sm-flex" role="search">
					<input class="form-control me-2" type="search" placeholder="Reclutar alumnos" aria-label="Search">
					<button class="btn btn-outline-success d-grid align-content-center" type="submit">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
							class="bi bi-search" viewBox="0 0 16 16">
							<path
								d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
						</svg>
					</button>
				</form>
			</div>
			<div class="row mb-5 d-flex gap-5 justify-content-center">
				<div class="col-12 col-md-4 col-lg-3 card" style="width: 16rem;">
					<div class="card-body d-flex justify-content-center flex-wrap">
						<div class="w-100 text-center">
							<img class="card-img-top" src="../Nav-bar/perfil.jpg" alt="Foto de perfil de Laura Martínez" id="foto-perfil-navbar">
						</div>
						<h5 class="card-title">Laura Martínez</h5>
						<p class="card-text">Estudiante de Desarrollo de Software. Apasionada por la programación y el diseño de aplicaciones. Siempre buscando aprender nuevas tecnologías.</p>
						<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn">Ver perfil</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3 card" style="width: 16rem;">
					<div class="card-body d-flex justify-content-center flex-wrap">
						<div class="w-100 text-center">
							<img class="card-img-top" src="../Nav-bar/perfil.jpg" alt="Foto de perfil de Carlos Pérez" id="foto-perfil-navbar">
						</div>
						<h5 class="card-title">Carlos Pérez</h5>
						<p class="card-text">Estudiante de Turismo y Hotelería. Entusiasta de la hospitalidad y la gestión de experiencias únicas para los clientes. Amante de los viajes.</p>
						<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn">Ver perfil</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3 card" style="width: 16rem;">
					<div class="card-body d-flex justify-content-center flex-wrap">
						<div class="w-100 text-center">
							<img class="card-img-top" src="../Nav-bar/perfil.jpg" alt="Foto de perfil de Sofia González" id="foto-perfil-navbar">
						</div>
						<h5 class="card-title">Sofia González</h5>
						<p class="card-text">Estudiante de Comercio Internacional. Con una fuerte orientación hacia el análisis de mercados y las relaciones comerciales globales.</p>
						<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn">Ver perfil</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3 card" style="width: 16rem;">
					<div class="card-body d-flex justify-content-center flex-wrap">
						<div class="w-100 text-center">
							<img class="card-img-top" src="../Nav-bar/perfil.jpg" alt="Foto de perfil de Andrés Jiménez" id="foto-perfil-navbar">
						</div>
						<h5 class="card-title">Andrés Jiménez</h5>
						<p class="card-text">Estudiante de Logística. Especializado en la optimización de procesos y la gestión de la cadena de suministro. Apasionado por la eficiencia operativa.</p>
						<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn">Ver perfil</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3 card" style="width: 16rem;">
					<div class="card-body d-flex justify-content-center flex-wrap">
						<div class="w-100 text-center">
							<img class="card-img-top" src="../Nav-bar/perfil.jpg" alt="Foto de perfil de Valeria Ruiz" id="foto-perfil-navbar">
						</div>
						<h5 class="card-title">Valeria Ruiz</h5>
						<p class="card-text">Estudiante de Gestión Aeroportuaria. Con experiencia en operaciones aéreas y atención al cliente, buscando optimizar el servicio al pasajero.</p>
						<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn">Ver perfil</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3 card" style="width: 16rem;">
					<div class="card-body d-flex justify-content-center flex-wrap">
						<div class="w-100 text-center">
							<img class="card-img-top" src="../Nav-bar/perfil.jpg" alt="Foto de perfil de Miguel Torres" id="foto-perfil-navbar">
						</div>
						<h5 class="card-title">Miguel Torres</h5>
						<p class="card-text">Estudiante de Desarrollo de Software. Enfocado en el desarrollo de aplicaciones móviles y soluciones innovadoras. Amante del código limpio.</p>
						<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn">Ver perfil</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3 card" style="width: 16rem;">
					<div class="card-body d-flex justify-content-center flex-wrap">
						<div class="w-100 text-center">
							<img class="card-img-top" src="../Nav-bar/perfil.jpg" alt="Foto de perfil de Daniela López" id="foto-perfil-navbar">
						</div>
						<h5 class="card-title">Daniela López</h5>
						<p class="card-text">Estudiante de Turismo y Hotelería. Interesada en el desarrollo de proyectos turísticos sostenibles. Amante de la naturaleza y la cultura.</p>
						<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn">Ver perfil</a>
					</div>
				</div>
				<div class="col-12 col-md-4 col-lg-3 card" style="width: 16rem;">
					<div class="card-body d-flex justify-content-center flex-wrap">
						<div class="w-100 text-center">
							<img class="card-img-top" src="../Nav-bar/perfil.jpg" alt="Foto de perfil de Javier Salas" id="foto-perfil-navbar">
						</div>
						<h5 class="card-title">Javier Salas</h5>
						<p class="card-text">Estudiante de Comercio Internacional. Experto en negociaciones comerciales y análisis de mercados emergentes. Siempre buscando oportunidades de crecimiento.</p>
						<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn">Ver perfil</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>


</html>