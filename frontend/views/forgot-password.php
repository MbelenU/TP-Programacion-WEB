<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="resetPasswordModalLabel">Restablecer Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reset-password-form" method="POST" action="../controllers/UsuarioController.php?action=resetPassword">
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
    // JavaScript para mostrar el modal si el correo es válido
    document.querySelector('#forgot-password-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.querySelector('#email').value;

        fetch('../controllers/UsuarioController.php?action=verifyEmail', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `email=${email}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector('#emailInput').value = email;
                const modal = new bootstrap.Modal(document.querySelector('#resetPasswordModal'));
                modal.show();
            } else {
                alert(data.message);
            }
        });
    });
</script>
