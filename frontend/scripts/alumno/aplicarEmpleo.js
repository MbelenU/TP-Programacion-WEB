document.addEventListener("DOMContentLoaded", function() {
    const botonesAplicar = document.querySelectorAll('.aplicar-empleo');

    botonesAplicar.forEach(button => {
        const empleoId = button.getAttribute('data-empleo-id');

        button.addEventListener('click', async function(event) {
            event.preventDefault();
            const postulacionData = {
                empleoId: empleoId
            };
            fetch(`/TP-Programacion-WEB/controllers/AlumnoController.php?aplicarEmpleo`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(postulacionData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.disabled = true;
                    button.innerText = "Postulado";
                } else {
                    alert('Error al postularte: ' + data.message);
                }
            });
        });
    });

});
