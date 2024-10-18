<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/alumno-empleos.css">
    <script src="<?php echo BASE_URL ?>scripts/alumno/empleos.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="row mb-3">
            <h1>Empleos</h1>
            <form class="filtro d-flex" role="search">
                <input class="form-control me-2" type="search" id="form-control"
                    placeholder="Rubro | Nombre del empleo | Disponibilidad horaria | Ubicación | Modalidad"
                    aria-label="Search">
                <button class="botonFiltro btn btn-light border border-success-subtle" type="submit">Filtrar</button>
            </form>
        </div>
        <div class="container-empleo bg-navbar border border-success-subtle">
            <div class="empleo-item mb-6">
                <div class="row px-2">
                    <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                        <div class="titulo-empleo">Programador Frontend</div>
                        <i class="bi bi-geo-alt">San Isidro, Zona Norte BS AS</i>
                        <i class="arrowIcon fas fa-chevron-left "></i>
                    </button>
                </div>
                <div class="empleo-details d-none">
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
                    <div class="vstack col-md-5 mx-auto">
                        <button class="btn btn-light mt-3 border border-success-subtle">Enviar Solicitud</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-empleo bg-navbar border border-success-subtle">
            <div class="empleo-item mb-6">
                <div class="row px-2">
                    <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                        <div class="titulo-empleo">Programador de Base de Datos</div>
                        <i class="bi bi-geo-alt">Ezeiza, Bs As, Argentina</i>
                        <i class="arrowIcon fas fa-chevron-left "></i>
                    </button>
                </div>
                <div class="empleo-details d-none">
                    <div>
                        <strong>Descripción:</strong>
                        <p>Buscamos un nuevo miembro para nuestro equipo, con conocimientos en bases de datos
                            relacionales</p>
                    </div>
                    <div class="mt-4">
                        <strong>Materias Necesarias:</strong>
                        <ul>
                            <li>Bases de datos I</li>
                            <li>Bases de datos II</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <strong>Habilidades Necesarias:</strong>
                        <ul>
                            <li>SQL</li>
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
                            <li>Full Remoto</li>
                        </ul>
                    </div>
                    <div class="vstack col-md-5 mx-auto">
                        <button class="btn btn-light mt-3 border border-success-subtle">Enviar Solicitud</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-empleo bg-navbar border border-success-subtle">
            <div class="empleo-item mb-6">
                <div class="row px-2">
                    <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                        <div class="titulo-empleo">Desarrollador Fullstack</div>
                        <i class="bi bi-geo-alt">Parque Patricios, CABA</i>
                        <i class="arrowIcon fas fa-chevron-left "></i>
                    </button>
                </div>
                <div class="empleo-details d-none">
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
                    <div class="vstack col-md-5 mx-auto">
                        <button class="btn btn-light mt-3 border border-success-subtle">Enviar Solicitud</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>