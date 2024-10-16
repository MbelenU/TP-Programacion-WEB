<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php'?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/alumno-perfil.css">

</head>

<body>
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container mt-5">
        <div class="perfil-header">
            <img src="<?php echo BASE_URL ?>img/perfil.jpg" alt="Foto de perfil" id="foto-perfil">
            <div class="info">
                <div class="nombre">
                    <h1>Gregorio Costa</h1>
                </div>
                <div class="descripcion">
                    <p>Breve descripción.</p>
                </div>
            </div>
        </div>
        <div class="contact-info d-sm-flex">
            <div class="info-item mb-6">
                <i class="bi bi-geo-alt"></i>
                <span>Ezeiza, Barrio Uno</span>
            </div>
            <div class="info-item mb-6">
                <i class="bi bi-phone"></i>
                <span>1123456789</span>
            </div>
            <div class="info-item mb-6">
                <i class="bi bi-book"></i>
                <span>Tecnicatura en Desarrollo de Software</span>
            </div>
            <div class="info-item mb-6">
                <i class="bi bi-envelope"></i>
                <span>gcosta@email.com</span>
            </div>
        </div>

        <div class="profile-sections">
            <section class="habilidades mb-3">
                <h2>Habilidades</h2>
                <ul>
                    <li>
                        HTML
                        <span class="stars">
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star"></i>
                            <i class="star bi bi-star"></i>
                        </span>
                    </li>
                    <li>
                        CSS
                        <span class="stars">
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star"></i>
                        </span>
                    </li>
                    <li>
                        JAVASCRIPT
                        <span class="stars">
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star-fill"></i>
                            <i class="star bi bi-star"></i>
                            <i class="star bi bi-star"></i>
                            <i class="star bi bi-star"></i>
                        </span>
                    </li>
                </ul>
            </section>
            <div class="right-sections">
                <section class="experiencia mb-3">
                    <h2>Avance Académico</h2>
                    <li>PROGRAMACIÓN WEB</li>
                    <li>BASE DE DATOS I</li>
                    <li>BASE DE DATOS II</li>
                </section>
            </div>
        </div>
    </div>

</body>

</html>