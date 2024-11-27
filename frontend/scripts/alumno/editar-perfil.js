document.addEventListener("DOMContentLoaded", function () {
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
                ${estrellasHTML}
            </div>
            <button type="button" class="btn btn-danger btn-sm eliminarHabilidad">Eliminar</button>
        `;

        // Añadir evento al botón "Eliminar"
        nuevaHabilidad.querySelector(".eliminarHabilidad").addEventListener("click", function () {
            nuevaHabilidad.remove();
            actualizarHabilidadesSeleccionadas();
        });

        // Agregar al DOM
        listaHabilidades.appendChild(nuevaHabilidad);

        // Actualizar el campo hidden
        actualizarHabilidadesSeleccionadas();
    });

    // Delegar evento "Eliminar" para elementos ya renderizados
    listaHabilidades.addEventListener("click", (event) => {
        if (event.target.classList.contains("eliminarHabilidad")) {
            event.target.closest(".habilidad-item").remove();
            actualizarHabilidadesSeleccionadas();
        }
    });

    // Agregar evento click a las estrellas
    document.querySelectorAll(".stars .star").forEach(star => {
        star.addEventListener("click", function () {
            const habilidadId = this.getAttribute("data-id");
            const nivel = this.getAttribute("data-value");

            // Actualizar visualmente las estrellas
            const starsContainer = this.parentElement;
            starsContainer.querySelectorAll(".star").forEach(s => {
                s.classList.remove("bi-star-fill");
                s.classList.add("bi-star");
                if (s.getAttribute("data-value") <= nivel) {
                    s.classList.remove("bi-star");
                    s.classList.add("bi-star-fill");
                }
            });

            // Enviar nivel al servidor con AJAX
            fetch("<?= BASE_URL ?>alumno/actualizarNivelHabilidad", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: habilidadId, nivel: nivel })
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert("Error al actualizar el nivel. Intente nuevamente.");
                    }
                })
                .catch(() => alert("Error de conexión con el servidor."));
        });
    });

    // Actualizar el valor del campo hidden con los IDs de las habilidades
    function actualizarHabilidadesSeleccionadas() {
        const habilidadIds = Array.from(listaHabilidades.querySelectorAll(".habilidad-item"))
            .map(item => item.dataset.id);
        habilidadesSeleccionadas.value = habilidadIds.join(",");
    }
});
