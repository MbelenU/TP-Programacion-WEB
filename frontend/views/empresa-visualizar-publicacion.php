<?php
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['Empresa'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
elseif(!isset($_GET['id'])) {
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
					<h3 class=""><?php echo $publicacion['titulo'] ?></h3>
					<p><?php echo $publicacion['descripcion'] ?></p>
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
							<span>Laura Martínez</span>
							<p class="mb-1" style="margin-top: 10px;">Postulación enviada <strong>Hace 3 días</strong></p>
							<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn btn-sm">Ver perfil</a>
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
							<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn btn-sm">Ver perfil</a>
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
							<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn btn-sm">Ver perfil</a>
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
							<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn btn-sm">Ver perfil</a>
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
							<a href="<?php echo BASE_URL ?>views/empresa-visualizar-alumno.php" class="btn btn-sm">Ver perfil</a>
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