document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.container-evento').forEach(item => {
        item.addEventListener('click', () => {
            const details = item.querySelector('.evento-details');
            details.classList.toggle('d-none'); 
        });
    });
});