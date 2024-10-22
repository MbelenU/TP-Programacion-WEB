document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.container-solic').forEach(item => {
        item.addEventListener('click', () => {
            const details = item.querySelector('.solic-details');
            details.classList.toggle('d-none'); 
        });
    });

    // eliminar la solicitud 
    document.querySelectorAll('.btn-light').forEach(button => {
        button.addEventListener('click', (event) => {
            event.stopPropagation(); 
            const solicItem = button.closest('.solic-item');
            const container = solicItem.closest('.container-solic'); 
            if (container) {
                container.remove(); 
            }
        });
    });
});
