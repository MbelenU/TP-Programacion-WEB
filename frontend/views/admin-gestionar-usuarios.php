<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ./inicio.php");
    exit();
}
$allowedRoles = ['1'];
if (!in_array($_SESSION['user']['user_type'], $allowedRoles)) {
    echo "Acceso denegado. No tienes permisos para acceder a esta página.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require __DIR__.'/../components/header.php';?>
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__.'/../components/admin-navbar.php';?>
    <div class="container p-sm-4 bg-white">
        <h1>Gestión de Usuarios</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Usuarios</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Dar de alta</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <div class="mt-4 mb-4">
                    <h5>Buscar Usuarios</h5>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search"
                            placeholder="Buscar por nombre, email o tipo de usuario" aria-label="Buscar">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                    <div class="mt-4 table-responsive-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Tipo de Usuario</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Juan Pérez</td>
                                    <td>juan@example.com</td>
                                    <td>Alumno</td>
                                    <td>Activo</td>
                                    <td>
                                        <div class="d-grid gap-1">
                                            <button class="btn btn-success badge" type="button">Cambiar
                                                Contraseña</button>
                                            <button class="btn btn-warning badge" type="button">Bloquar</button>
                                            <button class="btn btn-danger badge" type="button">Dar de Baja</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                <div class="mt-4">
                    <h5>Dar de Alta Usuario</h5>
                    <form>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Usuario</label>
                            <select class="form-control" id="tipo" required>
                                <option value="Alumno">Alumno</option>
                                <option value="Empresa">Empresa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Dar de Alta</button>
                        </div>

                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                ...</div>
        </div>
    </div>
</body>

</html>