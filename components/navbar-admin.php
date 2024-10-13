<nav class="navbar sticky-top bg-navbar">
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
            <div class="offcanvas-header bg-navbar">
                <img src="<?php echo BASE_URL ?>img/logo.png" alt="logo">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a href="<?php echo BASE_URL ?>Admin/Perfil-Admin/perfil-admin.html"><img
                                src="<?php echo BASE_URL ?>img/perfil.jpg" alt="foto-perfil"
                                class="rounded-circle w-25 pb-2"></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active" aria-current="page"
                            href="<?php echo BASE_URL ?>Admin/Perfil-Admin/perfil-admin.html">Mi Perfil</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>Admin/Editar-Perfil/editar-perfil-admin.html">Editar Perfil</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo BASE_URL ?>Admin/gestion-usuario-admin.html">Usuarios</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>Admin/Eventos-Admin/eventos-admin.html">Eventos</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>Admin/Notificacion-Admin/pagina-notificaciones.html">Notificaciones</a>
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