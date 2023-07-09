<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Partitura {{ nombre }}</span>
  </div>
  <div class="row g-0">
    <div class="col-md-1"></div>
    <div class="m-4 col-md-6">
      <iframe :src="archivo" type="application/pdf" width="100%" height="1000px" />
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-3 d-flex align-items-center">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Detalle de la partitura
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
            <label v-text="nombre" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
            <label v-text="autor" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
            <label v-text="anio" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-music"></i></span>
            <label v-text="voces" class="form-control"></label>
          </div>
        </div>
      </div>

    </div>
    <div class="col-md-1"></div>
  </div>
  <div class="col-6 mx-auto my-3">
    <router-link :to="{ path: '/verCoro/' + id }" class='btn btn-danger'>
      <i class="fa-solid fa-arrow-left"></i> Volver
    </router-link>
  </div>
</template>

<script>

document.title = 'Chorus - Ver Partitura';

import { useRoute } from "vue-router";
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: 0,
      idPartitura: 0,
      nombre: '',
      autor: '',
      anio: '',
      voces: '',
      url: '/api/partituras',
      cargando: false,
      currentPage: 1,
      perPage: 5,
      archivo: ''
    };
  },
  computed: {
    totalPages() {
      if (Array.isArray(this.partituras)) {
        return Math.ceil(this.partituras.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItems() {
      if (Array.isArray(this.partituras)) {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        return this.partituras.slice(start, end);
      } else {
        return [];
      }
    },
  },

  methods: {
    getPartitura() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.nombre;
          this.autor = res.data.autor;
          this.anio = res.data.anio;
          this.voces = res.data.voces;
          this.archivo = 'http://localhost:8000/' + res.data.archivo;
          this.id = res.data.idCoro;
        }
      );
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    const route = useRoute();
    this.idPartitura = route.params.id;
    this.url += '/' + this.idPartitura;
    this.getPartitura();
  },
};
</script>