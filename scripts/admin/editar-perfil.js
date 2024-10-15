document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-perfil');
    const btnChangePassword = document.getElementById('btnChangePassword');
    const passwordFields = document.getElementById('passwordFields');

    const profileData = {
        profilePhoto: 'perfil.jpg',
        universityName: 'Universidad Provincial de Ezeiza',
        email: 'ejemplo@universidad.edu',
        password: 'password123'
    };

    document.getElementById('universityName').value = profileData.universityName;
    document.getElementById('email').value = profileData.email;

    btnChangePassword.addEventListener('click', () => {
        passwordFields.classList.toggle('d-none');
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const profilePhoto = document.getElementById('profilePhoto').files[0];
        const universityName = document.getElementById('universityName').value.trim();
        const email = document.getElementById('email').value.trim();
        const oldPassword = document.getElementById('oldPassword').value.trim();
        const newPassword = document.getElementById('newPassword').value.trim();
        const confirmPassword = document.getElementById('confirmPassword').value.trim();

        let errors = [];

        if (!profilePhoto) {
            errors.push("Debes subir una foto de perfil.");
        }

        if (universityName === "") {
            errors.push("El nombre de la universidad es obligatorio.");
        }

        if (email === "" || !validateEmail(email)) {
            errors.push("Debes proporcionar un correo electrónico válido.");
        }

        if (!passwordFields.classList.contains('d-none')) {
            if (oldPassword === "") {
                errors.push("La contraseña antigua es obligatoria.");
            } else if (oldPassword !== profileData.password) {
                errors.push("La contraseña antigua no coincide con la registrada.");
            }

            if (newPassword === "" || newPassword.length < 6) {
                errors.push("La nueva contraseña debe tener al menos 6 caracteres.");
            }

            if (confirmPassword !== newPassword) {
                errors.push("La confirmación de la contraseña no coincide.");
            }
        }

        if (errors.length > 0) {
            alert(errors.join("\n"));
            return;
        }

        const formData = {
            profilePhoto: profilePhoto ? profilePhoto.name : "",
            universityName: universityName,
            email: email
        };

        if (!passwordFields.classList.contains('d-none')) {
            formData.newPassword = newPassword;
            profileData.password = newPassword;
        }

        console.log(JSON.stringify(formData, null, 2));
        alert("Datos guardados correctamente.");
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});
