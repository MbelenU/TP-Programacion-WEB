// planes de estudio por carrera
const planesEstudio = {
    "Desarrollo de Software": ["2016", "2019"],
    "Turismo": ["2016", "2019"],
    "Comercio Internacional": ["2016", "2019"],
    "Gestión Aeroportuaria": ["2016", "2019"],
    "Logistica": ["2016", "2019"],
    "Higiene y Seguridad": ["2016", "2019"]
};

// materias por carrera y plan de estudios
const materiasPorCarreraYPlan = {
    "Desarrollo de Software": {
        "2016": ["Programación I", "Base de Datos", "Redes", "Matemáticas", "Inglés"],
        "2019": ["Programación II", "Estructuras de Datos", "Sistemas Operativos", "Algoritmos", "Inglés Técnico"]
    },
    "Turismo": {
        "2016": ["Gestión Hotelera", "Agencias de Viajes", "Turismo Sostenible", "Inglés", "Geografía"],
        "2019": ["Gestión de Destinos", "Marketing Turístico", "Inglés Técnico", "Ecoturismo", "Planificación Turística"]
    },
    "Comercio Internacional": {
        "2016": ["Logística Internacional", "Comercio Exterior", "Finanzas Internacionales", "Inglés", "Derecho Internacional"],
        "2019": ["Negocios Internacionales", "Marketing Internacional", "Inglés Técnico", "Gestión de Proyectos", "Finanzas Globales"]
    },
    "Gestión Aeroportuaria": {
        "2016": ["Operaciones Aeroportuarias", "Seguridad Aeronáutica", "Mantenimiento de Aeronaves", "Inglés", "Logística Aérea"],
        "2019": ["Gestión de Aeropuertos", "Administración de Aerolíneas", "Inglés Técnico", "Marketing Aeroportuario", "Seguridad Aérea"]
    },
    "Logistica": {
        "2016": ["Gestión de la Cadena de Suministro", "Transporte y Distribución", "Inglés", "Costos Logísticos", "Almacenamiento"],
        "2019": ["Gestión de Operaciones", "Estrategias Logísticas", "Inglés Técnico", "Análisis de Datos Logísticos", "Gestión de Proyectos Logísticos"]
    },
    "Higiene y Seguridad": {
        "2016": ["Seguridad Industrial", "Gestión de Riesgos", "Inglés", "Normativas de Seguridad", "Ergonomía"],
        "2019": ["Prevención de Riesgos", "Gestión Ambiental", "Inglés Técnico", "Auditoría de Seguridad", "Planificación de Emergencias"]
    }
};


const carreraSelect = document.getElementById('carrera');
const planEstudiosSelect = document.getElementById('planEstudios');
const planEstudiosLabel = document.getElementById('planEstudiosLabel');
const materiaSelect = document.getElementById('materia');
const materiaLabel = document.getElementById('materiaLabel');
const agregarMateriaBtn = document.getElementById('agregarMateria');
const materiasAprobadasList = document.getElementById('materiasAprobadasList');
const habilidadSelect = document.getElementById('habilidad');
const habilidaderror = document.getElementById('habilidaderror');
const carreraerror = document.getElementById('carreraerror');
const planerror = document.getElementById('planerror');
const listaHabilidades = document.getElementById('listaHabilidades');


function handleCarreraChange() {
    const selectedCarrera = carreraSelect.value;
    planEstudiosSelect.innerHTML = '<option value="" disabled selected>Seleccione un plan de estudios</option>';
    materiaSelect.classList.add('d-none');
    agregarMateriaBtn.classList.add('d-none');

    if (selectedCarrera) {

        planEstudiosSelect.classList.remove('d-none');
        planEstudiosLabel.classList.remove('d-none');


        planesEstudio[selectedCarrera].forEach(function (plan) {
            const option = document.createElement('option');
            option.value = plan;
            option.textContent = plan;
            planEstudiosSelect.appendChild(option);
        });
    } else {
        planEstudiosSelect.classList.add('d-none');
        planEstudiosLabel.classList.add('d-none');
    }
}


