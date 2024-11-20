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
        nuevaHabilidad.className = "habilidad-item d-flex align-items-center justify-content-between bg-light p-2 rounded mb-2";
        nuevaHabilidad.dataset.id = habilidadId;

        nuevaHabilidad.innerHTML = `
            <span class="habilidad-nombre">${habilidadNombre}</span>
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

    // Actualizar el valor del campo hidden con los IDs de las habilidades
    function actualizarHabilidadesSeleccionadas() {
        const habilidadIds = Array.from(listaHabilidades.querySelectorAll(".habilidad-item"))
            .map(item => item.dataset.id);
        habilidadesSeleccionadas.value = habilidadIds.join(",");
    }
});
