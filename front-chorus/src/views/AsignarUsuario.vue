<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Asignar coro al usuario </span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Asignar coro
        </div>
        <div class="card-body">
          <form v-on:submit="asignar()" class="form">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
              <label v-text="nombre" class="form-control"></label>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
              <label v-text="apellidos" class="form-control"></label>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
              <label v-text="correo" class="form-control"></label>
            </div>
            <div class="mb-3">
              <label for="coro" class="form-label">Coro</label>
              <select class="form-control" id="coro" v-model="coro" required>
                <option v-for="ncoro in coros" :key="ncoro.id" :value="ncoro.id">{{ ncoro.nombre }}</option>
              </select>
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-warning"><i class="fa-solid fa-refresh"></i> Asignar
                coro</button>
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


import { useRoute } from "vue-router";
import axios from "../../axiosConfig";
import { enviarSolicitud } from '../funciones';

export default {
  data() {
    return {
      id: '',
      nombre: '',
      apellidos: '',
      correo: '',
      coro: '',
      coros: null,
      url: '/api/asignarCoro',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.getUsuario();
    this.getCoros();
    document.title = 'Chorus - Asignar coro al usuario';
  },
  methods: {
    getUsuario() {
      axios.get('/api/usuario/' + this.id).then(
        res => {
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.correo = res.data.usuario.correo;
        }
      );
    },
    getCoros() {
      axios.get('/api/coros').then(
        res => {
          this.coros = res.data;
          this.coro = this.coros[0].id;
        }
      );
    },
    asignar() {
      event.preventDefault();
      this.cargando = true;
      var parametros = {
        usuario: this.id,
        coro: this.coro,
      };
      enviarSolicitud('POST', parametros, this.url, 'Asignación completada', 'asignar');

    },
  },
};
</script>