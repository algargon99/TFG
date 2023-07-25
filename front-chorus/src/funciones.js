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

    var tipo = '';
    if (hayArchivo(parametros)) {
        const formData = new FormData();
        Object.keys(parametros).forEach(key => {
            formData.append(key, parametros[key]);
        });
        if (metodo == 'PUT') {
            formData.append('_method', 'PUT');
            metodo = 'POST';
        }
        parametros = formData;
        tipo = 'multipart/form-data';
    } else {
        parametros = JSON.stringify(parametros);
        tipo = 'application/json';
    }

    axios({
        method: metodo,
        url: urlid,
        data: parametros,
        headers: {
            'Content-Type': tipo
        }
    }).then(function (res) {
        var estado = res.status;
        console.log(res);
        if (res.data != 1) {
            mostrarAlerta(res.data.join('\n'), 'error');
        } else if (estado == 200 || estado == 201) {
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

export function loginBack(email, password) {
    return axios.post('/api/login', {
      email: email,
      password: password,
    }).then(res => {
      var estado = res.status;
      if (estado === 200 || estado === 201) {
        return res.data;
        console.log(res.data);
      } else {
        throw new Error('Sin respuesta');
      }
    }).catch(error => {
      throw new Error('Error de conexión');
    });
  }

function hayArchivo(parametros) {
    for (const key in parametros) {
        if (parametros.hasOwnProperty(key) && parametros[key] instanceof File) {
            const archivo = parametros[key];
            const tipo = archivo.type.split('/')[0];
            if (tipo === 'image' || tipo === 'audio' || tipo === 'video' || tipo === 'application') {
                return true;
            }
        }
    }
    return false;
}