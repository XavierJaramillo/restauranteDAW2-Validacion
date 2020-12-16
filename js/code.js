// CONTROLAMOS QUE LOS VALORES DEL FORMULARIO ESTEN EN UNOS RANGOS CORRECTOS
function validacion() {
    var flag1 = false;
    var flag2 = false;

    if (validacionCapacidad()) {
        flag1 = true;
    }
    if (validarFranja()) {
        flag2 = true;
    }

    if (flag1 && flag2) {
        return true;
    }

    return false;
}

function validacionCapacidad() {
    var cMax = parseInt(document.getElementById('capacidad_max').value);
    var c = parseInt(document.getElementById('capacidad_mesa').value);
    var msg = document.getElementById('msg');
    var inputC = document.getElementById('capacidad_mesa');

    if (c < 0 || c > cMax) {
        msg.innerHTML = "La capacidad actual no puede ser mayor que la capacidad máxima!";
        inputC.style.borderColor = "red";
        return false;
    } else {
        msg.innerHTML = "";
        inputC.style.borderColor = "transparent";
        return true;
    }
}

function validarFranja() {
    var d = new Date();

    var franjaInput = document.getElementById('hora');
    var franja = document.getElementById('hora').value;
    var horaFranja = franja.substring(0, 2);


    // var diaActual = d.getDay();
    var diaActual = new Date().getDate();
    var dia = document.getElementById('dia').value;
    var diaFinal = dia.substr(dia.length - 2);

    var horaActual = d.getHours();

    var msg = document.getElementById('msgHora');

    if (diaFinal == diaActual) {
        if (horaActual > horaFranja) {
            franjaInput.style.borderColor = "red";
            msg.innerHTML = "La hora es incorrecta!";
            return false;
        } else if (horaActual < horaFranja) {
            franjaInput.style.borderColor = "transparent";
            msg.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function validacionLogin() {
    var user = document.getElementById('user').value;
    var pass = document.getElementById('pass').value;
    var userTag = document.getElementsByTagName('p')[0];
    var passTag = document.getElementsByTagName('p')[1];

    if (user == "" && pass == "") {
        userTag.style.color = "red";
        passTag.style.color = "red";
        document.getElementById('user').style.borderColor = "red";
        document.getElementById('pass').style.borderColor = "red";
    } else if (user == "") {
        userTag.style.color = "red";
        passTag.style.color = "white";
        document.getElementById('user').style.borderColor = "red";
        document.getElementById('pass').style.borderColor = "white";
    } else if (pass == "") {
        userTag.style.color = "white";
        passTag.style.color = "red";
        document.getElementById('user').style.borderColor = "white";
        document.getElementById('pass').style.borderColor = "red";
    } else {
        return true;
    }
    return false;
}

//Hover estado de la mesa
function displayInfo(number) {
    caja = document.getElementById('caja' + number);
    caja.style.display = "block"
}

function quitInfo(number) {
    caja = document.getElementById('caja' + number);
    caja.style.display = "none"
}

//Controlamos que la contraseña este validada
function validacionPass(e) {
    //Variables
    flag = false;
    passValue = document.getElementById('contrasenya').value;
    passValueValidada = document.getElementById('contrasenyaVal').value;
    pass = document.getElementById('contrasenya');
    passValidada = document.getElementById('contrasenyaVal');
    msg = document.getElementById('msgErr');

    //Logica para validar contraseña
    if (passValue == passValueValidada) {
        flag = true;
        pass.style.borderColor = "transparent";
        passValidada.style.borderColor = "transparent";
    } else {
        msg.innerHTML = "Las contraseñas deben ser iguales.";
        pass.style.borderColor = "red";
        passValidada.style.borderColor = "red";
    }

    //Devolvemos true o false
    return flag;
}