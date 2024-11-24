document.addEventListener('DOMContentLoaded', function() {
    // Captura todos los botones de eliminar
    const deleteButtons = document.querySelectorAll('button[data-borrar-id]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-borrar-id');
            borrarPublicacion(id);
        });
    });
});

function borrarPublicacion(id) {
    fetch('borrar-publicacion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Publicación eliminada con éxito');
            document.querySelector(`[data-publicacion-id="${id}"]`).closest('.list-group-item').remove();
        } else {
            alert('Ocurrió un error al eliminar la publicación');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al eliminar la publicación');
    });
}