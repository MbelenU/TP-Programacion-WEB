<?php
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
<html>

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <script src="<?php echo BASE_URL ?>scripts/admin/gestionar-habilidades.js" defer></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-habilidades.css">
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="row">
            <h2 class="mb-4">Gestión de Habilidades</h2>

            <div class="mb-3 d-flex justify-content-between">
                <input type="text" id="searchInput" class="form-control me-2" placeholder="Buscar Habilidad">
                <button id="searchButton" class=" btn btn-light border border-success-subtle "
                    onclick="buscarHabilidad()">Buscar</button>
                <div class="mx-2"></div>
                <input type="text" id="newSkillInput" class="form-control me-2" placeholder="Nueva Habilidad">
                <button id="addSkillButton" class="btn btn-success">Crear Habilidad</button>
            </div>

            <div class="table-responsive rounded-table">
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Habilidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>