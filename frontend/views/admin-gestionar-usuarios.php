<?php
require_once __DIR__ . '/../../controllers/AdministradorController.php';


$administradorController = new AdministradorController();
$response = $administradorController->listarUsuarios();


session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}

require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Visualizar Usuarios', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . '/../components/header.php'; ?>
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="http://localhost/TP-Programacion-WEB/frontend/css/admin-gestionar-usuarios.css">
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__ . '/../components/admin-navbar.php'; ?>
    <div class="container p-sm-4 bg-white">
        <h1>Gestión de Usuarios</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Usuarios</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <div class="mt-4 mb-4">
                    <?php if (Permisos::tienePermiso('Registrar Usuario', $_SESSION['user']['user_id'])){ ?>
                    <button onclick="window.location.href='admin-registro.php'" class="btn-registrar">Registrar Usuario</button>
                    <?php } ?>
                    <form class="d-sm-flex" role="search">
                        <input class="form-control me-2" type="search" id="buscarInput" placeholder="Buscar usuarios" aria-label="Search">
                        <button class="btn btn-outline-success d-grid align-content-center" id="buscarUsuarios">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <div class="user-list table-responsive " id="resultadosBusqueda">
                        <?php if (!empty($response)): ?>
                            <?php foreach ($response as $usuario): ?>
                                <div class="user-item">
                                    <div class="user-info"><strong>ID:</strong> <?= htmlspecialchars($usuario['id']) ?></div>
                                    <div class="user-info"><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></div>
                                    <div class="user-info"><strong>Email:</strong> <?= htmlspecialchars($usuario['mail']) ?></div>
                                    <div class="user-info"><strong>Estado:</strong> <?= ($usuario['de_baja'] === 'N') ? 'Activo' : 'Inactivo' ?></div>
                                    <div class="user-actions">
                                        <?php if (Permisos::tienePermiso('Cambiar contraseña', $_SESSION['user']['user_id'])){ ?>
                                        <button class="btn btn-warning btn-cambiar-pass" type="button" data-id="<?= $usuario['id'] ?>">Cambiar Clave</button>
                                        <?php } ?>
                                        <?php if (Permisos::tienePermiso('Baja Usuario', $_SESSION['user']['user_id'])){ ?>
                                        <button class="btn btn-danger btn-dar-baja" type="button" data-id="<?= $usuario['id'] ?>">Deshabilitar</button>
                                        <?php } ?>
                                        <?php if (Permisos::tienePermiso('Alta Usuario', $_SESSION['user']['user_id'])){ ?>
                                        <button class="btn btn-success btn-habilitar" type="button" data-id="<?= $usuario['id'] ?>">Habilitar</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No se encontraron usuarios.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlace al archivo JS -->
    <script src="http://localhost/TP-Programacion-WEB/frontend/scripts/admin/admin-gestionar-usuarios.js"></script>
</body>

</html>