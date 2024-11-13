// Planes de estudio por carrera
const planesEstudio = {
    "Desarrollo de Software": ["2016", "2019"],
    "Turismo": ["2016", "2019"],
    "Comercio Internacional": ["2016", "2019"],
    "Gestión Aeroportuaria": ["2016", "2019"],
    "Logistica": ["2016", "2019"],
    "Higiene y Seguridad": ["2016", "2019"]
};

// Materias por carrera y plan de estudios
const materiasPorCarreraYPlan = {
    "Desarrollo de Software": {
        "2016": ["Programación I", "Base de Datos", "Redes", "Matemáticas", "Inglés"],
        "2019": ["Programación II", "Estructuras de Datos", "Sistemas Operativos", "Algoritmos", "Inglés Técnico"]
    },
    // (Se omiten para abreviar, el resto es igual)
};

// Obtener referencias a elementos del DOM
const carreraSelect = document.getElementById('carrera');
const planEstudiosSelect = document.getElementById('planEstudios');
const planEstudiosLabel = document.getElementById('planEstudiosLabel');
const materiaSelect = document.getElementById('materia');
const materiaLabel = document.getElementById('materiaLabel');
const agregarMateriaBtn = document.getElementById('agregarMateria');
const materiasAprobadasList = document.getElementById('materiasAprobadasList');
const habilidadSelect = document.getElementById('habilidad');
const habilidaderror = document.getElementById('habilidaderror');

// Función para manejar el cambio de carrera
function handleCarreraChange() {
    const selectedCarrera = carreraSelect.value;
    resetSelect(planEstudiosSelect, "Seleccione un plan de estudios");
    toggleElement(planEstudiosSelect, !!selectedCarrera);
    toggleElement(planEstudiosLabel, !!selectedCarrera);

    if (selectedCarrera) {
        // Llenar plan de estudios según carrera seleccionada
        planesEstudio[selectedCarrera].forEach(plan => {
            const option = document.createElement('option');
            option.value = plan;
            option.textContent = plan;
            planEstudiosSelect.appendChild(option);
        });
    }
    resetSelect(materiaSelect, "Seleccione una materia", true);
}

// Función para manejar el cambio de plan de estudios
function handlePlanEstudiosChange() {
    const selectedPlan = planEstudiosSelect.value;
    const selectedCarrera = carreraSelect.value;
    resetSelect(materiaSelect, "Seleccione una materia");
    toggleElement(materiaSelect, !!selectedPlan);
    toggleElement(materiaLabel, !!selectedPlan);

    if (selectedPlan && selectedCarrera) {
        materiasPorCarreraYPlan[selectedCarrera][selectedPlan].forEach(materia => {
            const option = document.createElement('option');
            option.value = materia;
            option.textContent = materia;
            materiaSelect.appendChild(option);
        });
        toggleElement(agregarMateriaBtn, true);
    } else {
        toggleElement(agregarMateriaBtn, false);
    }
}

// Agregar una materia aprobada a la lista
function handleAgregarMateria() {
    const selectedMateria = materiaSelect.value;
    if (!selectedMateria || isItemInList(materiasAprobadasList, selectedMateria)) return;

    const listItem = document.createElement('li');
    listItem.textContent = selectedMateria;
    materiasAprobadasList.appendChild(listItem);
    materiaSelect.selectedIndex = 0;
}

// Función para actualizar el campo oculto con las habilidades actuales
function actualizarHabilidadesSeleccionadas() {
    const habilidades = Array.from(listaHabilidades.querySelectorAll('label'))
        .map(label => label.id);
    document.getElementById('habilidadesSeleccionadas').value = JSON.stringify(habilidades);
}

// Modifica `handleAddHabilidad` para que actualice el campo oculto después de agregar una habilidad
function handleAddHabilidad() {
    const habilidadId = habilidadSelect.options[habilidadSelect.selectedIndex]?.value;
    const habilidad = habilidadSelect.options[habilidadSelect.selectedIndex]?.text;
    if (!habilidad) {
        habilidaderror.textContent = "Debe seleccionar alguna habilidad del listado.";
        return;
    }
    habilidaderror.textContent = "";

    if (isItemInList(listaHabilidades, habilidadId, 'label')) {
        habilidaderror.textContent = "Esta habilidad ya ha sido agregada.";
        return;
    }

    const divHabilidad = document.createElement('div');
    divHabilidad.classList.add('my-2', 'p-2', 'border', 'rounded', 'd-inline-block', 'me-2', 'shadow');

    const label = document.createElement('label');
    label.classList.add('d-flex', 'justify-content-center');
    label.textContent = habilidad;
    label.id = habilidadId;
    divHabilidad.appendChild(label);

    const btnEliminar = document.createElement('button');
    btnEliminar.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');
    btnEliminar.innerHTML = '<i class="bi bi-trash"></i> Eliminar';
    btnEliminar.addEventListener('click', () => {
        divHabilidad.remove();
        actualizarHabilidadesSeleccionadas();  // Actualizar la lista al eliminar una habilidad
    });

    divHabilidad.appendChild(btnEliminar);
    listaHabilidades.appendChild(divHabilidad);
    habilidadSelect.selectedIndex = 0;

    // Actualiza el campo oculto después de agregar una nueva habilidad
    actualizarHabilidadesSeleccionadas();
}
// Función para restablecer el contenido de un select
function resetSelect(select, placeholderText, hide = false) {
    select.innerHTML = `<option value="" disabled selected>${placeholderText}</option>`;
    if (hide) toggleElement(select, false);
}

// Función para mostrar u ocultar un elemento
function toggleElement(element, show) {
    element.classList.toggle('d-none', !show);
}

// Verificar si un elemento ya está en la lista
function isItemInList(list, itemText, querySelector = '') {
    return Array.from(list.querySelectorAll(querySelector || 'li')).some(item => item.textContent === itemText);
}

// Eventos
carreraSelect.addEventListener('change', handleCarreraChange);
planEstudiosSelect.addEventListener('change', handlePlanEstudiosChange);
agregarMateriaBtn.addEventListener('click', handleAgregarMateria);
document.getElementById('agregarHabilidad').addEventListener('click', handleAddHabilidad);
