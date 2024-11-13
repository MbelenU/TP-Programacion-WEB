<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['Administrador'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php require __DIR__ . '/../components/header.php'?>
    <script src='<?php echo BASE_URL ?>scripts/admin/editar-perfil.js' defer></script>
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__ . '/../components/admin-navbar.php'; ?>
    <div class="container p-sm-4 bg-white">
        <h2 class="mb-4">Editar perfil</h2>
        <form id="form-perfil">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="profilePhoto" class="form-label">Foto de perfil</label>
                    <div class="mb-3">
                        <img src="<?php echo BASE_URL ?>img/perfil.jpg" class="img-thumbnail" alt="...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="profilePhoto" class="form-label">Foto de perfil</label>
                    <div class="mb-3">
                        <input class="form-control" type="file" id="profilePhoto">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="universityName" class="form-label">Nombre de Universidad</label>
                    <input type="text" class="form-control" id="universityName" placeholder="Nombre de Universidad">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <button type="button" id="btnChangePassword" class="btn btn-secondary">Cambiar contraseña</button>
                </div>
            </div>

            <div id="passwordFields" class="row d-none">
                <div class="col-md-6 mb-3">
                    <label for="oldPassword" class="form-label">Contraseña antigua</label>
                    <input type="password" class="form-control" id="oldPassword" placeholder="Contraseña antigua">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="newPassword" class="form-label">Contraseña nueva</label>
                    <input type="password" class="form-control" id="newPassword" placeholder="Contraseña nueva">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="confirmPassword" class="form-label">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirmar contraseña">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-light border border-dark">Guardar</button>
            </div>
        </form>
    </div>
</body>

</html>