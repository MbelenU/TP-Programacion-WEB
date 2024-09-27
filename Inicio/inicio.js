// Esperar a que el DOM esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
    const formInicio = document.getElementById('form-inicio');
    const btnRegister = document.getElementById('btnRegister');
    
    // Iniciar Sesion
    formInicio.addEventListener('submit', function(event) {
        // Evitar que el formulario se envíe
        event.preventDefault();
        // Obtener los valores de los inputs
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Simular un proceso de autenticación (podrías hacer algo más complejo aquí)
        if (email === "usuario@gmail.com" && password === "contraseña123") {
            // Si los datos son correctos, redirigir a una nueva página
            window.location.href = "dashboard.html";
        } 
        // Validar todos los campos
        else if (formInicio.checkValidity() === false) {
            // Mostrar los mensajes de error de HTML5
            formInicio.classList.add("was-validated");
            // Resetea el Formulario
            formInicio.reset();
        }
    });

    // Registrarse
    btnRegister.addEventListener('click' , function(event) {
        event.preventDefault();
        window.location.href = 'register.html';
    });
});
