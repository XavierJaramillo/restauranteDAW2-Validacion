// CONTROLAMOS QUE LOS VALORES DEL FORMULARIO ESTEN EN UNOS RANGOS CORRECTOS
function validacionCapacidad() {
    var cMax = parseInt(document.getElementById('capacidad_max').value);
    var c = parseInt(document.getElementById('capacidad_mesa').value);
    var disponible = document.getElementById('disp_mesa').value;
    var msg = document.getElementById('msg');

    if (c < 0 || c > cMax) {
        msg.innerHTML = "La capacidad actual no puede ser mayor que la capacidad máxima!";
        return false;
    } else if (disponible == "Libre" && c != 0) {
        msg.innerHTML = "No puede estar libre y con personas!";
        return false;
    } else if (disponible == "Ocupada" && c == 0) {
        msg.innerHTML = "No puede estar ocupado y sin personas!";
        return false;
    } else if (disponible == "Reparacion" && c != 0) {
        msg.innerHTML = "No puede estar en reparacion y con personas!";
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