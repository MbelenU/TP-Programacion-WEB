document.addEventListener('DOMContentLoaded', function() {
    const carreras = {
        1: {
            nombre: "Ingeniería en Software",
            universidad: "Universidad Nacional",
            planesEstudios: [
                {
                    plan: "Plan 2023",
                    cantidadMaterias: 40,
                    horasTotales: 3200,
                    materias: [
                        { nombre: "Programación I", horas: 120 },
                        { nombre: "Algoritmos", horas: 100 },
                        { nombre: "Base de Datos", horas: 150 },
                    ]
                },
                {
                    plan: "Plan 2022",
                    cantidadMaterias: 38,
                    horasTotales: 3100,
                    materias: [
                        { nombre: "Matemáticas Discretas", horas: 100 },
                        { nombre: "Estructura de Datos", horas: 130 },
                        { nombre: "Ingeniería de Software", horas: 140 },
                    ]
                }
            ]
        },
        2: {
            nombre: "Ingeniería Civil",
            universidad: "Universidad Nacional",
            planesEstudios: [
                {
                    plan: "Plan 2020",
                    cantidadMaterias: 45,
                    horasTotales: 3500,
                    materias: [
                        { nombre: "Cálculo I", horas: 130 },
                        { nombre: "Estática", horas: 120 },
                        { nombre: "Resistencia de Materiales", horas: 150 },
                    ]
                },
                {
                    plan: "Plan 2019",
                    cantidadMaterias: 42,
                    horasTotales: 3400,
                    materias: [
                        { nombre: "Mecánica de Fluidos", horas: 110 },
                        { nombre: "Química General", horas: 90 },
                    ]
                }
            ]
        },
    };

    const urlParams = new URLSearchParams(window.location.search);
    const carreraId = urlParams.get('carreraId');

    if (carreras[carreraId]) {
        const datosCarrera = carreras[carreraId];

        const nombreCarreraElem = document.getElementById('nombreCarrera');
        const universidadCarreraElem = document.getElementById('universidadCarrera');
        const acordionElem = document.getElementById('acordion');

        nombreCarreraElem.textContent = datosCarrera.nombre;
        universidadCarreraElem.textContent = datosCarrera.universidad;

        datosCarrera.planesEstudios.forEach((plan, index) => {
            const card = document.createElement('div');
            card.classList.add('acordion-item');

            const header = document.createElement('h2');
            header.classList.add('acordion-header');
            const headerId = `heading${index}`;
            header.innerHTML = `
                <button class="acordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${index}" aria-expanded="true" aria-controls="collapse${index}">
                    ${plan.plan} (Materias: ${plan.cantidadMaterias}, Horas Totales: ${plan.horasTotales})
                </button>
            `;
            card.appendChild(header);

            const body = document.createElement('div');
            body.id = `collapse${index}`;
            body.classList.add('acordion-collapse', 'collapse');
            body.innerHTML = `<div class="acordion-body"><ul class="list-group"></ul></div>`;
            plan.materias.forEach(materia => {
                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.textContent = `${materia.nombre} - Horas: ${materia.horas}`;
                body.querySelector('.list-group').appendChild(listItem);
            });
            card.appendChild(body);

            acordionElem.appendChild(card);
        });
    } else {
        alert('No se encontró la carrera con el ID especificado.');
    }

    const volverButton = document.getElementById('Volver');
    volverButton.addEventListener('click', function() {
        window.location.href = 'http://localhost/TP-Programacion-WEB/admin/Visualizar-Carrera/visualizar-carreras-admin.html';
    });

});