function handlePlanEstudiosChange() {
    const selectedPlan = planEstudiosSelect.value;
    materiaSelect.innerHTML = '<option value="" disabled selected>Seleccione una materia</option>';
    agregarMateriaBtn.classList.add('d-none');

    if (selectedPlan) {

        const selectedCarrera = carreraSelect.value;


        materiaSelect.classList.remove('d-none');
        materiaLabel.classList.remove('d-none');


        if (selectedCarrera && materiasPorCarreraYPlan[selectedCarrera][selectedPlan]) {
            materiasPorCarreraYPlan[selectedCarrera][selectedPlan].forEach(function (materia) {
                const option = document.createElement('option');
                option.value = materia;
                option.textContent = materia;
                materiaSelect.appendChild(option);
            });

            agregarMateriaBtn.classList.remove('d-none');
        }
    } else {
        materiaSelect.classList.add('d-none');
        materiaLabel.classList.add('d-none');
    }
}

// agregar una materia aprobada
function handleAgregarMateria() {
    const selectedMateria = materiaSelect.value;
    let materias = materiasAprobadasList.querySelectorAll('li');
    materias = Array.from(materias).map(materia => materia.textContent);
    if (!selectedMateria || materias.includes(selectedMateria)) {
        return;
    }


    const textMateria = document.createElement('li');
    textMateria.textContent = selectedMateria;
    materiasAprobadasList.appendChild(textMateria);


    materiaSelect.selectedIndex = 0;
}

// manejar habilidades
function handleAddHabilidad() {
    const habilidad = habilidadSelect.value;

    if (!habilidad) {
        habilidaderror.innerHTML = "Debe seleccionar alguna habilidad del listado.";
        return;
    }

    habilidaderror.innerHTML = "";

    // verificar si la habilidad ya se agrego
    const habilidadesAgregadas = Array.from(listaHabilidades.children).map(div => div.querySelector('label').textContent);
    if (habilidadesAgregadas.includes(habilidad)) { 
        habilidaderror.innerHTML = "Esta habilidad ya ha sido agregada.";
        return;
    }

    const divHabilidad = document.createElement('div');
    divHabilidad.classList.add('my-2','p-2', 'border','rounded', 'd-inline-block','me-2', 'shadow' );


    const label = document.createElement('label');
    label.classList.add('d-flex','justify-content-center');
    label.textContent = habilidad;
    divHabilidad.appendChild(label);


    const starsDiv = document.createElement('div');
    starsDiv.classList.add('stars');


    for (let i = 1; i <= 5; i++) {
        const star = document.createElement('span');
        star.classList.add('star');
        star.setAttribute('data-skill', habilidad.toLowerCase());
        star.setAttribute('data-value', i);
        star.innerHTML = '&#9733;';


        star.addEventListener('click', function () {
            const rating = star.getAttribute('data-value');
            starsDiv.querySelectorAll('.star').forEach(s => {
                s.style.color = s.getAttribute('data-value') <= rating ? 'gold' : 'gray';
            });
        });

        starsDiv.appendChild(star);
    }


    const btnEliminar = document.createElement('button');
    btnEliminar.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-2');

    const icon = document.createElement('i');
    icon.classList.add('bi', 'bi-trash');

    btnEliminar.appendChild(icon);
    icon.textContent = ' Eliminar';

    btnEliminar.addEventListener('click', function () {
        divHabilidad.remove();
    });


    divHabilidad.appendChild(starsDiv);
    divHabilidad.appendChild(btnEliminar);
    listaHabilidades.appendChild(divHabilidad);


    habilidadSelect.selectedIndex = 0;
}

// eventos
carreraSelect.addEventListener('change', handleCarreraChange);
planEstudiosSelect.addEventListener('change', handlePlanEstudiosChange);
agregarMateriaBtn.addEventListener('click', handleAgregarMateria);
document.getElementById('agregarHabilidad').addEventListener('click', handleAddHabilidad);
