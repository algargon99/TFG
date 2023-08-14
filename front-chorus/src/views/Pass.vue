<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Cambio de contrase&ntilde;a</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Cambiar contrase&ntilde;a
        </div>
        <div class="card-body">
          <form class="form" v-on:submit="cambiarPass()">
            <div class="input-group mb-3">
              <span class="input-group-text">Contrase&ntilde;a actual</span>
              <input type="password" required v-model="pass" id="pass" placeholder="Contraseña actual"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Contrase&ntilde;a nueva</span>
              <input type="password" required v-model="newpass" id="newpass" placeholder="Nueva contraseña"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">Repetir contrase&ntilde;a nueva</span>
              <input type="password" required v-model="renewpass" id="renewpass" placeholder="Repetir contraseña"
                class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-warning"><i class="fa-solid fa-refresh"></i> Actualizar contrase&ntilde;a</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-6 mx-auto my-3">
      <router-link :to="{ path: '/datosUsuario' }" class='btn btn-danger'>
        <i class="fa-solid fa-arrow-left"></i> Volver
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
    this.url += '/' + this.id;
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