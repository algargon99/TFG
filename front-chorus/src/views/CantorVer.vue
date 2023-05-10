<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">{{nombre}} {{apellidos}}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-primary text-white text-center">
          Detalle del cantor
        </div>
        <div class="card-body">

          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
            <label v-text="nombre" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
            <label v-text="apellidos" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
            <label v-text="direccion" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
            <label v-text="telefono" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
            <label v-text="correo" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
            <label v-text="fechaNacimiento" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-music"></i></span>
            <label v-text="voz" class="form-control"></label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 mx-auto my-3">
      <router-link :to="{ path: '/cantores' }" class='btn btn-danger'>
        <i class="fa-solid fa-arrow-left"></i> Volver
      </router-link>
    </div>
  </div>
</template>

<script>

document.title = 'Chorus - Ver Cantor';

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
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getCantor();
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