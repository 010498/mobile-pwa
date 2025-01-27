
// Permite la recopilacion de la informacion del usuario para el ingreso a la plataforma
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('#form-login')) {
        let form = document.querySelector('#form-login');

        form.onsubmit = async function (e) {
            e.preventDefault();

            let user = document.querySelector('#user-info').value;
            let pass = document.querySelector('#pass-info').value;

            if (user === "" || pass === "") {
                alert("Favor ingresar todos los campos");
                return false;
            }

            try {
                const ajaxUrl = base_url + "Home/login";

                // Crear un objeto FormData con los datos del formulario
                const formData = new FormData(form);

                // Realizar la solicitud con fetch
                const response = await fetch(ajaxUrl, {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`Error en la solicitud: ${response.statusText}`);
                }

                const objData = await response.json();

                if (objData.status) {
                    // Redirigir al usuario
                    window.location = base_url + "monitoreo";
                } else {
                    alert(objData.msg);
                    document.querySelector('#user-info').value = "";
                    document.querySelector('#pass-info').value = "";
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Ocurrió un error al procesar la solicitud. Intenta de nuevo más tarde.');
            }
        };
    }
});


// Funcion que permite visualizar la informacion de la contraseña
function togglePasswordVisibility() {
  const passwordInput = document.getElementById('pass-info');
  const eyeIcon = document.getElementById('eye-icon');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text'; // Cambiar a texto
    eyeIcon.classList.remove('fa-eye'); // Cambiar el ícono
    eyeIcon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = 'password'; // Cambiar a contraseña
    eyeIcon.classList.remove('fa-eye-slash'); // Cambiar el ícono
    eyeIcon.classList.add('fa-eye');
  }
}





