<?php require_once __DIR__ . '/../includes/base-url.php' ?>
<nav class="navbar sticky-top bg-navbar p-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="<?php echo BASE_URL ?>img/logo.png" alt="logo"></a>

        <button class="navbar-toggler shadow-sm" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header bg-navbar py-2">
                <img src="<?php echo BASE_URL ?>img/logo.png" alt="logo">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL ?>views/alumno-perfil.php"><img
                                src="<?php echo BASE_URL ?>img/perfil.jpg" alt="foto-perfil"
                                class="rounded-circle w-25 pb-2"></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active" aria-current="page"
                            href="<?php echo BASE_URL ?>views/alumno-perfil.php">Mi Perfil</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo BASE_URL ?>views/alumno-editar-perfil.php">Editar Perfil</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo BASE_URL ?>views/alumno-eventos.php">Eventos</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo BASE_URL ?>views/alumno-empleos.php">Empleos</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo BASE_URL ?>views/alumno-solicitudes.php">Solicitudes</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/alumno-notificaciones.php">Notificaciones</a>
                    </li>
                    <li class="nav-item align-self-center d-flex ">
                        <a href="<?php echo BASE_URL ?>views/logout.php">
                            <button type="button" class="btn btn-outline-danger"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</button>
                        </a>
                    </li>
                </ul>
                <form class="d-flex d-sm-none mt-3" role="search">
                    <input class="form-control me-2 border-success-subtle" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success d-grid align-content-center" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>