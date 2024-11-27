<?php
session_start();
require_once __DIR__ . '/../../controllers/UsuarioController.php';
require_once __DIR__ . '/../../controllers/EmpresaController.php';
$usuarioController = new UsuarioController();
$empresaController = new EmpresaController();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
require_once __DIR__ . '/../includes/permisos.php';
if (!Permisos::tienePermiso('Editar Perfil', $_SESSION['user']['user_id'])){
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
} 

$empresa = $usuarioController->obtenerEmpresa();
$empresa = $empresa['body']; 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarPerfil'])) {
    $empresaController->editarPerfilEmpresa($_SESSION['user']['user_id']);
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
    <?php if ($_SESSION['user']['user_type'] == 1){
            require __DIR__ . '/../components/admin-navbar.php';
    } elseif ($_SESSION['user']['user_type'] == 3){
            require __DIR__ . '/../components/empresa-navbar.php';
    }
    ?>
    <div class="container p-sm-4 bg-white">
        <div class="container mt-5">
            <h1 class="mb-4">Editar Perfil</h1>
            <form id="form-perfil-empresa" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="mb-3">
                            <img src="<?php echo ($empresa->getFotoPerfil()) ? BASE_URL . 'img/' . htmlspecialchars($empresa->getFotoPerfil()) : BASE_URL . 'img/perfil.jpg'; ?>" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; margin-right: 20px;" alt="Foto de perfil">
                        </div>
                        <input class="form-control" type="file" id="fotoPerfil" name="fotoPerfil">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombreEmpresa" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="nombreEmpresa" name="nombreEmpresa" placeholder="Nombre de la Empresa" value="<?php echo htmlspecialchars($empresa->getNombreEmpresa()); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($empresa->getMailCorporativo()); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input class="form-control" id="phone" name="phone" placeholder="Teléfono" value="<?php echo htmlspecialchars($empresa->getTelefono()); ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="website" class="form-label">Sitio web</label>
                        <input class="form-control" id="website" name="website" placeholder="Sitio web" value="<?php echo htmlspecialchars($empresa->getSitioWeb() ?: ''); ?>">
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <input class="form-control" id="address" name="address" placeholder="Dirección" value="<?php echo htmlspecialchars($empresa->getUbicacion()); ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="descripcion" class="form-label">Descripción de la Empresa</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción de la Empresa"><?php echo htmlspecialchars($empresa->getDescripcion()); ?></textarea>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nombre de Representante</label>
                        <input class="form-control" id="name" name="name" placeholder="Nombre de Representante" value="<?php echo htmlspecialchars($empresa->getNombre()); ?>">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success border border-dark mt-2" name="guardarPerfil">Guardar</button>
                    <a href="<?php echo BASE_URL ?>views/empresa-visualizar-perfil.php">
                                <button type="button" class="btn btn-danger mt-2"> Cancelar</button>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src='editar-perfil-empresa.js' defer></script>
</body>
</html>
