document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('.toggleButton');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const solicitudDetails = button.parentElement.nextElementSibling;

            solicitudDetails.classList.toggle('d-none');

            const arrowIcon = button.querySelector('.arrowIcon');
            arrowIcon.classList.toggle('fa-chevron-left');
            arrowIcon.classList.toggle('fa-chevron-down');

            if (!solicitudDetails.classList.contains('open')) {
                solicitudDetails.style.height = solicitudDetails.scrollHeight + 'px';
                solicitudDetails.classList.add('open');

                setTimeout(() => {
                    solicitudDetails.style.height = 'auto';
                }, 500);
            } else {
                solicitudDetails.style.height = solicitudDetails.scrollHeight + 'px';
                setTimeout(() => {
                    solicitudDetails.style.height = '0';
                }, 10);
                solicitudDetails.classList.remove('open');
            };
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
