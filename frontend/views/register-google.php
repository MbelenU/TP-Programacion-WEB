<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__ . "/../components/header.php" ?>
</head>

<body class="bg-light bg-alt">
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-md-6 mx-auto p-4 w-auto rounded-5 shadow bg-navbar">
                <div class="text-center mb-3 p-3">
                    <img src="<?php echo BASE_URL ?>img/logo.png" alt="logo" class="img-fluid">
                </div>
                <h2 class="text-center mb-4">Solicitud de Registro</h2>
                <div class="bg-light rounded">
                    <nav>
                        <div class="nav nav-tabs row-cols-2" id="nav-tab" role="tablist">
                            <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true"><i class="bi bi-person-circle"></i> Alumno</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                aria-selected="false"><i class="bi bi-building"></i> Empresa</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                            tabindex="0">
                            <div class="pt-4 pb-4 bg-white rounded-bottom">
                                <h5 class="px-2">Formulario para Alumnos</h5>
                                <!-- Colocar Formulario para alumnos -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                            tabindex="0">
                            <div class="pt-4 pb-4 bg-white rounded-bottom ">
                                <h5 class="px-2">Formulario para Empresas</h5>
                                <!-- Colocar Formulario para Empresas -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>