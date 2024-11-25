<?php
require_once __DIR__ . '/../../controllers/AdministradorController.php';
$administradorController = new AdministradorController();

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

$allowedRoles = ['1'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php'; ?>
    <script src="<?php echo BASE_URL ?>scripts/admin/gestion-habilidad.js" defer></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-habilidades.css">
    <title>Gestión de Habilidades</title>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php'; ?>
    <div class="container p-sm-4 bg-white">
        <div class="row">
            <h2 class="mb-4">Gestión de Habilidades</h2>

            <!-- Barra de búsqueda y agregar habilidades -->
            <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex flex-grow-1 me-3">
                    <input type="text" id="searchInput" class="form-control me-2" placeholder="Buscar Habilidad">
                    <button id="searchButton" class="btn btn-light border border-success-subtle">Buscar</button>
                </div>
                <div class="d-flex flex-grow-1 mt-2 mt-md-0">
                    <input type="text" id="newSkillInput" class="form-control me-2" placeholder="Nueva Habilidad">
                    <button id="addSkillButton" class="btn btn-success">Agregar</button>
                </div>
            </div>

            <!-- Tabla de habilidades -->
            <div class="table-responsive rounded-table">
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Habilidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Las filas se renderizan dinámicamente con gestionar-habilidades.js -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>