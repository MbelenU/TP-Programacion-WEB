<?php

require_once '../../controllers/AdministradorController.php';



$administradorController = new AdministradorController();
$response = $administradorController->listarUsuarios();
//$response = $administradorController->cambiarClave();



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
    <?php require __DIR__.'/../components/header.php'; ?>
    <style>
        /* Estilo para el botón de registrar usuario */
        .btn-registrar {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-registrar:hover {
            background-color: #0a58ca;
        }

        /* Estilo para la lista de usuarios */
        .user-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .user-item {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr auto;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-info {
            font-size: 14px;
        }

        .user-actions {
            display: flex;
            gap: 10px;
        }

        .btn-success, .btn-danger {
            font-size: 14px;
            padding: 5px 10px;
        }
    </style>
</head>

<body class="bg-inicio p-0">
    <?php require __DIR__.'/../components/admin-navbar.php'; ?>
    <div class="container p-sm-4 bg-white">
        <h1>Gestión de Usuarios</h1>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">Usuarios</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                <div class="mt-4 mb-4">
                    <!-- Botón de registrar usuario -->
                    <button onclick="window.location.href='admin-registro.php'" class="btn-registrar">Registrar Usuario</button>

                    <!-- Lista de usuarios -->
                    <div class="user-list">
                        <?php if (!empty($response)): ?>
                            <?php foreach ($response as $usuario): ?>
                                <div class="user-item">
                                    <div class="user-info"><strong>ID:</strong> <?= htmlspecialchars($usuario['id']) ?></div>
                                    <div class="user-info"><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']) ?></div>
                                    <div class="user-info"><strong>Email:</strong> <?= htmlspecialchars($usuario['mail']) ?></div>
                                    <div class="user-info"><strong>Estado:</strong> <?= ($usuario['de_baja'] === 'N') ? 'Activo' : 'Inactivo' ?></div>
                                    <div class="user-actions">
                                        <button class="btn btn-warning btn-cambiar-pass" type="button" data-id="<?= $usuario['id'] ?>">Cambiar Clave</button>
                                        <button class="btn btn-danger btn-dar-baja" type="button" data-id="<?= $usuario['id'] ?>">Deshabilitar</button>
                                        <button class="btn btn-success btn-habilitar" type="button" data-id="<?= $usuario['id'] ?>">Habilitar</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No se encontraron usuarios.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para cambiar contraseña
        document.querySelectorAll('.btn-cambiar-pass').forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.getAttribute('data-id');
                const newPassword = prompt('Ingresa la nueva contraseña:');
                
                if (newPassword) {
                    fetch('../../controllers/AdministradorController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'cambiarContraseña',
                            userId: userId,
                            newPassword: newPassword
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Contraseña cambiada con éxito.');
                        } else {
                            alert('Error al cambiar la contraseña.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error.');
                    });
                }
            });
        });

        // Función para dar de baja a un usuario
        document.querySelectorAll('.btn-dar-baja').forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.getAttribute('data-id');
                if (confirm('¿Estás seguro de que deseas dar de baja este usuario?')) {
                    fetch('../../controllers/AdministradorController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'darDeBaja',
                            userId: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Usuario dado de baja con éxito.');
                            location.reload();
                        } else {
                            alert('Error al dar de baja el usuario.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error.');
                    });
                }
            });
        });
        document.querySelectorAll('.btn-habilitar').forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.getAttribute('data-id');
                if (confirm('¿Estás seguro de que deseas dar Activar este usuario?')) {
                    fetch('../../controllers/AdministradorController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            action: 'habilitar',
                            userId: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Usuario activado con éxito.');
                            location.reload();
                        } else {
                            alert('Error al activar el usuario.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error.');
                    });
                }
            });
        });
    </script>
</body>

</html>