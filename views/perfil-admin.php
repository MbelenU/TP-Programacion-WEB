<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php'?>
    <title>Perfil</title>
</head>

<body class="container-fluid min-vh-100 p-0 bg-inicio">
    <?php require __DIR__ . '/../components/navbar-admin.php' ?>
    <div class="container p-sm-4 bg-secondary-subtle">
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
                <a href="<?php echo BASE_URL ?>Admin/Evento/publicar.php"><button class="btn btn-outline-success">Publicar
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