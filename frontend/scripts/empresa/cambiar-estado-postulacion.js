document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-group button').forEach(function(button) {
        button.addEventListener('click', async function() {
            var estadoSeleccionadoId = this.getAttribute('data-estado-id');
            var postulacionId = this.closest('.btn-group').getAttribute('data-postulacion-id');
            
            var buttons = this.closest('.btn-group').querySelectorAll('button');
            buttons.forEach(function(btn) {
                btn.classList.remove('btn-danger');
                btn.classList.remove('btn-success');
                btn.classList.add('btn-secondary');
            });
            if(estadoSeleccionadoId == 4){
                this.classList.remove('btn-secondary');
                this.classList.add('btn-danger');
            }else if(estadoSeleccionadoId == 3){
                this.classList.remove('btn-secondary');
                this.classList.add('btn-success');
            }else{
                this.classList.remove('btn-secondary');
                this.classList.add('btn-primary');
            }

            
            let response = await fetch('http://localhost/TP-Programacion-WEB/controllers/EmpresaController.php?cambiarEstadoPostulacion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    postulacion_id: postulacionId,
                    estado_id: estadoSeleccionadoId
                })
            });
            response = await response.json();
            
            console.log(response);
        });
    });
});
