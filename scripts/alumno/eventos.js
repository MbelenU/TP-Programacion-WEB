document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('.toggleButton');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const eventoDetails = button.parentElement.nextElementSibling;

            eventoDetails.classList.toggle('d-none');

            const arrowIcon = button.querySelector('.arrowIcon');
            arrowIcon.classList.toggle('fa-chevron-left');
            arrowIcon.classList.toggle('fa-chevron-down');

            if (!eventoDetails.classList.contains('open')) {
                eventoDetails.style.height = eventoDetails.scrollHeight + 'px';
                eventoDetails.classList.add('open');

                setTimeout(() => {
                    eventoDetails.style.height = 'auto';
                }, 500);
            } else {
                eventoDetails.style.height = eventoDetails.scrollHeight + 'px';
                setTimeout(() => {
                    eventoDetails.style.height = '0';
                }, 10);
                eventoDetails.classList.remove('open');
            };
        });
    });
});

