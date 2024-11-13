<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['Empresa'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/global.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>frontend/css/empresa.css">
</head>


<body class="bg-inicio">
    <?php require __DIR__ . '/../components/empresa-navbar.php' ?>
   
    <div class="container p-sm-4 bg-secondary-subtle">
        <div class="container mt-5">
            <div class="perfil-header">
                <img src="../Nav-bar/perfil.jpg" alt="Foto de perfil" id="foto-perfil">
                <div class="info">
                    <div class="nombre">
                        <h1>Gregorio Costa</h1>
                    </div>
                    <div class="descripcion">
                        <p>Breve descripción.</p>
                    </div>
                    <button href="#" class="btn btn-outline-success">Descargar CV</a>
                </div>
            </div>
            <div class="contact-info">
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

            <div>
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
    </div>
</body>

</html>