<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once '../../controllers/AdministradorController.php';
$adminController = new AdministradorController();


require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Visualizar Carreras', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}

$admin = $adminController->listarCarreras();
$carreras = $admin['body'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php'; ?>
    <script src="<?php echo BASE_URL ?>scripts/admin/gestion-carreras.js" defer></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-carreras.css">
    <title>Gestión de Carreras</title>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php'; ?>
    <div class="container p-sm-4 bg-white">
        <div class="row">
            <h2 class="mb-4">Gestión de Carreras</h2>

            <!-- Barra de búsqueda -->
            <div class="mb-3 d-flex">
                <input type="text" id="searchInput" class="form-control me-2" placeholder="Buscar Carrera">
                <button id="searchButton" class="btn btn-success">Buscar</button>
            </div>

            <!-- Tabla de carreras -->
            <div class="table-responsive rounded-table">
                <table class="table table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Carrera</th>
                            <th>Universidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php if (empty($carreras)): ?>
                            <tr>
                                <td colspan="3" class="text-center">No se encontraron carreras.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($carreras as $carrera): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($carrera['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <form class="" action="eliminar-carrera.php" method="POST">
                                            <button type="submit" class="btn btn-danger" data-eliminar-carrera="<?php echo htmlspecialchars($carrera['id']); ?>">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
