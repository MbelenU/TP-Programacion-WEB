<nav class="navbar sticky-top bg-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="/img/logo.png" alt="logo"></a>
        <!-- Buscador -->
        <form class="d-none d-sm-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search " aria-label="Search">
            <button class="btn btn-outline-success d-grid align-content-center" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search"
                    viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </button>
        </form>
        <!--Menú-->
        <button class="navbar-toggler shadow-sm" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <img src="/img/logo.png" alt="logo">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a href="/Admin/Perfil-Admin/perfil-admin.html"><img src="/img/perfil.jpg" alt="foto-perfil"
                                class="rounded-circle w-25"></a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link active" aria-current="page" href="/Admin/Perfil-Admin/perfil-admin.html">Mi
                            Perfil</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link" href="/Admin/Editar-Perfil/editar-perfil-admin.html">Editar Perfil</a>
                    </li>
                    <li class="nav-item p-1">
                        <a class="nav-link" href="/Admin/gestion-usuario-admin.html">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Admin/Eventos-Admin/eventos-admin.html">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="/Admin/Notificacion-Admin/pagina-notificaciones.html">Notificaciones</a>
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