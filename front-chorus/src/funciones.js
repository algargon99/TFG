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
            enviarSolicitud('DELETE', { id: id }, urlid, 'Eliminado con éxito',clase);
        } else {
            mostrarAlerta('Operación cancelada', 'info');
        }
    });
}

export function enviarSolicitud(metodo, parametros, urlid, mensaje,clase) {
    console.log(parametros);
    console.log(urlid);
    axios({
        method: metodo,
        url: urlid,
        data: parametros
    }).then(function (res) {
        var estado = res.status;
        console.log(estado);
        if (estado == 200 || estado == 201) {
            mostrarAlerta(mensaje, 'success');
            window.setTimeout(function () {
                window.location.href = "/"+clase
            }, 1000);
        } else {
            mostrarAlerta('Sin respuesta', 'error')
        }
    }).catch(function (error) {
        mostrarAlerta('Error de conexión', 'error');
        console.log(error);
    });
}

