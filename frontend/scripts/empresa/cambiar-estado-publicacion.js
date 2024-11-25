document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-group button').forEach(function(button) {
        button.addEventListener('click', async function() {
            var estadoSeleccionadoId = this.getAttribute('data-estado-id');
            var publicacionId = this.closest('.btn-group').getAttribute('data-publicacion-id');
            
            var buttons = this.closest('.btn-group').querySelectorAll('button');
            buttons.forEach(function(btn) {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-secondary'); 
            });


            this.classList.remove('btn-secondary');
            this.classList.add('btn-success');
            
            let response = await fetch('/TP-Programacion-WEB/controllers/EmpresaController.php?cambiarEstadoPublicacion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    publicacion_id: publicacionId, 
                    estado_id: estadoSeleccionadoId  
                })
            });

            response = await response.json();
            
            console.log(response);
        });
    });
});
