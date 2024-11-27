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
            const habilidadId = event.target.closest(".habilidad-item").dataset.id;
            const elementoHabilidad = event.target.closest(".habilidad-item");
            eliminarHabilidad(habilidadId, elementoHabilidad, alumnoId);  // Pasar el alumnoId también
        }
    });

    // Función para eliminar habilidad
    function eliminarHabilidad(habilidadId, elementoHabilidad, alumnoId) {
        // Enviar AJAX para eliminar la habilidad
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
            if (data.success) {
                // Si la habilidad fue eliminada con éxito, eliminarla del DOM
                if (elementoHabilidad) {
                    elementoHabilidad.remove();
                }
                actualizarHabilidadesSeleccionadas();
            } else {
                alert("Error al eliminar la habilidad. Intente nuevamente.");
            }
        })
        .catch(() => alert("Error de conexión con el servidor."));
    }

    // Actualizar el valor del campo hidden con los IDs de las habilidades
    function actualizarHabilidadesSeleccionadas() {
        const habilidadIds = Array.from(listaHabilidades.querySelectorAll(".habilidad-item"))
            .map(item => item.dataset.id);
        habilidadesSeleccionadas.value = habilidadIds.join(",");
    }
});
