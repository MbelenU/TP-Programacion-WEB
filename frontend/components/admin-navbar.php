<?php 
require_once __DIR__ . '/../includes/base-url.php';
$foto_perfil = $_SESSION['user']['foto_perfil'];
?>
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
                        <a href="<?php echo BASE_URL ?>views/admin-perfil.php"><img src="<?php echo $foto_perfil ? BASE_URL . 'img/' . $foto_perfil : BASE_URL . 'img/perfil.jpg'; ?>" alt="foto-perfil" class="rounded-circle m-2" style="width: 120px; height: 120px; object-fit: cover; margin-right: 20px;" id="foto-perfil-navbar"></a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo BASE_URL ?>views/admin-gestionar-usuarios.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL ?>views/empresa-publicar-empleo.php">Publicar
                                empleo</a>
                        </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL ?>views/empresa-visualizar-publicaciones.php">Publicaciones
                            </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/admin-eventos.php">Eventos</a>
                    </li>
                    <!--
                    <li class="nav-item ">
                        <a class="nav-link"
                            href="<?/*php echo BASE_URL */?>views/admin-notificaciones.php">Notificaciones</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/admin-visualizar-carreras.php">Carreras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/admin-gestionar-habilidades.php">Habilidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?php echo BASE_URL ?>views/admin-notificaciones.php">Notificaciones</a>
                    </li>
                    <li class="nav-item align-self-center d-flex ">
                        <a href="<?php echo BASE_URL ?>views/logout.php">
                            <button type="button" class="btn btn-outline-danger"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>