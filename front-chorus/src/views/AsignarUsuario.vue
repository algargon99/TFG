<template>
  <div v-if="this.$store.state.isAuthenticated == true && (this.$store.state.rol == 1 || this.$store.state.rol == 2)">
    <div class="titulo">
      <span class="h1 text-white">Asignar coro al usuario </span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-md-4 offset-md-4 bloque">
        <form v-on:submit="asignar()" class="form">
          <div class="mb-3">
            <span>Nombre: </span>
            <label v-text="nombre" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>Apellidos: </span>
            <label v-text="apellidos" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>Correo:</span>
            <label v-text="correo" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <label for="coro" class="form-label">Coro:</label>
            <select class="form-control" id="coro" v-model="coro" required>
              <option class="text-black" v-for="ncoro in coros" :key="ncoro.id" :value="ncoro.id">{{ ncoro.nombre }}
              </option>
            </select>
          </div>
          <div v-if="existe == false">
            <div v-if="this.$store.state.rol == '1'" class="mb-3">
              <span>Rol: </span>
              <input class="m-3" type="radio" v-model="rol" value="cantor" checked>Cantor
              <input class="m-3" type="radio" v-model="rol" value="director">Director
            </div>
            <div class="mb-3" v-if="rol === 'cantor'">
              <label>Voz:</label>
              <input type="text" v-model="voz" id="voz" placeholder="Voz del cantor" class="form-control">
            </div>
            <div class="mb-3" v-else-if="rol === 'director'">
              <label>Escuela:</label>
              <input type="text" v-model="escuela" id="escuela" placeholder="Escuela del director" class="form-control">
            </div>
          </div>
          <div class="d-grid col-3 mx-auto my-3">
            <button class="btn btn-warning">Asignar coro</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div v-else class="titulo">
    <span>Acceso denegado</span>
    <p class="acceso">No tienes permiso para acceder a esta página</p>
    <div class="py-5">
      <router-link :to="{ path: '/' }" class="btn btn-danger">
        Volver al inicio
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
      existe: false,
      rol: 'cantor',
      voz: '',
      escuela: '',
      coros: null,
      url: '/api/asignarCoro',
      cargando: false,
    };
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      const route = useRoute();
      this.id = route.params.id;
      this.getUsuario();
      this.getCoros();
    }
    document.title = 'Chorus - Asignar coro al usuario';
  },
  methods: {
    getUsuario() {
      axios.get('/api/usuario/' + this.id).then(
        res => {
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.correo = res.data.usuario.correo;
          if (res.data.cantor || res.data.director) {
            this.existe = true;
          } else {
            this.existe = false;
          }
        }
      );
    },
    getCoros() {
      var ruta = '/api/coros';
      if (this.$store.state.rol != 0) {
        ruta = '/api/corosUsuario/' + this.$store.state.id
      }
      axios.get(ruta).then(
        res => {
          if (this.$store.state.rol == 1) {
            this.coros = res.data;
          } else {
            this.coros = res.data.corosUsuario;
          }
          this.coros.sort((a, b) => a.nombre.localeCompare(b.nombre));
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
        rol: this.rol,
        voz: this.voz,
        escuela: this.escuela
      };
      enviarSolicitud('POST', parametros, this.url, 'Asignación completada', 'asignar');

    },
  },
};
</script>