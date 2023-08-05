<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Mi perfil</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card m-3">
        <div class="card-header bg-dark text-white text-center">
          Mi perfil de usuario
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i>&nbsp; Nombre</span>
            <label v-text="nombre" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i>&nbsp; Apellidos</span>
            <label v-text="apellidos" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-location-dot"></i>&nbsp; Direcci&oacute;n</span>
            <label v-text="direccion" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-phone"></i>&nbsp; Tel&eacute;fono</span>
            <label v-text="telefono" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-envelope"></i>&nbsp; Correo electr&oacute;nico</span>
            <label v-text="correo" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-calendar"></i>&nbsp; Fecha de nacimiento</span>
            <label v-text="fechaNacimiento" class="form-control"></label>
          </div>
          <div v-if="this.$store.state.rol != '1'" class="input-group mb-3">
            <span v-if="this.voz" class="input-group-text"><i class="fa-solid fa-music"></i>&nbsp; Voz</span>
            <label v-if="this.voz" v-text="voz" class="form-control"></label>
            <span v-if="this.escuela" class="input-group-text"><i class="fa-solid fa-city"></i>&nbsp; Escuela</span>
            <label v-if="this.escuela" v-text="escuela" class="form-control"></label>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <router-link :to="{ path: '/editarUsuario' }" class='btn btn-warning m-3'>Editar perfil</router-link>

          <router-link :to="{ path: '/pass' }" class='btn btn-warning m-3'>Cambiar contrase&ntilde;a</router-link>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 d-flex justify-content-center">
        <router-link :to="{ path: '/' }" class='btn btn-danger'>
          <i class="fa-solid fa-arrow-left"></i> Volver
        </router-link>
      </div>
      <div class="col-md-6 d-flex justify-content-center">
        <form @submit.prevent="logout">
          <button class='btn btn-danger'>Cerrar sesi&oacute;n</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>


import axios from "../../axiosConfig";
import { logout } from "../funciones.js"

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
      escuela: null,
      voz: null,
      url: '/api/usuario',
      cargando: false,
    };
  },
  mounted() {
    this.id = this.$store.state.id;
    this.url += '/' + this.id;
    this.getUsuario();
    document.title = 'Chorus - Datos del Usuario';
  },
  methods: {
    getUsuario() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.direccion = res.data.usuario.direccion;
          this.telefono = res.data.usuario.telefono;
          this.correo = res.data.usuario.correo;
          this.fechaNacimiento = res.data.usuario.fechaNacimiento;
          if (res.data.cantor) {
            this.voz = res.data.cantor.voz;
          } else if (res.data.director) {
            this.escuela = res.data.director.escuela;
          }
        }
      );
    },
    logout() {
      logout(this);
    }
  },
};
</script>