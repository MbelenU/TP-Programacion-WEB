document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const titulo = document.getElementById("titulo").value.trim();
        const modalidad = document.getElementById("modalidad").value;
        const ubicacion = document.getElementById("ubicacion").value.trim();
        const jornada = document.getElementById("jornada").value;
        const descripcion = document.getElementById("text-area").value.trim();
        const habilidad = document.getElementById("habilidad").value.trim();
        const carrera = document.getElementById("carrera").value;

        let errors = [];

        if (titulo === "") {
            errors.push("El título es obligatorio.");
        }

        if (modalidad === "") {
            errors.push("Debes seleccionar una modalidad.");
        }

        if (ubicacion === "") {
            errors.push("La ubicación es obligatoria.");
        }

        if (jornada === "") {
            errors.push("Debes seleccionar un tipo de jornada.");
        }

        if (descripcion === "") {
            errors.push("La descripción es obligatoria.");
        }

        if (habilidad === "") {
            errors.push("Debes ingresar al menos una habilidad.");
        }

        if (carrera === "") {
            errors.push("Debes seleccionar una carrera.");
        }

        if (errors.length > 0) {
            alert(errors.join("\n"));
            return;
        }

        const formData = {
            titulo: titulo,
            modalidad: modalidad,
            ubicacion: ubicacion,
            jornada: jornada,
            descripcion: descripcion,
            habilidad: habilidad,
            carrera: carrera
        };

        console.log(JSON.stringify(formData, null, 2));
        alert("Datos guardados correctamente.");
    });
});

const planesEstudio = {
    "Desarrollo de Software": ["2016", "2019"],
    "Turismo": ["2016", "2019"],
    "Comercio Internacional": ["2016", "2019"],
    "Gestión Aeroportuaria": ["2016", "2019"],
    "Logistica": ["2016", "2019"],
    "Higiene y Seguridad": ["2016", "2019"]
};


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


function handleAddHabilidad() {
    const habilidad = habilidadSelect.value;
    let habilidades = listaHabilidades.querySelectorAll('div label');
    habilidades = Array.from(habilidades).map(habilidad => habilidad.textContent);
    if (!habilidad || habilidades.includes(habilidad)) {
        habilidaderror.innerHTML = "Debe seleccionar alguna habilidad del listado.";
        return;
    }

    habilidaderror.innerHTML = "";

    const divHabilidad = document.createElement('div');
    divHabilidad.classList.add('mb-2');


    const label = document.createElement('label');
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
    btnEliminar.textContent = 'Eliminar';


    btnEliminar.addEventListener('click', function () {
        divHabilidad.remove();
    });


    divHabilidad.appendChild(starsDiv);
    divHabilidad.appendChild(btnEliminar);
    listaHabilidades.appendChild(divHabilidad);


    habilidadSelect.selectedIndex = 0;
}


carreraSelect.addEventListener('change', handleCarreraChange);
planEstudiosSelect.addEventListener('change', handlePlanEstudiosChange);
agregarMateriaBtn.addEventListener('click', handleAgregarMateria);
document.getElementById('agregarHabilidad').addEventListener('click', handleAddHabilidad);
