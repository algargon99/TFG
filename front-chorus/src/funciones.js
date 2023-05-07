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
            confirmButton: 'btn',
            popup: 'animated zoomIn',
            buttonsStyling: false
        }
    });
}

export function confirmar(url, id, titulo, mensaje) {
    var urlid = url + id
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
            enviarSolicitud('DELETE', { id: id }, url, 'Eliminado con exito');
        } else {
            mostrarAlerta('Operación cancelada', 'info');
        }
    });
}

export function enviarSolicitud(metodo, parametros, url, mensaje) {
    axios({
        method: metodo,
        url: url,
        data: parametros,

    }).then(function (res) {
        var estado = res.status;
        if (estado == 200) {
            mostrarAlerta(mensaje, 'success');
            window.setTimeout(function (params) {
                window.location.href = "/"
            }, 1000);
        } else {
            mostrarAlerta('No se pudo recuperar la respuesta', 'error')
        }
    }).catch(function (error) {
        mostrarAlerta('Servidor no disponible', 'error');
        console.log(error);
    });
}

