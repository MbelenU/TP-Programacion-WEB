<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/global.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <title>Recuperar Contraseña</title>
</head>
<body class="bg-dark bg-alt ">
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center shadow">
        <div class="col-md-4 bg-navbar rounded-5 p-4 bg-opacity-75 w-auto">
            <div class="text-center mb-3 p-3">
                <img src="../img/logo.png" alt="logo" class="img-fluid">
            </div>
            <h2 class="text-center mb-4">Recuperar Contraseña</h2>
            <form id="forgot-password-form" novalidate>
                <div class="mb-3 input-group">
                    <label for="email" class="input-group-text">Ingrese su email</label>
                    <input type="email" id="email" class="form-control" placeholder="Ej: usuario@gmail.com" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Reestablecer contraseña</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para ingresar nueva contraseña -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Restablecer Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reset-password-form">
                    <div class="modal-body">
                        <input type="hidden" id="emailInput" name="email">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva Contraseña</label>
                            <input type="password" id="newPassword" name="newPassword" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Enviar email para verificación
        document.querySelector('#forgot-password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.querySelector('#email').value; // Captura el valor del email ingresado

            fetch('http://localhost/TP-Programacion-WEB/controllers/UsuarioController.php?action=verifyEmail', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `mail=${email}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('#emailInput').value = email; // Asigna el correo al campo oculto
                    const modal = new bootstrap.Modal(document.querySelector('#resetPasswordModal'));
                    modal.show(); // Muestra el modal para ingresar la nueva contraseña
                } else {
                    alert(data.message); // Muestra el mensaje de error si el correo no es válido
                }
            })
            .catch(error => {
                alert('Error al verificar el correo: ' + error.message);
            });
        });

        // Enviar nueva contraseña
        document.querySelector('#reset-password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.querySelector('#emailInput').value; // Obtiene el correo del campo oculto
            const newPassword = document.querySelector('#newPassword').value;
            const confirmPassword = document.querySelector('#confirmPassword').value;

            if (newPassword !== confirmPassword) {
                alert('Las contraseñas no coinciden.');
                return;
            }

            fetch('http://localhost/TP-Programacion-WEB/controllers/UsuarioController.php?action=resetPassword', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `mail=${email}&newPassword=${newPassword}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Contraseña actualizada correctamente.');
                    window.location.href = 'inicio.php'; // Redirige al usuario a la página de login
                } else {
                    alert(data.message); // Muestra un mensaje de error si la actualización falla
                }
            })
            .catch(error => {
                alert('Error al actualizar la contraseña: ' + error.message);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>