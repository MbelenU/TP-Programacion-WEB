document.addEventListener("DOMContentLoaded", function () {
    const alumnoId = document.getElementById("alumnoId").getAttribute("data-id");  // Obtener el idAlumno de HTML

    const agregarBtn = document.getElementById("agregarHabilidad");
    const selectHabilidad = document.getElementById("habilidad");
    const listaHabilidades = document.getElementById("listaHabilidades");
    const habilidadesSeleccionadas = document.getElementById("habilidadesSeleccionadas");

    // Agregar habilidad seleccionada
    agregarBtn.addEventListener("click", () => {
        const habilidadId = selectHabilidad.value;
        const habilidadNombre = selectHabilidad.options[selectHabilidad.selectedIndex].text;

        if (!habilidadId || habilidadId === "") {
            alert("Por favor, selecciona una habilidad válida.");
            return;
        }

        // Verificar si ya existe
        const existe = Array.from(listaHabilidades.querySelectorAll(".habilidad-item"))
            .some(item => item.dataset.id === habilidadId);

        if (existe) {
            alert("La habilidad ya está en la lista.");
            return;
        }

        // Crear un nuevo elemento de habilidad
        const nuevaHabilidad = document.createElement("div");
        nuevaHabilidad.className = "habilidad-item d-grid align-items-center justify-content-start bg-light p-2 rounded mb-2";
        nuevaHabilidad.dataset.id = habilidadId;

        // Crear las estrellas dinámicamente
        let estrellasHTML = '';
        for (let i = 1; i <= 5; i++) {
            estrellasHTML += `
                <i class="star bi ${i <= 0 ? 'bi-star-fill' : 'bi-star'}" 
                   data-value="${i}"
                   data-id="${habilidadId}">
                </i>`;
        }

        nuevaHabilidad.innerHTML = `
            <span class="habilidad-nombre fw-bold text-center">${habilidadNombre}</span>
            <div class="stars" data-id="${habilidadId}">
            </div>
            <button type="button" class="btn btn-danger btn-sm eliminarHabilidad">Eliminar</button>
        `;

        // Añadir evento al botón "Eliminar"
        nuevaHabilidad.querySelector(".eliminarHabilidad").addEventListener("click", function () {
            eliminarHabilidad(habilidadId, nuevaHabilidad, alumnoId);  // Pasar el alumnoId también
        });

        // Agregar al DOM
        listaHabilidades.appendChild(nuevaHabilidad);

        // Actualizar el campo hidden
        actualizarHabilidadesSeleccionadas();
    });

    // Delegar evento "Eliminar" para elementos ya renderizados
    listaHabilidades.addEventListener("click", (event) => {
        if (event.target.classList.contains("eliminarHabilidad")) {
            const elementoHabilidad = event.target.closest(".habilidad-item");
            const habilidadId = elementoHabilidad.dataset.id;

            // Llamar a la función para eliminar la habilidad en el servidor
            eliminarHabilidad(habilidadId, alumnoId);

            // Remover del DOM después de eliminar
            elementoHabilidad.remove();

            // Actualizar las habilidades seleccionadas
            actualizarHabilidadesSeleccionadas();
        }
    });

    // Función para agregar habilidad
    function agregarHabilidad(habilidadId, alumnoId) {
        // Obtener el nivel de habilidad (número de estrellas llenas)
        const habilidadItem = document.querySelector(`.habilidad-item[data-id="${habilidadId}"]`);
        const nivelHabilidad = habilidadItem.querySelectorAll('.bi-star-fill').length; // Contar las estrellas llenas

        // Enviar AJAX para agregar la habilidad con el nivel de habilidad
        fetch(`http://localhost/TP-Programacion-WEB/controllers/AlumnoController.php?agregarHabilidad=`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                idAlumno: alumnoId,
                idHabilidad: habilidadId
            })
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert("Error al agregar la habilidad. Intente nuevamente.");
                }
            })
            .catch(() => alert("Error de conexión con el servidor."));
    }

    // Función para eliminar habilidad
    function agregarHabilidad(habilidadId, alumnoId) {
        // Obtener el nivel de habilidad (número de estrellas llenas)
        const habilidadItem = document.querySelector(`.habilidad-item[data-id="${habilidadId}"]`);
        const nivelHabilidad = habilidadItem.querySelectorAll('.bi-star-fill').length; // Contar las estrellas llenas
    
        // Enviar AJAX para agregar la habilidad con el nivel de habilidad
        fetch(`http://localhost/TP-Programacion-WEB/controllers/AlumnoController.php?agregarHabilidad=`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                idAlumno: alumnoId,
                idHabilidad: habilidadId,
                nivelHabilidad: nivelHabilidad  // Enviar el nivel de habilidad (incluido 0)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert("Error al agregar la habilidad. Intente nuevamente.");
            }
        })
        .catch((error) => {
            // Solo mostrar el mensaje de error si el nivel de habilidad no es 0
            if (nivelHabilidad !== 0) {
                alert("Error de conexión con el servidor.");
            }
            // Si el nivel es 0, no mostrar el error
        });
    }

    // Función para calificar habilidad (marcar estrellas)
    function calificarHabilidad(star, habilidadId) {
        const habilidadItem = document.querySelector(`.habilidad-item[data-id="${habilidadId}"]`);
        const estrellas = habilidadItem.querySelectorAll('.star');
        const nivel = star.dataset.value;

        // Cambiar el estado de las estrellas
        estrellas.forEach(est => {
            if (parseInt(est.dataset.value) <= nivel) {
                est.classList.add('bi-star-fill');
                est.classList.remove('bi-star');
            } else {
                est.classList.add('bi-star');
                est.classList.remove('bi-star-fill');
            }
        });

        // Actualizar el valor de habilidades seleccionadas
        actualizarHabilidadesSeleccionadas();
    }

    // Actualizar el valor del campo hidden con los IDs de las habilidades y sus niveles
    function actualizarHabilidadesSeleccionadas() {
        const habilidadesSeleccionadasData = [];
        document.querySelectorAll(".habilidad-item").forEach(item => {
            const habilidadId = item.dataset.id;
            const nivelGrado = item.querySelectorAll('.bi-star-fill').length; // Contar las estrellas llenas
            habilidadesSeleccionadasData.push({
                id_habilidad: habilidadId,
                nivel_grado: nivelGrado
            });
        });

    }
});

// Función para eliminar habilidad
function eliminarHabilidad(habilidadId, alumnoId) {
    fetch(`http://localhost/TP-Programacion-WEB/controllers/AlumnoController.php?eliminarHabilidad=`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            idAlumno: alumnoId,
            idHabilidad: habilidadId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert("Error al eliminar la habilidad. Intente nuevamente.");
        }
    })
    .catch(() => alert("Error de conexión con el servidor."));
}