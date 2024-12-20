<?php
session_start();
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$empresaController = new EmpresaController();

if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Reclutar Perfil', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 
$alumnos = $empresaController->listarAlumnos();
$alumnos = $alumnos['body']; 
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
            <div class="d-flex justify-content-between pb-5">
                <h1>Reclutar alumnos</h1>
				<form class="d-sm-flex" role="search">
					<input class="form-control me-2" type="search" id="buscarInput" placeholder="Buscar alumnos" aria-label="Search">
					<button class="btn btn-outline-success d-grid align-content-center" id="buscarAlumnos" type="submit">
						<i class="bi bi-search"></i>
					</button>
				</form>
            </div>
            <div class="mb-5 list-group col-12 p-0" id="resultadosBusqueda">
                <?php
                foreach ($alumnos as $alumno) {
                    $nombreCompleto = $alumno->getNombreAlumno() . ' ' . $alumno->getApellidoAlumno();
					$fotoPerfil = $alumno->getFotoPerfil() ? BASE_URL . 'img/' . $alumno->getFotoPerfil() : BASE_URL . 'img/perfil.jpg';
					$descripcion = $alumno->getDescripcion();
                    $nombreCarrera = $alumno->getCarrera()->getNombreCarrera();
                    echo '<div class="col-12 list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center p-3 rounded w-100">
                                <div class="d-flex align-items-center w-100">
                                    <img src="' . htmlspecialchars($fotoPerfil) . '" alt="Foto de perfil de ' . $nombreCompleto . '" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                    <div class="w-100">
										<span class="fw-bold w-100 d-block">' . $nombreCompleto . '</span>
                                        <span class="w-100 d-block">Carrera: ' . $nombreCarrera . '</span>
										<span class="w-100">' . $descripcion . '</span>
									</div>
                                </div>
                                <a href="' . BASE_URL . 'views/empresa-visualizar-alumno.php?id=' . $alumno->getId() . '" class="btn btn-success">Perfil</a>
                            </div>
                        </div>';
                }
                ?>
            </div>

        </div>
    </div>
	<script src="../scripts/empresa/buscarAlumnos.js"></script>
</body>

</html>
