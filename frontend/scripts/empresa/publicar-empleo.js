const tituloInput = document.getElementById('titulo');
const ubicacion = document.getElementById('ubicacion');
const descripcion = document.getElementById('descripcion');

const jornadaSelect = document.getElementById('jornada');
const modalidadSelect = document.getElementById('modalidad');
const carreraSelect = document.getElementById('carrera');
const planEstudiosSelect = document.getElementById('planEstudios');
const planEstudiosLabel = document.getElementById('planEstudiosLabel');
const materiaSelect = document.getElementById('materia');
const materiaLabel = document.getElementById('materiaLabel');
const agregarMateriaBtn = document.getElementById('agregarMateria');
const materiasAprobadasList = document.getElementById('materiasAprobadasList');
const habilidadInput = document.getElementById('habilidad');
const habilidaderror = document.getElementById('habilidaderror');
const carreraerror = document.getElementById('carreraerror');
const planerror = document.getElementById('planerror');
const listaHabilidades = document.getElementById('listaHabilidades');
const agregarHabilidadBtn = document.getElementById('agregarHabilidad');
const publicarForm = document.getElementById('publicarForm')
const guardarPublicacion = document.getElementById('guardarPublicacion')

document.addEventListener('DOMContentLoaded', async function() {
    let response = await cargarModalidades()
    response = await cargarJornadas()
    response = await cargarCarreras()
    guardarPublicacion.addEventListener('click', async function (event) {
        event.preventDefault();
        let habilidades = listaHabilidades.querySelectorAll('li')
        habilidades = Array.from(habilidades).map(habilidad => habilidad.value)
        
        let materias = materiasAprobadasList.querySelectorAll('li')
        materias = Array.from(materias).map(materia => materia.value)
        const publicacionData = {
                titulo: tituloInput.value,
                modalidad: modalidadSelect.value,
                ubicacion: ubicacion.value,
                jornada: jornadaSelect.value,
                descripcion: descripcion.value,
                habilidades: habilidades,
                materias: materias
        }
        let response = await fetch(`http://localhost:80/TP-Programacion-WEB/controllers/EmpresaController.php?publicarEmpleo`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(publicacionData)
        });
        response = await response.json();
        if(response.success) {
            window.location.href = `http://localhost:80/TP-Programacion-WEB/frontend/views/empresa-visualizar-publicacion.php?id=${response.body}`;
 
        }else {
            //logica en caso de que falle publicar empleo
        }
        console.log(response)
    });
})

