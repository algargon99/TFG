<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span class="h1 text-white">Cambio de contrase&ntilde;a</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-md-4 offset-md-4 bloque">
        <form class="form" v-on:submit="cambiarPass()">
          <div class="mb-3">
            <span>Contrase&ntilde;a actual:</span>
            <input type="password" required v-model="pass" id="pass" placeholder="Contraseña actual" class="form-control">
          </div>
          <div class="mb-3">
            <span>Contrase&ntilde;a nueva:</span>
            <input type="password" required v-model="newpass" id="newpass" placeholder="Nueva contraseña"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>Repetir contrase&ntilde;a nueva:</span>
            <input type="password" required v-model="renewpass" id="renewpass" placeholder="Repetir contraseña"
              class="form-control">
          </div>
          <div class="d-grid col-4 mx-auto py-3">
            <button class="btn btn-warning">Actualizar contrase&ntilde;a</button>
          </div>
        </form>
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


import { mostrarAlerta, enviarSolicitud } from '../funciones';
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: this.$store.state.id,
      pass: '',
      newpass: '',
      renewpass: '',
      url: '/api/cambiarPass',
      cargando: false,
    };
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      this.url += '/' + this.id;
    }
    document.title = 'Chorus - Cambiar contraseña';
  },
  methods: {
    cambiarPass() {
      event.preventDefault();
      this.cargando = true;
      if (this.pass.trim() === '') {
        mostrarAlerta('Ingrese la contraseña actual', 'warning', 'pass')
      } else if (this.newpass.trim() === '') {
        mostrarAlerta('Ingrese nueva contraseña', 'warning', 'newpass')
      } else if (this.renewpass.trim() === '') {
        mostrarAlerta('Ingrese la contraseña nueva repetida', 'warning', 'renewpass')
      } else if (this.renewpass.trim() != this.newpass.trim()) {
        mostrarAlerta('Las contraseñas indicadas no son iguales', 'warning', 'newpass')
      } else {
        var parametros = {
          pass: this.pass.trim(),
          newpass: this.newpass.trim(),
          renewpass: this.renewpass.trim(),
        };
        enviarSolicitud('PUT', parametros, this.url, 'Contraseña actualizada', 'datosUsuario');
      }
    },
  },
};
</script>