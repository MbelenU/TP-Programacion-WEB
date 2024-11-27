document.getElementById('guardarReclutamiento').addEventListener('click', async function() {
    const alumnoId = document.getElementById('alumno-info').getAttribute('data-alumno-id');
    const publicacionId = document.getElementById('publicacionSelect').value;

    if (publicacionId === "Selecciona una publicación") {
        alert("Por favor, selecciona una publicación.");
        return;
    }

    const successMessageDiv = document.getElementById('successMessage');
    const errorMessageDiv = document.getElementById('errorMessage');

    successMessageDiv.classList.add('d-none');
    errorMessageDiv.classList.add('d-none');

    let response = await fetch('/TP-Programacion-WEB/controllers/EmpresaController.php?reclutarAlumno', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            usuario_id: alumnoId,
            publicacion_id: publicacionId
        })
    });

    response = await response.json();


    if (response.success) {
        successMessageDiv.textContent = response.message;
        successMessageDiv.classList.remove('d-none');
    } else {
        errorMessageDiv.textContent = response.message;
        errorMessageDiv.classList.remove('d-none'); 
    }
});

$('#modalReclutar').on('show.bs.modal', function () {
    const successMessageDiv = document.getElementById('successMessage');
    const errorMessageDiv = document.getElementById('errorMessage');
    
    successMessageDiv.classList.add('d-none');
    errorMessageDiv.classList.add('d-none');
});
