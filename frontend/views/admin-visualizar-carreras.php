<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Visualizar Carreras', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 

?>
<!DOCTYPE html>
<html>

<head>
    <?php require __DIR__ . '/../components/header.php'?>
    <script src="<?php echo BASE_URL ?>scripts/admin/visualizar-carreras.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="row">
            <h2 class="mb-4">Carreras</h2>

            <div class="mb-3 d-flex">
                <input type="text" id="searchInput" class="form-control me-2" placeholder="Buscar Carrera">
                <button id="searchButton" class="btn btn-success">Buscar</button>
            </div>


            <div class="table-responsive rounded-table">
                <table class="table table-bordered table-hover">
                    <thead class="table-success ">
                        <tr>
                            <th>Carrera</th>
                            <th>Universidad</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>