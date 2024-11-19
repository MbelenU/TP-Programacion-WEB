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
$alumnos = $usuarioController->listarAlumnos();
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
    <?php require __DIR__ . '/../components/empresa-navbar.php' ?>
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <div class="d-flex justify-content-between pb-5">
                <h1>Reclutar alumnos</h1>
                <form class="d-sm-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Buscar alumnos" aria-label="Search">
                    <button class="btn btn-outline-success d-grid align-content-center" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0=" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="row">
                <?php
                foreach ($alumnos as $alumno) {
                    $nombreCompleto = htmlspecialchars($alumno->getNombreAlumno() . ' ' . $alumno->getApellidoAlumno());
                    $fotoPerfil = $alumno->getFotoDePerfil();

                    if (empty($fotoPerfil)) {
                        $fotoPerfil = '';
                    }

                    echo '<div class="col-12 mb-3">
                            <div class="d-flex justify-content-between align-items-center p-3 border rounded w-100">
                                <div class="d-flex align-items-center w-100">
                                    <img src="' . BASE_URL . htmlspecialchars($fotoPerfil) . '" alt="Foto de perfil de ' . $nombreCompleto . '" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                    <span class="fw-bold w-100">' . $nombreCompleto . '</span>
                                </div>
                                <a href="' . BASE_URL . 'views/empresa-visualizar-alumno.php?id=' . $alumno->getId() . '" class="btn btn-primary">Perfil</a>
                            </div>
                        </div>';
                }
                ?>
            </div>

        </div>
    </div>
</body>

</html>
