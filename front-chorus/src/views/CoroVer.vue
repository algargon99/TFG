<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Coro {{ nombre }}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
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
  </div>
  <div class="titulo ps-5 pt-4">
    <span class="h1 text-white">Partituras del coro {{ nombre }}</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-lg-8 offset-lg-2">
      <div class="table-responsive bg-white borde">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Nº</th>
              <th scope="col">Nombre</th>
              <th scope="col">A&ntilde;o</th>
              <th scope="col">Voces</th>
              <th scope="col">Ver</th>
              <th scope="col">Editar</th>
              <th scope="col">Borrar</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="(partitura, i) in paginatedItems" :key="partitura.id">
              <td v-text="(i + 1)"></td>
              <td v-text="partitura.nombre"></td>
              <td v-text="partitura.anio"></td>
              <td v-text="partitura.voces"></td>
              <td>
                <router-link :to="{ path: '/verPartitura/' + partitura.id }" class="btn btn-info">
                  <i class="fa-solid fa-eye"></i>
                </router-link>
              </td>
              <td>
                <router-link :to="{ path: '/editarPartitura/' + partitura.id }" class="btn btn-warning">
                  <i class="fa-solid fa-edit"></i>
                </router-link>
              </td>
              <td>
                <button v-on:click="eliminar(partitura.id, partitura.nombre)" class="btn btn-danger">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: page === currentPage }">
              <a @click="changePage(page)" class="page-link" href="#">{{ page }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 mx-auto my-3">
      <router-link :to="{ path: '/coros' }" class='btn btn-danger'>
        <i class="fa-solid fa-arrow-left"></i> Volver
      </router-link>
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
      partituras: null,
      currentPage: 1,
      perPage: 5,
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
    listaPartituras() {
      this.cargando = true;
      axios.get('/api/coros/' + this.id + '/partituras').then(
        res => {
          this.partituras = res.data;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    eliminar(idPartitura, nombre) {
      confirmar('/api/coros/' + this.id + '/partituras', idPartitura, 'Eliminar partitura', 'Confirmar eliminación de partitura ' + nombre, 'partituras');
      this.cargando = false;
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getCoro();
    this.listaPartituras();
  },
};
</script>