document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('[data-publicacion-id]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-publicacion-id');
            console.log(id);
            borrarPublicacion(id);
        });
    });
});
function borrarPublicacion(id) {
    fetch('/TP-Programacion-WEB/controllers/EmpresaController.php?borrarPublicacion', {
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