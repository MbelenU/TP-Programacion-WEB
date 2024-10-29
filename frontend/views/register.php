<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>Registro</title>
</head>

<body class="bg-light bg-alt">
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-md-6 mx-auto p-4 w-auto rounded-5 shadow bg-navbar">
                <div class="text-center mb-3 p-3">
                    <img src="../img/logo.png" alt="logo" class="img-fluid">
                </div>
                <h2 class="text-center mb-4">Solicitud de Registro</h2>
                <div class="mb-3 input-group">
                    <label for="tipoUsuario" class="input-group-text">Tipo de usuario</label>
                    <select id="tipoUsuario" class="form-select rounded-end">
                        <option value="" disabled selected hidden>Seleccione una opción...</option>
                        <option value="alumno">Alumno</option>
                        <option value="empresa">Empresa</option>
                    </select>
                </div>

                <!-- Formulario Alumno -->
                <form id="formAlumno" class="d-none" novalidate>
                    <h4>Registro de Usuario</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" name="dni" id="dni" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombreUsuario" class="form-label">Nombre usuario</label>
                            <input type="text" name="nombreUsuario" id="nombreUsuario" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="repeatPassword" class="form-label">Repetir Contraseña</label>
                            <input type="password" name="repeatPassword" id="repeatPassword" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" name="telefono" id="telefono" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
                </form>

                <!-- Formulario Empresa -->
                <form id="formEmpresa" class="d-none" novalidate>
                    <h4>Registro de Empresa</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombreUsuarioEmpresa" class="form-label">Nombre de Usuario</label>
                            <input type="text" id="nombreUsuarioEmpresa" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombreEmpresa" class="form-label">Nombre de la Empresa</label>
                            <input type="text" id="nombreEmpresa" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="emailEmpresa" class="form-label">Email Corporativo</label>
                            <input type="email" id="emailEmpresa" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="passwordEmpresa" class="form-label">Contraseña</label>
                            <input type="password" id="passwordEmpresa" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="repeatPasswordEmpresa" class="form-label">Repetir Contraseña</label>
                            <input type="password" id="repeatPasswordEmpresa" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="direccionEmpresa" class="form-label">Dirección</label>
                            <input type="text" id="direccionEmpresa" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefonoEmpresa" class="form-label">Teléfono Corporativo</label>
                            <input type="text" id="telefonoEmpresa" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="RazonSocial" class="form-label">Razón Social</label>
                            <input type="text" id="RazonSocial" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="CUIT" class="form-label">CUIT</label>
                        <input type="text" id="CUIT" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success" id="modalHeader">
                    <h5 class="modal-title text-white" id="confirmationModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="modalButton"
                        data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/register.js"></script>
</body>

</html>