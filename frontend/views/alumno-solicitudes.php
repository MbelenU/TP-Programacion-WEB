<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <script src="<?php echo BASE_URL ?>scripts/alumno/solicitudes.js" defer></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/alumno-solicitudes.css">
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-4 bg-white">
        <div class="row">
            <div class="col">
                <h1>Mis solicitudes</h1>
            </div>
        </div>
        <div class="container-solic border border-success-subtle">
            <div class="solic-item">
                <div class="row px-2">
                    <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                        <div class="col">
                            <div class="titulo-solic">Programador Frontend</div>
                            <i class="bi bi-geo-alt"> San Isidro, Zona Norte BS AS</i>
                        </div>
                        <div class="estado-empleo">En proceso</div>
                        <i class="arrowIcon fas fa-chevron-left "></i>
                    </button>
                </div>
                <div class="solicitud-details d-none">
                    <div>
                        <strong>Descripción:</strong>
                        <p>Buscamos un programador frontend para sumarse a nuestro equipo.</p>
                    </div>
                    <div class="mt-4">
                        <strong>Materias Necesarias:</strong>
                        <ul>
                            <li>Programación Web</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <strong>Habilidades Necesarias:</strong>
                        <ul>
                            <li>HTML</li>
                            <li>CSS</li>
                            <li>Javascript</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <strong>Disponibilidad Horaria:</strong>
                        <ul>
                            <li>Part-time</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <strong>Modalidad:</strong>
                        <ul>
                            <li>Presencial en nuestras oficinas de San Isidro.</li>
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center align-items-center ">
                        <button class="btn btn-outline-danger mt-3 d-flex justify-content-center align-items-center">
                            DAR DE BAJA <i class="bi bi-person-fill-down fs-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-solic border border-success-subtle">
            <div class="solic-item">
                <div class="row px-2">
                    <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                        <div class="col">
                            <div class="titulo-solic">Desarrollador Fullstack</div>
                            <i class="bi bi-geo-alt">Parque Patricios, CABA</i>
                        </div>
                        <div class="estado-empleo">Recibido</div>
                        <i class="arrowIcon fas fa-chevron-left "></i>
                    </button>
                </div>
                <div class="solicitud-details d-none">
                    <div>
                        <strong>Descripción:</strong>
                        <p>Para uno de nuestros clientes estamos buscando un/a desarrollador/a Jr Fullstack, con
                            experiencia y conocimientos en Javascript, NodeJS o .Net para desarrollar software Backend y
                            Frontend</p>
                    </div>
                    <div class="mt-4">
                        <strong>Materias Necesarias:</strong>
                        <ul>
                            <li>Programación WEB</li>
                            <li>Bases de datos I</li>
                            <li>Bases de datos II</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <strong>Habilidades Necesarias:</strong>
                        <ul>
                            <li>HTML</li>
                            <li>CSS</li>
                            <li>Javascript, NodeJS o .Net</li>
                            <li>SQL</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <strong>Disponibilidad Horaria:</strong>
                        <ul>
                            <li>Full-time</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <strong>Modalidad:</strong>
                        <ul>
                            <li>Híbrida (2 días presenciales en Parque Patricios / 3 días home office)</li>
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center align-items-center ">
                        <button class="btn btn-outline-danger mt-3 d-flex justify-content-center align-items-center">
                            DAR DE BAJA <i class="bi bi-person-fill-down fs-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>