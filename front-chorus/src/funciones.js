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

export function desasignarCoro(url, idUsuario, idCoro, titulo, mensaje, clase) {


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
        confirmButtonText: '<i class="fa-solid fa-check"></i> Confirmar',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((res) => {
        if (res.isConfirmed) {
            enviarSolicitud('DELETE', { usuario: idUsuario, coro: idCoro }, url, 'Expulsión con éxito', clase);
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
        console.log(res);
        var estado = res.status;
        if (estado == 200 || estado == 201) {
            if (res.data != 1) {
                mostrarAlerta(res.data.join('\n'), 'error');
            } else {
                window.setTimeout(function () {
                    window.location.href = "/" + clase
                }, 0);
            }
        } else {
            mostrarAlerta('Sin respuesta', 'error')
        }
    }).catch(function (error) {
        mostrarAlerta('Error de conexión', 'error');
        console.error(error);
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
        } else {
            throw new Error('Sin respuesta');
        }
    }).catch(error => {
        console.error(error);
        throw new Error('Error de conexión');
    });
}

export function eliminarUsuario(session, usuario) {
    const botonAlerta = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success me-3',
            cancelButton: 'btn btn-danger'
        }
    });

    botonAlerta.fire({
        title: 'Borrar cuenta',
        text: '¿Quieres eliminar tu cuenta?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check"></i> Confirmar',
        cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar'
    }).then((res) => {
        if (res.isConfirmed) {
            const url = 'api/eliminarCuenta';
            axios({
                method: 'DELETE',
                url: url,
                data: { id: usuario },
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function (res) {
                if (res.data != 1) {
                    mostrarAlerta('Cuenta no eliminada', 'error');
                } else {
                    window.setTimeout(function () {
                        window.location.href = "/";
                        setTimeout(function () {
                            session.$store.commit('SET_ID', -1);
                            session.$store.commit('SET_USER', null);
                            session.$store.commit('SET_AUTHENTICATED', false);
                            session.$store.commit('SET_ROL', '0');
                            session.$store.commit('SET_IMAGE', '/img/usuario/icono.png');
                        }, 0);
                    }, 200);
                }

            }).catch(function (error) {
                mostrarAlerta('Error de conexión', 'error');
                console.error(error);
            });


        } else {
            mostrarAlerta('Operación cancelada', 'info');
        }
    });
}

export function logout(session) {
    window.setTimeout(function () {
        window.location.href = "/";
    }.bind(this), 0);
    session.$store.commit('SET_ID', -1);
    session.$store.commit('SET_USER', null);
    session.$store.commit('SET_AUTHENTICATED', false);
    session.$store.commit('SET_ROL', '0');
    session.$store.commit('SET_IMAGE', '/img/usuario/icono.png');
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

export function cambiarImagen(id, imagen) {
    const formData = new FormData();
    formData.append('imagen', imagen);
    const url = '/api/cambiarImagen/' + id;
    formData.append('_method', 'PUT');
    axios({
        method: 'POST',
        url: url,
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(function (res) {
        var estado = res.status;
        if (estado == 200 || estado == 201) {
            if (res.data != 1) {
                mostrarAlerta('Error al cambiar la foto de perfil', 'error');
            } else {
                window.setTimeout(function () {
                    window.location.href = "/datosUsuario"
                }, 0);
            }
        } else {
            mostrarAlerta('Sin respuesta', 'error')
        }
    }).catch(function (error) {
        mostrarAlerta('Error de conexión', 'error');
        console.error(error);
    });
}

export function registro(parametros, session) {

    axios({
        method: 'POST',
        url: '/api/cuenta',
        data: parametros,

    }).then(function (res) {
        var estado = res.status;
        if (estado == 200 || estado == 201) {
            if (Array.isArray(res.data) && typeof res.data[0] != 'number') {
                mostrarAlerta(res.data.join('\n'), 'error');
            } else {
                session.$store.commit('SET_ID', res.data[0]);
                session.$store.commit('SET_USER', parametros.correo);
                session.$store.commit('SET_AUTHENTICATED', true);
                session.$store.commit('SET_ROL', '0');
                session.$store.commit('SET_IMAGE', res.data[1]);
                window.setTimeout(function () {
                    window.location.href = "/coros"
                }, 500);
            }
        } else {
            mostrarAlerta('Sin respuesta', 'error')
        }
    }).catch(function (error) {
        mostrarAlerta('Error de conexión', 'error');
        console.error(error);
    });
}