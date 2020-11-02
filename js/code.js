function validacionCapacidad() {
    var cMax = document.getElementById('capacidad_max').value;
    var c = document.getElementById('capacidad_mesa').value;
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