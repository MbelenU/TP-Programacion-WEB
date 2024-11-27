document.addEventListener('DOMContentLoaded', function () {
    function asignarEventosBotones() {

        document.querySelectorAll('.btn-cambiar-pass').forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.getAttribute('data-id');
                const newPassword = prompt('Ingresa la nueva contraseña:');

                if (newPassword) {
                    fetch('/TP-Programacion-WEB/controllers/AdministradorController.php?action=cambiarContrasena', {
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

        document.querySelectorAll('.btn-dar-baja').forEach(button => {
            button.addEventListener('click', () => {
                const userId = button.getAttribute('data-id');
                if (confirm('¿Estás seguro de que deseas dar de baja este usuario?')) {
                    fetch('/TP-Programacion-WEB/controllers/AdministradorController.php?action=darDeBaja', {
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
                if (confirm('¿Estás seguro de que deseas activar este usuario?')) {
                    fetch('/TP-Programacion-WEB/controllers/AdministradorController.php?action=habilitar', {
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
    }

    asignarEventosBotones();

    const buscarButton = document.getElementById('buscarUsuarios');
    const buscarInput = document.getElementById('buscarInput');

    buscarButton.addEventListener('click', function (event) {
        event.preventDefault();
        const query = buscarInput.value.trim();
        let url = '/TP-Programacion-WEB/controllers/AdministradorController.php?buscarUsuarios=';

        if (query !== '') {
            url += encodeURIComponent(query);
        }

        fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                const resultadosContainer = document.getElementById('resultadosBusqueda');
                resultadosContainer.innerHTML = '';
                if (data.success) {
                    data.body.forEach(usuario => {
                        const usuarioDiv = document.createElement('div');
                        usuarioDiv.classList.add('user-item');

                        usuarioDiv.innerHTML = `
                            <div class="user-info"><strong>ID:</strong> ${usuario.id}</div>
                            <div class="user-info"><strong>Nombre:</strong> ${usuario.nombre}</div>
                            <div class="user-info"><strong>Email:</strong> ${usuario.email}</div>
                            <div class="user-info"><strong>Estado:</strong> ${usuario.estado === 'N' ? 'Activo' : 'Inactivo'}</div>
                            <div class="user-actions">
                                <button class="btn btn-warning btn-cambiar-pass" type="button" data-id="${usuario.id}">Cambiar Clave</button>
                                <button class="btn btn-danger btn-dar-baja" type="button" data-id="${usuario.id}">Deshabilitar</button>
                                <button class="btn btn-success btn-habilitar" type="button" data-id="${usuario.id}">Habilitar</button>
                            </div>
                        `;

                        resultadosContainer.appendChild(usuarioDiv);
                    });

                    asignarEventosBotones();
                } else {
                    resultadosContainer.innerHTML = '<p>No se encontraron resultados.</p>';
                }
            })
            .catch(error => {
                console.error('Error en la solicitud Fetch:', error);
            });
    });
});
