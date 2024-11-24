document.getElementById('guardarReclutamiento').addEventListener('click',async function() {
    const alumnoId = document.getElementById('alumno-info').getAttribute('data-alumno-id');
    const publicacionId = document.getElementById('publicacionSelect').value;  

    if (publicacionId === "Selecciona una publicación") {
        alert("Por favor, selecciona una publicación.");
        return;
    }


    let response = await fetch('http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?reclutarAlumno', {
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
    
    console.log(response);

});
