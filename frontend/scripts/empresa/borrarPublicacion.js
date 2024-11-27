document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('[data-borrar-publicacion]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-borrar-publicacion');
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
            document.querySelector(`[data-borrar-publicacion="${id}"]`).closest('.list-group-item').remove();
        } else {
            alert('Ocurrió un error al eliminar la publicación');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}