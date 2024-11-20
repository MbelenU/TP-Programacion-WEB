document.addEventListener('DOMContentLoaded', function () {
    const buscarButton = document.getElementById('buscarBoton');
    const buscarInput = document.getElementById('buscarInput');

    // Función para mostrar u ocultar los detalles del empleo
    function toggleEmpleoDetails(event) {
        const empleoDetails = event.target.closest('li').querySelector('.empleo-details');
        if (empleoDetails) {
            empleoDetails.classList.toggle('d-none');
        }
    }

    // Manejo del evento de búsqueda
    buscarButton.addEventListener('click', function (event) {
        event.preventDefault();

        const query = buscarInput.value.trim();
        let url = 'http://localhost/TP-Programacion-WEB/controllers/AlumnoController.php?buscarEmpleos=';

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

                if (data.body && data.body.length > 0) {
                    data.body.forEach(empleo => {
                        const empleoLi = document.createElement('li');
                        empleoLi.classList.add('list-group-item', 'list-group-item-action', 'bg-white', 'border');
                        empleoLi.innerHTML = `
                            <div class="w-100 justify-content-between">
                                <button class="toggleButton btn border-0 w-100 d-flex flex-column text-start">
                                    <h5 class="mb-1">
                                        <div class="titulo-empleo">${empleo.titulo}</div>
                                    </h5>
                                    <p class="mb-1">${empleo.descripcion}</p>
                                    <small>${empleo.ubicacion}</small>
                                    <div class="mt-4">
                                        ${empleo.estadoEmpleo.estado}
                                    </div>
                                </button>
                            </div>
                            <div class="empleo-details d-none">
                                <div class="mt-4">
                                    <strong>Habilidades Necesarias:</strong>
                                    <ul>
                                        ${empleo.habilidades.map(habilidad => `<li>${habilidad}</li>`).join('')}
                                    </ul>
                                </div>

                                <div class="mt-4">
                                    <strong>Disponibilidad Horaria:</strong>
                                    <ul>
                                        ${empleo.jornada.descripcion ? `<li>${empleo.jornada.descripcion}</li>` : '<li>No disponible</li>'}
                                    </ul>
                                </div>

                                <div class="mt-4">
                                    <strong>Modalidad:</strong>
                                    <ul>
                                        ${empleo.modalidad.descripcion ? `<li>${empleo.modalidad.descripcion}</li>` : '<li>No disponible</li>'}
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="d-flex align-items-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Acciones de empleo">
                                        <button type="button" class="btn btn-success btn-sm aplicar-empleo" data-empleo-id="${empleo.id}">Aplicar</button>
                                    </div>
                                </div>
                            </div>
                        `;

                        const toggleButton = empleoLi.querySelector('.toggleButton');
                        toggleButton.addEventListener('click', toggleEmpleoDetails);

                        checkPostulacion(empleo.id).then(data => {
                            console.log('Respuesta de checkPostulacion:', data);

                            const aplicarButton = empleoLi.querySelector('.aplicar-empleo');
                            if (data) {
                                aplicarButton.disabled = true;
                                aplicarButton.innerText = "Postulado";
                            } else {
                                aplicarButton.disabled = false;
                                aplicarButton.innerText = "Aplicar";
                            }
                        }).catch(error => {
                            console.error('Error al verificar la postulación:', error);
                            const aplicarButton = empleoLi.querySelector('.aplicar-empleo');
                            aplicarButton.disabled = false;
                            aplicarButton.innerText = "Aplicar";
                        });

                        resultadosContainer.appendChild(empleoLi);
                    });
                } else {
                    resultadosContainer.innerHTML = '<p>No se encontraron resultados.</p>';
                }
            })
            .catch(error => {
                console.error('Error en la solicitud Fetch:', error);
            });
    });

    async function checkPostulacion(empleoId) {
        try {
            const response = await fetch('http://localhost/TP-Programacion-WEB/controllers/AlumnoController.php?checkPostulacion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ empleoId })
            });

            const data = await response.json();
            return data; 
        } catch (error) {
            console.error('Error al verificar la postulación:', error);
            return { success: false, postulado: false }; 
        }
    }
});
