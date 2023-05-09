<template>
  <div class="row mt-3">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-primary text-white text-center">
          Detalle del coro
        </div>
        <div class="card-body">

          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
            <label v-text="nombre" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-city"></i></span>
            <label v-text="ciudad" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
            <label v-text="direccion" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
            <label v-text="tipo" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-guitar"></i></span>
            <label v-text="estilo" class="form-control"></label>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 mx-auto my-3">
      <router-link :to="{ path: '/' }" class='btn btn-danger'>
        <i class="fa-solid fa-arrow-left"></i> Volver
      </router-link>
    </div>
  </div>
</template>

<script>

document.title = 'Chorus - Ver Coro';

import { useRoute } from "vue-router";
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: 0,
      nombre: '',
      ciudad: '',
      direccion: '',
      tipo: '',
      estilo: '',
      url: '/api/coros',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getCoro();
  },
  methods: {
    getCoro() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.nombre;
          this.ciudad = res.data.ciudad;
          this.direccion = res.data.direccion;
          this.tipo = res.data.tipo;
          this.estilo = res.data.estilo;
        }
      );
    },
  },
};
</script>