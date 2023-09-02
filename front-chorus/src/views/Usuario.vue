<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span class="h1 text-white">Mi perfil</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-md-2 offset-md-2 align-items-center icono">
        <div class="d-flex justify-content-center mb-3">
          <img :src=foto alt="Icono" class="img-fluid">
        </div>
        <div class="d-flex justify-content-center">
          <button @click="editarFoto" class="btn btn-warning mt-2">Editar imagen</button>
        </div>
      </div>
      <div class="col-md-5 offset-md-1">
        <div class="bloque">
          <form class="form" v-on:submit="editarPerfil()">
            <div class="mb-3">
              <span>Nombre:</span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre" class="form-control">
            </div>
            <div class="mb-3">
              <span>Apellidos:</span>
              <input type="text" required v-model="apellidos" id="apellidos" placeholder="Apellidos" class="form-control">
            </div>
            <div class="mb-3">
              <span>Direcci&oacute;n:</span>
              <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección" class="form-control">
            </div>
            <div class="mb-3">
              <span>Tel&eacute;fono:</span>
              <input type="text" required v-model="telefono" id="telefono" placeholder="Teléfono" class="form-control">
            </div>
            <div class="mb-3">
              <span>Correo electr&oacute;nico:</span>
              <input type="email" required v-model="correo" id="correo" placeholder="Correo" class="form-control">
            </div>
            <div class="mb-3">
              <span>Fecha de nacimiento:</span>
              <input type="date" required v-model="fechaNacimiento" id="fechaNacimiento" placeholder="Fecha Nacimiento"
                class="form-control">
            </div>
            <div class="d-flex justify-content-center">
              <div class="m-3"><button class="btn btn-warning">Guardar cambios</button></div>
              <div class="m-3">
                <router-link :to="{ path: '/pass' }" class='btn btn-warning'>Cambiar contrase&ntilde;a</router-link>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 d-flex justify-content-center">
          <form @submit.prevent="logout">
            <button class='btn btn-danger'>Cerrar sesi&oacute;n</button>
          </form>
        </div>
        <div class="col-md-6 d-flex justify-content-center">
          <form @submit.prevent="eliminarCuenta">
            <button class='btn btn-danger'>Eliminar cuenta</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div v-else class="titulo">
    <span>Acceso denegado</span>
    <p class="acceso">Inicia sesión para acceder a la aplicación</p>
    <div class="py-5">
      <router-link :to="{ path: '/' }" class="btn btn-danger">
        Volver al inicio
      </router-link>
    </div>
  </div>
</template>

<script>


import axios from "../../axiosConfig";
import { logout, enviarSolicitud, mostrarAlerta, cambiarImagen, eliminarUsuario } from "../funciones.js"

export default {
  data() {
    return {
      id: 0,
      nombre: '',
      apellidos: '',
      direccion: '',
      telefono: '',
      correo: '',
      fechaNacimiento: '',
      foto: '',
      url: '/api/usuario',
      cargando: false,
    };
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      this.id = this.$store.state.id;
      this.url += '/' + this.id;
      this.verPerfil();
    }
    document.title = 'Chorus - Perfil';
  },
  methods: {
    verPerfil() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.direccion = res.data.usuario.direccion;
          this.telefono = res.data.usuario.telefono;
          this.correo = res.data.usuario.correo;
          this.fechaNacimiento = res.data.usuario.fechaNacimiento;
          this.foto = 'http://localhost:8000/' + res.data.usuario.archivo;
        }
      );
    },
    editarFoto() {
      const fileInput = document.createElement('input');
      fileInput.type = 'file';
      fileInput.accept = 'image/*';
      fileInput.addEventListener('change', this.handleFileChange);
      fileInput.click();
    },
    handleFileChange(event) {
      const selectedFile = event.target.files[0];
      if (selectedFile) {
        this.foto = this.foto = URL.createObjectURL(selectedFile);
        cambiarImagen(this.id, selectedFile);

        this.$store.commit('SET_IMAGE', 'img/usuario/usuario' + this.id + '.png');
      }
    },
    editarPerfil() {
      event.preventDefault();
      this.cargando = true;
      if (this.nombre.trim() === '') {
        mostrarAlerta('Ingrese un nombre', 'warning', 'nombre')
      } else if (this.apellidos.trim() === '') {
        mostrarAlerta('Ingrese apellidos', 'warning', 'apellidos')
      } else if (this.direccion.trim() === '') {
        mostrarAlerta('Ingrese una dirección', 'warning', 'direccion')
      } else if (this.telefono.trim() === '') {
        mostrarAlerta('Ingrese un teléfono', 'warning', 'telefono')
      } else if (this.correo.trim() === '') {
        mostrarAlerta('Ingrese un correo', 'warning', 'correo')
      } else if (this.fechaNacimiento.trim() === '') {
        mostrarAlerta('Ingrese una fecha', 'warning', 'fechaNacimiento')
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          apellidos: this.apellidos.trim(),
          direccion: this.direccion.trim(),
          telefono: this.telefono.trim(),
          correo: this.correo.trim(),
          fechaNacimiento: this.fechaNacimiento.trim(),
        };
        enviarSolicitud('PUT', parametros, this.url, 'Perfil actualizado', 'datosUsuario');
        this.$store.commit('SET_USER', this.correo);
      }
    },
    logout() {
      logout(this);
    },
    eliminarCuenta() {
      eliminarUsuario(this, this.$store.state.id);
    }
  },
};
</script>