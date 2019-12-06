
function age(fecha) { 
	var dob = new Date(fecha);
    var diff_ms = Date.now() - dob.getTime();
    var age_dt = new Date(diff_ms); 
    return Math.abs(age_dt.getUTCFullYear() - 1970);
}

function validate(){
	var nombre, apellidoP, apellidoM,mail,mail2,pass,pass2,fecha,
	validarMail,validarPass;
	nombre = document.getElementById("nombre").value;
	apellidoP = document.getElementById("apellido_1").value;
	apellidoM = document.getElementById("apellido_2").value;
	mail = document.getElementById("correo_1").value;
	mail2 = document.getElementById("correo_2").value;
	pass = document.getElementById("pass_1").value;
	pass2 = document.getElementById("pass_2").value;
	fecha = document.getElementById("fecha").value;
	var rgx1 = /[a-zA-Z]+/;
	var rgx2 = /[\%|\$|\&]+/;
	var rgx3 = /\d+/;
	var warn = document.createElement('div');
	var target = document.getElementById('error');
	warn.setAttribute("class","alert alert-danger");
	target.innerHTML='';
	if(nombre==""||apellidoM==""||apellidoP==""||mail2==""||pass2==""||!Date.parse(fecha)){
		warn.textContent = 'Todos los campos deben estar llenos';
		target.appendChild(warn);
		return false;
	}else if(!(mail==mail2)){
		warn.textContent = 'Los correos electrónicos deben coincidir';
		target.appendChild(warn);
		return false;
	}else if(pass.length<8){
		warn.textContent = 'La contraseña debe contener 8 dígitos o más';
		target.appendChild(warn);
		return false;
	}else if(!(pass.match(rgx1) &&pass.match(rgx2) &&pass.match(rgx3))){
		warn.textContent = 'La contraseña debe contener al menos una letra,un número y cualquiera de los siguientes símbolos $,%,&';
		target.appendChild(warn);
		return false;
	}else if(!(pass==pass2)){
		warn.textContent = 'La contraseñas deben coincidir';
		target.appendChild(warn);
		return false;
	}else if(age(fecha)<18){
		warn.textContent = 'Debes ser mayor de edad';
		target.appendChild(warn);
		return false;
	}
}
