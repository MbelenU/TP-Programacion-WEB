<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/alumno-eventos.css">
    <script src="<?php echo BASE_URL ?>scripts/alumno/eventos.js" defer></script>
</head>

<body class="bg-inicio">
    <?php require __DIR__ . '/../components/alumno-navbar.php' ?>
    <div class="container p-sm-4 bg-white">
        <div class="row mb-2">
            <div class="">
                <h1>Eventos</h1>
            </div>
            <form class="filtro d-flex mb-sm-3" role="search">
                <input class="form-control me-2 border-success-subtle" type="search" id="form-control"
                    placeholder="Carreras | Nombre del evento | Fecha | Ubicación | Modalidad" aria-label="Search">
                <button class="botonFiltro btn btn-light border border-success-subtle " type="submit">Filtrar</button>
            </form>
        </div>
        <div class="row mb-2">
            <div class="container-evento bg-navbar border border-success-subtle">
                <div class="evento-item mb-6">
                    <div class="row px-2">
                        <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                            <div class="evento-titulo">Explorando la Deep Web: entre mitos y realidades</div>
                            <i class="arrowIcon fas fa-chevron-left "></i>
                        </button>
                    </div>
                    <div class="evento-details d-none">
                        <div>
                            <i class="bi bi-calendar3"></i>
                            <strong>Fecha:</strong>
                            <ul>
                                <li>19/09/2024</li>
                                <li>19 hs.</li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <p><strong>Descripción:</strong></p>
                            <p>
                                Te invitamos a participar de la charla "Explorando la Deep Web: entre mitos y
                                realidades", donde profesores especializados nos guiarán para desmitificar la Deep Web y
                                entender qué es realmente
                            </p>
                        </div>
                        <div class="mt-4">
                            <strong>Modalidad:</strong>
                            <div>Virtual</div>
                        </div>
                        <div class="mt-4">
                            <strong>Créditos:</strong>
                            <div>0.5</div>
                        </div>
                        <div class="vstack gap-0 col-md-5 mx-auto">
                            <button class="btn btn-success mt-3">SUSCRIBIRME</button>
                            <button class="btn btn-danger mt-3">DESUSCRIBIRME</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10 mx-auto">
                <hr>
            </div>
            <div class="container-evento  bg-navbar border border-success-subtle">
                <div class="evento-item mb-6">
                    <div class="row px-2">
                        <button class="toggleButton btn border-0 d-flex justify-content-between align-items-center w-100">
                            <div class="evento-titulo">Taller - Lenguaje de señas</div>
                            <i class="arrowIcon fas fa-chevron-left "></i>
                        </button>
                    </div>
                    <div class="evento-details d-none">
                        <div>
                            <i class="bi bi-calendar3"></i>
                            <strong>Fecha:</strong>
                            <ul>
                                <li>23/11/2024</li>
                                <li>18 hs.</li>
                            </ul>
                        </div>
                        <div class="mt-4">
                            <strong>Descripción:</strong>
                            <div>No arancelado. Se verá una breve introducción al lenguaje de señas.</div>
                        </div>
                        <div class="mt-4">
                            <strong>Modalidad:</strong>
                            <div>Virtual</div>
                        </div>
                        <div class="mt-4">
                            <strong>Créditos:</strong>
                            <div>1.0</div>
                        </div>
                        <div class="vstack gap-0 col-md-5 mx-auto">
                            <button class="btn btn-success mt-3">SUSCRIBIRME</button>
                            <button class="btn btn-danger mt-3">DESUSCRIBIRME</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>