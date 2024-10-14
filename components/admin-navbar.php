<?php require_once __DIR__ . '/../includes/base-url.php' ?>
<nav class="navbar sticky-top bg-navbar p-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="<?php echo BASE_URL ?>img/logo.png" alt="logo"></a>
        <!-- Buscador -->
        <form class="d-none d-sm-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search " aria-label="Search">
            <button class="btn btn-outline-success d-grid align-content-center" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
        <!--Menú-->
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
                        <a href="<?php echo BASE_URL ?>views/admin-perfil.php"><img
                                src="<?php echo BASE_URL ?>img/perfil.jpg" alt="foto-perfil"
                                class="rounded-circle w-25 pb-2"></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active" aria-current="page"
                            href="<?php echo BASE_URL ?>views/admin-perfil.php">Mi Perfil</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/admin-editar-perfil.php">Editar Perfil</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo BASE_URL ?>views/admin-gestionar-usuarios.php">Usuarios</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/admin-eventos.php">Eventos</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/admin-notificaciones.php">Notificaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" 
                            href="<?php echo BASE_URL ?>views/admin-visualizar-carreras.php">Carreras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/admin-visualizar-habilidades.php">Habilidades</a>
                    </li>
                </ul>
                <form class="d-flex d-sm-none mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success d-grid align-content-center" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>