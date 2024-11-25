// Función para cambiar contraseña
document.querySelectorAll('.btn-cambiar-pass').forEach(button => {
    button.addEventListener('click', () => {
        const userId = button.getAttribute('data-id');
        const newPassword = prompt('Ingresa la nueva contraseña:');
        
        if (newPassword) {
            fetch('../../controllers/AdministradorController.php/action=cambiarContrasena', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
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
            fetch('../../controllers/AdministradorController.php/action=darDeBaja', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
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

// Función para habilitar un usuario
document.querySelectorAll('.btn-habilitar').forEach(button => {
    button.addEventListener('click', () => {
        const userId = button.getAttribute('data-id');
        if (confirm('¿Estás seguro de que deseas activar este usuario?')) {
            fetch('../../controllers/AdministradorController.php/action=habilitar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
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