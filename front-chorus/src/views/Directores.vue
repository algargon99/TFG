<template>
  <div class="titulo">
    <span class="h1 text-white">Lista de directores</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-10 offset-1">
      <div class="table-responsive bloque borde">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Correo</th>
              <th scope="col">Escuela</th>
              <th scope="col">Fecha incorporaci&oacute;n</th>

            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="this.cargando">
              <td colspan="9">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="(director, i) in paginatedItems" :key="director.id">

              <td>{{ director.usuario.nombre }} {{ director.usuario.apellidos }}</td>
              <td v-text="director.usuario.correo"></td>
              <td v-text="director.escuela"></td>
              <td v-text="new Date(director.created_at).toLocaleDateString()"></td>
              <td>
                <div class="d-flex justify-content-center">
                  <div class="mx-3">
                    <router-link :to="{ path: 'verDirector/' + director.id }" class="btn btn-info">
                      <i class="fa-solid fa-eye"></i>
                    </router-link>
                  </div>
                  <div class="mx-3">
                    <router-link :to="{ path: 'editarDirector/' + director.id }" class="btn btn-warning">
                      <i class="fa-solid fa-edit"></i>
                    </router-link>
                  </div>
                  <div class="mx-3">
                    <button v-on:click="eliminarDirector(director.id, director.usuario.nombre, director.usuario.apellidos)"
                      class="btn btn-danger">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </div>
                </div>
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
</template>
  
<script>



import axios from "../../axiosConfig";
import { confirmar } from '../funciones';

export default {
  data() {
    return {
      directores: null,
      cargando: false,
      currentPage: 1,
      perPage: 5,
    };
  },
  computed: {
    totalPages() {
      if (Array.isArray(this.directores)) {
        return Math.ceil(this.directores.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItems() {
      if (Array.isArray(this.directores)) {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        return this.directores.slice(start, end);
      } else {
        return [];
      }
    },
  },
  methods: {
    listaDirectores() {
      this.cargando = true;
      axios.get('/api/directores').then(
        res => {
          this.directores = res.data;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    eliminarDirector(id, nombre, apellidos) {
      confirmar('/api/directores/', id, 'Eliminar director', 'Confirmar eliminación del director ' + nombre + ' ' + apellidos, "directores");
      this.cargando = false;
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    this.listaDirectores();
    document.title = 'Chorus - Directores';
  },
};
</script>
  