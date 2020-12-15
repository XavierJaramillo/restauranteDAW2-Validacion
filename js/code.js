// CONTROLAMOS QUE LOS VALORES DEL FORMULARIO ESTEN EN UNOS RANGOS CORRECTOS
function validacionCapacidad() {
    var cMax = parseInt(document.getElementById('capacidad_max').value);
    var c = parseInt(document.getElementById('capacidad_mesa').value);
    var msg = document.getElementById('msg');

    if (c < 0 || c > cMax) {
        msg.innerHTML = "La capacidad actual no puede ser mayor que la capacidad máxima!";
        return false;
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