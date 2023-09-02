<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span class="h1 text-white">Cantor {{ nombre }} {{ apellidos }}</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-10 row offset-1 bloque">
        <div class="col-12 col-lg-6">
          <div class="mb-3">
            <span>Nombre:</span>
            <label class="form-control bg-dark text-white"> {{ nombre }} {{ apellidos }}</label>
          </div>
          <div class="mb-3">
            <span>Direcci&oacute;n:</span>
            <label v-text="direccion" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>Tel&eacute;fono:</span>
            <label v-text="telefono" class="form-control bg-dark text-white"></label>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="mb-3">
            <span>Correo electr&oacute;nico:</span>
            <label v-text="correo" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>Fecha de nacimiento:</span>
            <label v-text="fechaNacimiento" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>Voz:</span>
            <label v-text="voz" class="form-control bg-dark text-white"></label>
          </div>
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



import { useRoute } from "vue-router";
import axios from "../../axiosConfig";

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
      voz: '',
      url: '/api/cantores',
      cargando: false,
    };
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      const route = useRoute();
      this.id = route.params.id;
      this.url += '/' + this.id;
      this.getCantor();
    }
    document.title = 'Chorus - Ver Cantor';
  },
  methods: {
    getCantor() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.direccion = res.data.usuario.direccion;
          this.telefono = res.data.usuario.telefono;
          this.correo = res.data.usuario.correo;
          this.fechaNacimiento = res.data.usuario.fechaNacimiento;
          this.voz = res.data.voz;
        }
      );
    },
  },
};
</script>