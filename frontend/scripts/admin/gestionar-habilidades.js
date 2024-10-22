let habilidades = [
    { nombre: "JavaScript" },
    { nombre: "Python" },
    { nombre: "Java" },
    { nombre: "React" },
    { nombre: "Node.js" },
];

function renderizarHabilidades(habilidadesFiltradas) {
    const cuerpoTabla = document.getElementById('tableBody');
    cuerpoTabla.innerHTML = '';

    (habilidadesFiltradas || habilidades).forEach(habilidad => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${habilidad.nombre}</td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="eliminarHabilidad('${habilidad.nombre}')">Borrar</button>
            </td>
        `;
        cuerpoTabla.appendChild(fila);
    });
}

function agregarHabilidad() {
    const nuevoInputHabilidad = document.getElementById('newSkillInput');
    const nombreHabilidad = nuevoInputHabilidad.value.trim();

    if (nombreHabilidad) {
        habilidades.push({ nombre: nombreHabilidad });
        nuevoInputHabilidad.value = ''; 
        renderizarHabilidades();
    } else {
        alert("Por favor ingresa una habilidad.");
    }
}

function eliminarHabilidad(nombre) {
    habilidades = habilidades.filter(habilidad => habilidad.nombre !== nombre);
    renderizarHabilidades();
}

function buscarHabilidad() {
    const inputBusqueda = document.getElementById('searchInput').value.toLowerCase();
    const habilidadesFiltradas = habilidades.filter(habilidad => habilidad.nombre.toLowerCase().includes(inputBusqueda));
    renderizarHabilidades(habilidadesFiltradas);
}

document.getElementById('addSkillButton').addEventListener('click', agregarHabilidad);

renderizarHabilidades();