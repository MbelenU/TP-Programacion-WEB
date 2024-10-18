document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('.toggleButton');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const empleoDetails = button.parentElement.nextElementSibling;

            empleoDetails.classList.toggle('d-none');

            const arrowIcon = button.querySelector('.arrowIcon');
            arrowIcon.classList.toggle('fa-chevron-left');
            arrowIcon.classList.toggle('fa-chevron-down');

            if (!empleoDetails.classList.contains('open')) {
                empleoDetails.style.height = empleoDetails.scrollHeight + 'px';
                empleoDetails.classList.add('open');

                setTimeout(() => {
                    empleoDetails.style.height = 'auto';
                }, 500);
            } else {
                empleoDetails.style.height = empleoDetails.scrollHeight + 'px';
                setTimeout(() => {
                    empleoDetails.style.height = '0';
                }, 10);
                empleoDetails.classList.remove('open');
            }
        });
    });
});
