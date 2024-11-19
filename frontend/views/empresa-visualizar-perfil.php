<?php
session_start();
require_once __DIR__ . '/../../controllers/UsuarioController.php';
$usuarioController = new UsuarioController();

if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

$allowedRoles = ['3'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}

$empresa = $usuarioController->obtenerEmpresa();
$empresa = $empresa['body']; 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php'; ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/global.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/empresa.css">
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/empresa-navbar.php'; ?>

    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <div class="pb-5">
                <h1>Mi Perfil</h1>
            </div>
			<div class="perfil-header">
				<img src="<?php echo BASE_URL . ($empresa->getFotoPerfil() ? $empresa->getFotoPerfil() : ''); ?>" alt="Foto de perfil" id="foto-perfil" class="img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
				<div class="info">
					<div class="nombre">
						<h3><?php echo $empresa->getNombre(); ?></h3>
					</div>
					<div class="descripcion">
						<p><?php echo $empresa->getDescripcion(); ?></p>
					</div>
					<a href="<?php echo BASE_URL ?>views/empresa-editar-perfil.php" class="btn btn-outline-success">Editar perfil</a>
				</div>
			</div>


            <div class="mt-4">
                <h3>Información de Contacto</h3>
                <ul class="list-unstyled">
                    <li><strong>Email:</strong> <?php echo $empresa->getMailCorporativo(); ?></li>
                    <li><strong>Teléfono:</strong> <?php echo $empresa->getTelefono(); ?></li>
                </ul>
            </div>

            <div class="mt-4">
                <h3>Dirección</h3>
                <p><?php echo $empresa->getUbicacion(); ?></p>
            </div>

            <div class="mt-4">
                <h3>Publicaciones Recientes</h3>
                <div class="list-group col-12 p-0">
                    <?php foreach ($empresa->getEmpleosPublicados() as $empleo) { ?>
                        <a href="<?php echo BASE_URL . 'views/empresa-visualizar-publicacion.php?id=' . $empleo->getId(); ?>" class="list-group-item list-group-item-action" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?php echo htmlspecialchars($empleo->getTitulo()); ?></h5>
                                <small><?php echo 'Hace ' . (new DateTime())->diff($empleo->getFecha())->days . ' días'; ?></small>
                            </div>
                            <p class="mb-1"><?php echo htmlspecialchars($empleo->getDescripcion()); ?></p>
                            <small><?php echo htmlspecialchars($empleo->getUbicacion()); ?></small>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
