document.addEventListener("DOMContentLoaded", () => {
    const tableBody = document.getElementById("tableBody");
    const searchInput = document.getElementById("searchInput");
    const newSkillInput = document.getElementById("newSkillInput");
    const addSkillButton = document.getElementById("addSkillButton");
    const searchButton = document.getElementById("searchButton");

    const loadHabilidades = async () => {
        try {
            const response = await fetch("/TP-Programacion-WEB/controllers/AdministradorController.php?action=getAllHabilidades");
            const habilidades = await response.json();
            renderHabilidades(habilidades);
        } catch (error) {
            console.error("Error al cargar habilidades:", error);
        }
    };

    const renderHabilidades = (habilidades) => {
        tableBody.innerHTML = ""; 
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

            console.log(result)
            if (result.success) {
                newSkillInput.value = "";
                loadHabilidades(); 
            } else {
                alert(result.message || "Error al agregar habilidad.");
            }
        } catch (error) {
            console.error("Error al agregar habilidad:", error);
        }
    };
    const eliminarHabilidad = async (id) => {
        try {
            const response = await fetch(`/TP-Programacion-WEB/controllers/AdministradorController.php?action=deleteHabilidad&id=${id}`, {
                method: "DELETE",
            });

            const result = await response.json();
            if (result.success) {
                loadHabilidades(); 
            } else {
                alert(result.message || "Error al eliminar habilidad.");
            }
        } catch (error) {
            console.error("Error al eliminar habilidad:", error);
        }
    };

    tableBody.addEventListener("click", (event) => {
        if (event.target.classList.contains("btnEliminar")) {
            const id = event.target.getAttribute("data-id");
            eliminarHabilidad(id);

        }
    });

    addSkillButton.addEventListener("click", agregarHabilidad);
    searchButton.addEventListener("click", buscarHabilidad);

    loadHabilidades();
});