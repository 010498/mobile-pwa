// Permite la recopilacion de la informacion del usuario para el ingreso a la plataforma

document.addEventListener('DOMContentLoaded', function(){

	if(document.querySelector('#form-login')){

		let form = document.querySelector('#form-login');

		form.onsubmit = function(e){
			e.preventDefault();

			let user = document.querySelector('#user-info').value;
			let pass = document.querySelector('#pass-info').value;


			if(user == "" || pass == ""){

				alert("Favor ingresar todos los campos");
				return false;

			}else{

				var request = (window.XMLHttpRequest) ? new XMLHttpRequest(): new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = base_url+"Home/login";
				var formData = new FormData(form);				
				request.open("POST", ajaxUrl, true);
				request.send(formData);
				
				request.onreadystatechange = function(){
					if(request.readyState == 4 && request.status == 200){

						var objData = JSON.parse(request.responseText);
						
						if(objData.status){

							$("#info-mensaje").html(objData.msg);
							window.location = base_url+"monitoreo";
							
						}else{

							$("#info-mensaje").html(objData.msg);
							document.querySelector('#user-info').value = "";
							document.querySelector('#pass-info').value = "";

							return false;
						}
						
					}
				}

			}

		}
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





