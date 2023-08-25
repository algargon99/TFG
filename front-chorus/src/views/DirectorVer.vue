<template>
  <div class="titulo">
    <span class="h1 text-white">Director {{ nombre }} {{ apellidos }}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-10 offset-1 bloque row">
      <div class="col-12 col-lg-6">
        <div class="mb-3">
          <span>Nombre:</span>
          <label class="form-control bg-dark text-white">{{ nombre }} {{ apellidos }}</label>
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
          <span>Escuela:</span>
          <label v-text="escuela" class="form-control bg-dark text-white"></label>
        </div>
      </div>
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
      escuela: '',
      url: '/api/directores',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getDirector();
    document.title = 'Chorus - Ver Director';
  },
  methods: {
    getDirector() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.direccion = res.data.usuario.direccion;
          this.telefono = res.data.usuario.telefono;
          this.correo = res.data.usuario.correo;
          this.fechaNacimiento = res.data.usuario.fechaNacimiento;
          this.escuela = res.data.escuela;
        }
      );
    },
  },
};
</script>