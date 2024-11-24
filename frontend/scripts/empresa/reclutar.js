document.getElementById('guardarReclutamiento').addEventListener('click',async function() {
    const alumnoId = document.getElementById('alumno-info').getAttribute('data-alumno-id');
    const postulacionId = document.getElementById('publicacionSelect').value;  

    if (postulacionId === "Selecciona una publicación") {
        alert("Por favor, selecciona una publicación.");
        return;
    }


    let response = await fetch('http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?reclutarAlumno', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            alumno_id: alumnoId,
            postulacion_id: postulacionId
        })
    });
    response = await response.json();
    
    console.log(response);

});
