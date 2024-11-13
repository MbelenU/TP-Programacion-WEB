<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['Alumno'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/alumno-perfil.css">

</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container bg-white">
        <div class="row px-4 pb-3  ">
            <div class="col p-3 ">
                <div class="row row-cols-md-2 ">
                    <div class="col-md-2 d-flex justify-content-center align-items-center d-md-block">
                        <img src="<?php echo BASE_URL ?>img/perfil.jpg" alt="Foto de perfil" id="foto-perfil">
                    </div>
                    <div class="col-md-10">
                        <div class="row row-cols-1">
                            <div class="col">
                                <h1>Gregorio Costa</h1>
                            </div>
                            <div class="col">
                                <p>Breve descripción.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-4 pb-3">
            <div class="container bg-navbar rounded-3 p-3 ">
                <div class="row row-cols-md-2 row-gap-2 ">
                    <div class="">
                        <span>
                            <i class="bi bi-geo-alt"></i> Ezeiza, Barrio Uno
                        </span>
                    </div>
                    <div class="">
                        <span>
                            <i class="bi bi-phone"></i> 1123456789
                        </span>
                    </div>
                    <div class="">
                        <span>
                            <i class="bi bi-book"></i> Tecnicatura en Desarrollo de Software
                        </span>
                    </div>
                    <div class="">
                        <span>
                            <i class="bi bi-envelope"></i> gcosta@email.com
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-sm-flex px-4 pb-4 justify-content-between gap-3">
            <div class="bg-navbar rounded-3 col-md p-3">
                <h4>Habilidades</h4>
                <ul>
                    <li>
                        <span class="stars">
                            HTML
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star"></i>
                            <i class="star bi bi-star"></i>
                        </span>
                    </li>
                    <li>
                        <span class="stars">
                            CSS
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star"></i>
                        </span>
                    </li>
                    <li>
                        <span class="stars">
                            JAVASCRIPT
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star"></i>
                            <i class="star bi bi-star"></i>
                            <i class="star bi bi-star"></i>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="bg-navbar rounded-3 col-md p-3">
                <h4>Avance Académico</h4>
                <ul>
                    <li>
                        <span>PROGRAMACIÓN WEB</span>
                    </li>
                    <li>
                        <span>BASE DE DATOS I</span>
                    </li>
                    <li>
                        <span>BASE DE DATOS II</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>