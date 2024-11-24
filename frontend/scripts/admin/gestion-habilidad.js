document.addEventListener("DOMContentLoaded", () => {
    const tableBody = document.getElementById("tableBody");
    const searchInput = document.getElementById("searchInput");
    const newSkillInput = document.getElementById("newSkillInput");
    const addSkillButton = document.getElementById("addSkillButton");
    const searchButton = document.getElementById("searchButton");

    // Cargar habilidades desde el servidor
    const loadHabilidades = async () => {
        try {
            const response = await fetch("/TP-Programacion-WEB/controllers/AdministradorController.php?action=getAllHabilidades");
            const habilidades = await response.json();
            renderHabilidades(habilidades);
        } catch (error) {
            console.error("Error al cargar habilidades:", error);
        }
    };

    // Renderizar habilidades en la tabla
    const renderHabilidades = (habilidades) => {
        tableBody.innerHTML = ""; // Limpiar la tabla
        habilidades.forEach((habilidad) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${habilidad.descripcion}</td>
                <td>
                    <button class="btn btn-danger btn-sm btnEliminar" data-id="${habilidad.id}">Eliminar</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    };

    // Buscar habilidades por descripción
    const buscarHabilidad = async () => {
        try {
            const query = searchInput.value.trim();
            const response = await fetch(`/TP-Programacion-WEB/controllers/AdministradorController.php?action=searchHabilidad&query=${encodeURIComponent(query)}`);
            const habilidades = await response.json();
            renderHabilidades(habilidades);
        } catch (error) {
            console.error("Error al buscar habilidad:", error);
        }
    };

    // Agregar una nueva habilidad
    const agregarHabilidad = async () => {
        try {
            const descripcion = newSkillInput.value.trim();
            if (!descripcion) {
                alert("Por favor, ingrese una habilidad.");
                return;
            }

            const response = await fetch("/TP-Programacion-WEB/controllers/AdministradorController.php?action=addHabilidad", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ descripcion }),
            });

            const result = await response.json();
            if (result.success) {
                alert("Habilidad agregada con éxito.");
                newSkillInput.value = ""; // Limpiar el campo de entrada
                loadHabilidades(); // Recargar la tabla
            } else {
                alert(result.message || "Error al agregar habilidad.");
            }
        } catch (error) {
            console.error("Error al agregar habilidad:", error);
        }
    };

    // Eliminar una habilidad
    const eliminarHabilidad = async (id) => {
        try {
            const response = await fetch(`/TP-Programacion-WEB/controllers/AdministradorController.php?action=deleteHabilidad&id=${id}`, {
                method: "DELETE",
            });

            const result = await response.json();
            if (result.success) {
                alert("Habilidad eliminada con éxito.");
                loadHabilidades(); // Recargar la tabla
            } else {
                alert(result.message || "Error al eliminar habilidad.");
            }
        } catch (error) {
            console.error("Error al eliminar habilidad:", error);
        }
    };

    // Delegación de eventos para manejar clicks en los botones "Eliminar"
    tableBody.addEventListener("click", (event) => {
        if (event.target.classList.contains("btnEliminar")) {
            const id = event.target.getAttribute("data-id");
            if (confirm("¿Estás seguro de que deseas eliminar esta habilidad?")) {
                eliminarHabilidad(id);
            }
        }
    });

    // Eventos de botones
    addSkillButton.addEventListener("click", agregarHabilidad);
    searchButton.addEventListener("click", buscarHabilidad);

    // Cargar habilidades al cargar la página
    loadHabilidades();
});