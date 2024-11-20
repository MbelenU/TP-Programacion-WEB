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
                
                <!-- Botón para volver a la vista "admin-gestionar-usuarios.php" -->
                <div class="mb-3">
                    <a href="admin-gestionar-usuarios.php" class="btn btn-secondary w-100">Volver a Gestionar Usuarios</a>
                </div>

                <!-- Contenedores para mostrar mensajes -->
                <div id="errorAlert" class="alert alert-danger d-none" role="alert"></div>
                <div id="successAlert" class="alert alert-success d-none" role="alert"></div>
                
                <div class="mb-3 input-group">
                    <label for="tipoUsuario" class="input-group-text">Tipo de usuario</label>
                    <select id="tipoUsuario" class="form-select rounded-end">
                        <option value="" disabled selected hidden>Seleccione una opción...</option>
                        <option value="2">Alumno</option>
                        <option value="3">Empresa</option>
                    </select>
                </div>

                <!-- Formulario Alumno -->
                <form id="formAlumno" class="d-none" novalidate>
                    <h4>Registro de Alumno</h4>
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
                            <label for="nombreUsuario" class="form-label">Nombre Usuario</label>
                            <input type="text" name="nombreUsuario" id="nombreUsuario" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="clave" class="form-label">Contraseña</label>
                            <input type="password" name="clave" id="clave" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
                </form>

                <!-- Formulario Empresa -->
                <form id="formEmpresa" class="d-none" novalidate>
                    <h4>Registro de Empresa</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombreUsuarioEmpresa" class="form-label">Nombre Usuario</label>
                            <input type="text" name="nombreUsuario" id="nombreUsuarioEmpresa" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="razonSocial" class="form-label">Razón Social</label>
                            <input type="text" name="razonSocial" id="razonSocial" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="emailEmpresa" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="clave" class="form-label">Contraseña</label>
                            <input type="password" name="clave" id="claveEmpresa" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="CUIT" class="form-label">CUIT</label>
                        <input type="text" name="CUIT" id="CUIT" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../scripts/registro.js"></script>
</body>

</html>