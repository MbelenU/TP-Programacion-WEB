document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.container-empleo').forEach(item => {
        item.addEventListener('click', () => {
            const details = item.querySelector('.empleo-details');
            details.classList.toggle('d-none'); // Alterna la clase d-none
        });
    });
});