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
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php'?>
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="row">
            <div class="col-md-3">
                <img src="<?php echo BASE_URL?>img/perfil.jpg" alt="foto-perfil" class="rounded-circle w-50">
            </div>
            <div class="col-md-9">
                <h1 class="h3">Universidad Provincial de Ezeiza</h1>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <p><i class="bi bi-geo-alt"></i> Ezeiza, Barrio Uno</p>
                <p><i class="bi bi-envelope"></i> hola@upe.com</p>
                <a href="<?php echo BASE_URL ?>views/admin-publicar-evento.php"><button class="btn btn-outline-success">Publicar
                        evento</button></a>
            </div>
        </div>

        <div class="row mt-4">
            <h2 class="mt-4">Eventos</h2>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="event-card bg-success text-white rounded d-flex justify-content-center align-items-center"
                            style="height: 200px;">
                            <span class="edit-icon">
                                <i class="bi bi-pencil" style="font-size: 1.5rem;"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="event-card bg-success text-white rounded d-flex justify-content-center align-items-center"
                            style="height: 200px;">
                            <span class="edit-icon">
                                <i class="bi bi-pencil" style="font-size: 1.5rem;"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="event-card bg-success text-white rounded d-flex justify-content-center align-items-center"
                            style="height: 200px;">
                            <span class="edit-icon">
                                <i class="bi bi-pencil" style="font-size: 1.5rem;"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="event-card bg-success text-white rounded d-flex justify-content-center align-items-center"
                            style="height: 200px;">
                            <span class="edit-icon">
                                <i class="bi bi-pencil" style="font-size: 1.5rem;"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>