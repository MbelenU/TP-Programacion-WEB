document.addEventListener("DOMContentLoaded", () => {
    const tableBody = document.getElementById("tableBody");
    const searchInput = document.getElementById("searchInput");
    const newSkillInput = document.getElementById("newSkillInput");
    const addSkillButton = document.getElementById("addSkillButton");

    const loadHabilidades = async () => {
        try {
            const response = await fetch("AdministradorController.php?action=getAllHabilidades");
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
                    <button class="btn btn-danger btn-sm" onclick="deleteHabilidad(${habilidad.id})">Eliminar</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    };

    const buscarHabilidad = async () => {
        try {
            const query = searchInput.value;
            const response = await fetch(`AdministradorController.php?action=searchHabilidad&query=${query}`);
            const habilidades = await response.json();
            renderHabilidades(habilidades);
        } catch (error) {
            console.error("Error al buscar habilidad:", error);
        }
    };

    const agregarHabilidad = async () => {
        try {
            const descripcion = newSkillInput.value;
            if (!descripcion) return alert("Por favor, ingrese una habilidad.");

            const response = await fetch("AdministradorController.php?action=addHabilidad", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ descripcion }),
            });

            const result = await response.json();
            if (result.success) {
                newSkillInput.value = "";
                loadHabilidades();
            } else {
                alert("Error al agregar habilidad.");
            }
        } catch (error) {
            console.error("Error al agregar habilidad:", error);
        }
    };
    const deleteHabilidad = async (id) => {
        try {
            const response = await fetch(`AdministradorController.php?action=deleteHabilidad&id=${id}`, {
                method: "DELETE",
            });
            const result = await response.json();
            if (result.success) {
                loadHabilidades();
            } else {
                alert("Error al eliminar habilidad.");
            }
        } catch (error) {
            console.error("Error al eliminar habilidad:", error);
        }
    };

    addSkillButton.addEventListener("click", agregarHabilidad);
    document.getElementById("searchButton").addEventListener("click", buscarHabilidad);

    loadHabilidades();
});