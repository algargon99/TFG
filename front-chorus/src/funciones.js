import Swal from "sweetalert2";
import axios from "../axiosConfig";

export function mostrarAlerta(titulo, icono, foco = '') {

    if (foco != '') {
        document.getElementById(foco).focus();
    }

    Swal.fire({
        title: titulo,
        icon: icono,
        customClass: {
            confirmButton: 'btn btn-primary',
            popup: 'animated zoomIn',
        },
        buttonsStyling: false
    });
}

export function confirmar(url, id, titulo, mensaje, clase) {
    var urlid = url + id;

    const botonAlerta = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success me-3',
            cancelButton: 'btn btn-danger'
        }
    });

    botonAlerta.fire({
        title: titulo,
        text: mensaje,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Eliminar',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((res) => {
        if (res.isConfirmed) {
            enviarSolicitud('DELETE', { id: id }, urlid, 'Eliminado con éxito', clase);
        } else {
            mostrarAlerta('Operación cancelada', 'info');
        }
    });
}

export function enviarSolicitud(metodo, parametros, urlid, mensaje, clase) {

    if (hayArchivo(parametros)) {
        const formData = new FormData();
        Object.keys(parametros).forEach(key => {
            console.log(parametros[key]);
            formData.append(key, parametros[key]);
        });
        parametros = formData;
    }
    //console.log(parametros);
    axios({
        method: metodo,
        url: urlid,
        data: parametros,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(function (res) {
        var estado = res.status;
        console.log(res);
        if (Array.isArray(res.data)) {
            mostrarAlerta(res.data.join('\n'), 'error');
        }
        else if (estado == 200 || estado == 201) {
            mostrarAlerta(mensaje, 'success');
            window.setTimeout(function () {
                window.location.href = "/" + clase
            }, 3000);
        } else {
            mostrarAlerta('Sin respuesta', 'error')
        }
    }).catch(function (error) {
        mostrarAlerta('Error de conexión', 'error');
        console.log(error);
    });
}

export function login(email, password, mensaje) {
    axios.post('/login', {
        email: email,
        password: password,
    }).then(res => {
        var estado = res.status;
        console.log(estado);
        if (estado == 200 || estado == 201) {
            mostrarAlerta(mensaje, 'success');
            window.setTimeout(function () {
                window.location.href = "/coros"
            }, 1000);
        } else {
            mostrarAlerta('Sin respuesta', 'error')
        }
    }).catch(error => {
        mostrarAlerta('Error de conexión', 'error');
        console.log(error);
    });
}

function hayArchivo(parametros) {
    var existe = false;
    if (parametros["partitura"] || parametros["audio"] || parametros["video"] || parametros["fotos"]) {
        existe = true;
    }
    return existe;
}