async function agregarHabilidad() {
    let habilidadText = habilidadInput.value;
    habilidadText = habilidadText.toLowerCase()

    let habilidades = listaHabilidades.querySelectorAll('li')
    habilidades = Array.from(habilidades).map(habilidad => habilidad.textContent.toLowerCase())

    if (!habilidadText || habilidades.includes(habilidadText)) {
        return; 
    }
    const response = await fetch(`http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?habilidad=${habilidadText}`)
    if(!response.ok) {
        throw new Error(`Errors: ${response.status}`)
    }
    const json = await response.json()
    if(json.success){
        const option = document.createElement('li');
        option.textContent = json.body.nombreHabilidad
        option.value = json.body.id
        const deleteIcon = document.createElement('i');
        deleteIcon.classList.add('fas', 'fa-trash', 'ms-2'); 
        deleteIcon.id = 'borrarHabilidad';
        deleteIcon.style.cursor = 'pointer';
    
        deleteIcon.addEventListener('click', function() {
            option.remove();
        });
    
        option.appendChild(deleteIcon);
        option.classList.add('bg-secondary', 'text-white', 'p-2', 'rounded','d-inline-block')
        listaHabilidades.appendChild(option)
    }
}
function carreraChange() {

    planEstudiosSelect.innerHTML = '';
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.textContent = 'Seleccione un plan de estudios';
    planEstudiosSelect.appendChild(defaultOption);

    const selectedCarrera = carreraSelect.value;
    materiaSelect.classList.add('d-none');
    agregarMateriaBtn.classList.add('d-none');

    if (selectedCarrera) {
        cargarPlanesEstudio(selectedCarrera)
        planEstudiosSelect.classList.remove('d-none');
        planEstudiosLabel.classList.remove('d-none');
    } else {
        planEstudiosSelect.classList.add('d-none');
        planEstudiosLabel.classList.add('d-none');
    }
}
function planEstudioChange() {
    materiaSelect.innerHTML = '';
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    defaultOption.textContent = 'Seleccione una materia';
    materiaSelect.appendChild(defaultOption);

    const selectedPlan = planEstudiosSelect.value;
    agregarMateriaBtn.classList.add('d-none');

    if (selectedPlan) {
        cargarMaterias(selectedPlan)
        materiaSelect.classList.remove('d-none');
        materiaLabel.classList.remove('d-none');
        agregarMateriaBtn.classList.remove('d-none');
    } else {
        materiaSelect.classList.add('d-none');
        materiaLabel.classList.add('d-none');
    }
}
async function cargarModalidades() {
    let response = await fetch('http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?modalidades')
    response = await response.json()
    response.body.forEach(option => {
        const newOption = document.createElement('option')
        newOption.value = option.id
        newOption.textContent = option.descripcionModalidad
        modalidadSelect.appendChild(newOption)
    });
    return response 
}
async function cargarJornadas() {
    let response = await fetch('http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?jornadas')
    response = await response.json()
    response.body.forEach(option => {
        const newOption = document.createElement('option')
        newOption.value = option.id
        newOption.textContent = option.descripcionJornada
        jornadaSelect.appendChild(newOption)
    });
    return response 
}
async function cargarMaterias(idPlanEstudio) {
    let response = await fetch(`http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?idPlanEstudio=${idPlanEstudio}`)
    response = await response.json()
    let planEstudio = response.body
    planEstudio.forEach(materia => {
        const newOption = document.createElement('option')
        newOption.value = materia.id
        newOption.textContent = materia.nombreMateria
        materiaSelect.appendChild(newOption)
    });
}
async function cargarPlanesEstudio(idCarrera) {
    let response = await fetch(`http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?id_carrera=${idCarrera}`)
    response = await response.json()
    let planesEstudio = response.body
    const select = document.getElementById('planEstudios')
    planesEstudio.forEach(planEstudio => {
        const newOption = document.createElement('option')
        newOption.value = planEstudio.id
        newOption.textContent = planEstudio.nombrePlanEstudio
        select.appendChild(newOption)
    });
}
async function cargarCarreras() {
    const select = document.getElementById('carrera');
    let response = await fetch('http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?carreras')
    response = await response.json()
    carreras = response.body
    carreras.forEach(async carrera => {
        const newOption = document.createElement('option')
        newOption.value = carrera.id
        newOption.textContent = carrera.nombreCarrera
        select.appendChild(newOption)
    });
    return response 
}
function agregarMateria() {
    let materias = materiasAprobadasList.querySelectorAll('li');
    materias = Array.from(materias).map(materia => materia.textContent);

    const selectedOption = materiaSelect.options[materiaSelect.selectedIndex];

    if (!materiaSelect || selectedOption.value === "" || materias.includes(selectedOption.textContent)) {
        return; 
    }

    const textMateria = document.createElement('li');
    textMateria.classList.add('bg-secondary', 'text-white', 'p-2', 'rounded', 'm-2', 'd-flex', 'justify-content-between', 'align-items-center'); 
    textMateria.textContent = selectedOption.textContent;
    textMateria.value = selectedOption.value;
    const deleteIcon = document.createElement('i');
    deleteIcon.classList.add('fas', 'fa-trash', 'ms-2'); 
    deleteIcon.id = 'borrarMateria';
    deleteIcon.style.cursor = 'pointer';

    deleteIcon.addEventListener('click', function() {
        textMateria.remove();
    });

    textMateria.appendChild(deleteIcon);
    materiasAprobadasList.appendChild(textMateria);

    materiaSelect.selectedIndex = 0; // Resetear el select al valor por defecto
}

carreraSelect.addEventListener('change', carreraChange);
planEstudiosSelect.addEventListener('change', planEstudioChange);
document.getElementById('agregarMateria').addEventListener('click', agregarMateria);
agregarHabilidadBtn.addEventListener('click', agregarHabilidad);