document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-perfil-empresa');

    const profileData = {
        profilePhoto: 'perfil.jpg',
        companyName: 'Empresa S.A.',
        email: 'contacto@empresa.com',
        phone: '+11 111 111 111',
        website: 'https://www.empresa.com',
        description: 'Descripción de empresa'
    };

    document.getElementById('companyName').value = profileData.companyName;
    document.getElementById('email').value = profileData.email;
    document.getElementById('phone').value = profileData.phone;
    document.getElementById('website').value = profileData.website;
    document.getElementById('description').value = profileData.description;

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const profilePhoto = document.getElementById('profilePhoto').files[0];
        const companyName = document.getElementById('companyName').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const website = document.getElementById('website').value.trim();
        const description = document.getElementById('description').value.trim();

        let errors = [];

        if (!profilePhoto) {
            errors.push("Debes subir una foto de perfil.");
        }

        if (companyName === "") {
            errors.push("El nombre de la empresa es obligatorio.");
        }

        if (email === "" || !validateEmail(email)) {
            errors.push("Debes proporcionar un correo electrónico válido.");
        }

        if (phone === "") {
            errors.push("El teléfono es obligatorio.");
        }

        if (website === "") {
            errors.push("El sitio web es obligatorio.");
        }

        if (description === "") {
            errors.push("La descripción es obligatoria.");
        }

        if (errors.length > 0) {
            alert(errors.join("\n"));
            return;
        }

        const formData = {
            profilePhoto: profilePhoto ? profilePhoto.name : "",
            companyName: companyName,
            email: email,
            phone: phone,
            website: website,
            description: description
        };

        console.log(JSON.stringify(formData, null, 2));
        alert("Datos guardados correctamente.");
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});