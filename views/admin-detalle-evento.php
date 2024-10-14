<!DOCTYPE html>
<html lang="es">

<head>
    <?php require __DIR__ . '/../components/header.php' ?>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/admin-detalle-evento.css">
</head>

<body class="p-0 bg-inicio">
    <?php require __DIR__ . '/../components/admin-navbar.php' ?>
    <div class="container p-sm-4 bg-secondary-subtle">
        <section class="container">
            <div class="titulo-header">
                <h1>Evento</h1>
            </div>
            <a href="<?php echo BASE_URL ?>views/admin-eventos.php" class="btn btn-outline-success btn-reporte"><i class="bi bi-arrow-left">
                    VOLVER</i></a>
            <div class="container-background p-5">
                <div class="puesto-header mb-5 d-flex justify-content-between">
                    <div class="puesto-content">
                        <h2 class="">Explorando la Deep Web: entre mitos y realidades</h2>
                        <div class="mt-4">
                            <i class="bi bi-calendar3"><strong> Fecha:</strong> 23/10/2024 18 hs. </i>
                        </div>
                        <div class="mt-4">
                            <strong>Descripción:</strong>
                            <p>Te invitamos a participar de la charla "Explorando la Deep Web: entre mitos y
                                realidades", donde profesores especializados nos guiarán para desmitificar la Deep Web y
                                entender qué es realmente</p>
                        </div>
                        <div class="mt-4">
                            <strong>Modalidad:</strong>
                            <p>Virtual</p>
                        </div>
                        <div class="mt-4">
                            <strong>Créditos:</strong>
                            <p>0.5</dpiv>
                        </div>

                    </div>
                    <div class="button-container">
                        <a href="<?php echo BASE_URL ?>views/admin-editar-evento.php" class="btn btn-outline-success btn-reporte">EDITAR
                            EVENTO</a>
                        <button type="button" class="btn btn-outline-success btn-reporte">ELIMINAR EVENTO</button>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item disabled bg-secondary-subtle" aria-disabled="true">Inscriptos</li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>Laura Martínez</span>
                            </div>
                            <div class="btn-group" role="group" aria-label="Estado del evento">
                                <button type="button" class="btn btn-success btn-sm btn-anular">Anular</button>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>Carlos Pérez</span>
                            </div>
                            <div class="btn-group" role="group" aria-label="Estado del evento">
                                <button type="button" class="btn btn-success btn-sm btn-anular">Anular</button>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>Sofía González</span>
                            </div>
                            <div class="btn-group" role="group" aria-label="Estado del evento">
                                <button type="button" class="btn btn-success btn-sm btn-anular">Anular</button>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>Andrés Jiménez</span>
                            </div>
                            <div class="btn-group" role="group" aria-label="Estado del evento">
                                <button type="button" class="btn btn-success btn-sm btn-anular">Anular</button>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span>Valeria Ruiz</span>
                            </div>
                            <div class="btn-group" role="group" aria-label="Estado del evento">
                                <button type="button" class="btn btn-success btn-sm btn-anular">Anular</button>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
        </section>
    </div>
</body>

</html>