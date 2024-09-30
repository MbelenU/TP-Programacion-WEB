document.addEventListener('DOMContentLoaded', function() {
    const carreras = [
        { id: 1, nombre: 'Ingeniería en Software', universidad: 'Universidad Nacional' },
        { id: 2, nombre: 'Ingeniería Civil', universidad: 'Universidad Nacional' },
    ];

    const tableBody = document.getElementById('tableBody');
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');

    function crearFilasCarreras(carrerasFiltradas) {
        tableBody.innerHTML = '';

        if (carrerasFiltradas.length === 0) {
            const noResultsRow = document.createElement('tr');
            const noResultsCell = document.createElement('td');
            noResultsCell.colSpan = 3;
            noResultsCell.textContent = 'No se encontraron resultados';
            noResultsCell.classList.add('text-center');

            noResultsRow.appendChild(noResultsCell);
            tableBody.appendChild(noResultsRow);
            return;
        }

        carrerasFiltradas.forEach(carrera => {
            const fila = document.createElement('tr');

            const carreraCell = document.createElement('td');
            const carreraLink = document.createElement('a');
            carreraLink.href = `Carrera/carrera.html?carreraId=${carrera.id}`;
            carreraLink.textContent = carrera.nombre;
            carreraLink.style.textDecoration = 'none';
            carreraLink.style.color = 'inherit';
            carreraCell.appendChild(carreraLink);

            const universidadCell = document.createElement('td');
            universidadCell.textContent = carrera.universidad;

            fila.appendChild(carreraCell);
            fila.appendChild(universidadCell);

            tableBody.appendChild(fila);
        });
    }

    function filtrarCarreras() {
        const textoBusqueda = searchInput.value.toLowerCase().trim();

        const carrerasFiltradas = carreras.filter(carrera => {
            return carrera.nombre.toLowerCase().includes(textoBusqueda) || carrera.universidad.toLowerCase().includes(textoBusqueda);
        });

        crearFilasCarreras(carrerasFiltradas);
    }

    crearFilasCarreras(carreras);

    searchButton.addEventListener('click', filtrarCarreras);
});
