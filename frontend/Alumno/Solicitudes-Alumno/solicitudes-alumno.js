document.addEventListener('DOMContentLoaded', () => {
    // Mostrar/ocultar detalles de la solicitud
    document.querySelectorAll('.container-solic').forEach(item => {
        item.addEventListener('click', () => {
            const details = item.querySelector('.solic-details');
            details.classList.toggle('d-none'); // Alterna la clase d-none
        });
    });

    // Eliminar la solicitud al hacer clic en "DAR DE BAJA"
    document.querySelectorAll('.btn-light').forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation(); // Evita que se dispare el evento en el contenedor
            const solicItem = button.closest('.solic-item'); // Encuentra el elemento padre
            const container = solicItem.closest('.container-solic'); // Encuentra el contenedor
            if (container) {
                container.remove(); // Elimina el contenedor de la lista
            }
        });
    });
});
