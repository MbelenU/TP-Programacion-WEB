document.addEventListener('DOMContentLoaded', () => {
    const paginationLinks = document.querySelectorAll('.pagination .page-link');

    paginationLinks.forEach(link => {
        link.addEventListener('click', event => {
            event.preventDefault();
            const url = event.target.getAttribute('href');
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('.container.mt-5').innerHTML;
                    document.querySelector('.container.mt-5').innerHTML = newContent;
                })
                .catch(error => console.error('Error al cargar la página:', error));
        });
    });
});
