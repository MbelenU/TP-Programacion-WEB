<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['3'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
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
    <?php require __DIR__ . '/../components/empresa-navbar.php' ?>
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <h1 class="mb-4">Editar Perfil de Empresa</h1>
            <form id="form-perfil-empresa">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="profilePhoto" class="form-label">Foto de perfil</label>
                        <div class="mb-3">
                            <img src="../Nav-bar/perfil.jpg" class="img-thumbnail" alt="Foto de perfil">
                        </div>
                        <input class="form-control" type="file" id="profilePhoto">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="companyName" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="companyName" placeholder="Nombre de la Empresa" value="Empresa S.A.">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" value="contacto@empresa.com">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Teléfono" value="+11 111 111 111">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="website" class="form-label">Sitio web</label>
                        <input type="url" class="form-control" id="website" placeholder="Sitio web" value="https://www.empresa.com">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Descripción de la Empresa</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Descripción de la Empresa">Descripción de empresa</textarea>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-light border border-dark">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src='editar-perfil-empresa.js' defer></script>
</body>
</html>