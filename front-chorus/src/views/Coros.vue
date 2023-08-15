<template>
  <div class="ps-5 pt-5">
    <span class="h1 text-white">Coros</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-12">
      <div class="m-4 d-flex flex-wrap justify-content-center" v-if="this.$store.state.rol != '1'">
        <div class="etiqueta m-3" v-for="(coro, i) in this.coros" :key="coro.id">
          <router-link :to="{ path: 'verCoro/' + coro.id }" class="links text-decoration-none">
            <div class="bg-dark text-white cabecera">
              <span class="text-truncate" style="display: block; max-width: 100%;" v-text="coro.nombre" />
            </div>
            <div class="bg-secondary d-flex justify-content-center cuerpo">
              <img class="img-fluid" width="300" :src="'http://localhost:8000/' + coro.archivo">
            </div>
          </router-link>
        </div>
      </div>
      <div class="row g-0">
        <div v-if="this.$store.state.rol == '1'" class="table-responsive borde bloque col-10 offset-1">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">Estilo</th>
                <th scope="col">Fecha creaci&oacute;n</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              <tr v-if="cargando">
                <td colspan="8">
                  <h4>Cargando...</h4>
                </td>
              </tr>
              <tr v-else v-for="(coro, i) in paginatedItems" :key="coro.id">
                <td v-text="coro.nombre"></td>
                <td v-text="coro.tipo"></td>
                <td v-text="coro.estilo"></td>
                <td v-text="new Date(coro.created_at).toLocaleDateString()"></td>
                <td>
                  <div class="d-flex justify-content-center">
                    <router-link :to="{ path: 'verCoro/' + coro.id }" class="btn btn-info mx-3">
                      <i class="fa-solid fa-eye"></i>
                    </router-link>
                    <router-link v-if="this.$store.state.rol === '1'" :to="{ path: 'editarCoro/' + coro.id }"
                      class="btn btn-warning mx-3">
                      <i class="fa-solid fa-edit"></i>
                    </router-link>
                    <button v-if="this.$store.state.rol === '1'" v-on:click="eliminar(coro.id, coro.nombre)"
                      class="btn btn-danger mx-3">
                      <i class="fa-solid fa-trash"></i>
                    </button>
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
  </div>
</template>

<script>



import axios from "../../axiosConfig";
import { confirmar } from '../funciones';

export default {
  data() {
    return {
      coros: null,
      cargando: false,
      currentPage: 1,
      perPage: 5,
    };
  },
  computed: {
    totalPages() {
      if (Array.isArray(this.coros)) {
        return Math.ceil(this.coros.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItems() {
      if (Array.isArray(this.coros)) {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        return this.coros.slice(start, end);
      } else {
        return [];
      }
    },
  },

  methods: {
    listaCoros() {
      this.cargando = true;
      var ruta = '/api/coros';
      if (this.$store.state.rol != 0) {
        ruta = '/api/corosUsuario/' + this.$store.state.id
      }
      console.log(this.$store.state.rol);
      axios.get(ruta).then(
        res => {
          this.coros = res.data;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    eliminar(id, nombre) {
      confirmar('/api/coros/', id, 'Eliminar coro', 'Confirmar eliminación del coro ' + nombre, 'coros');
      this.cargando = false;
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    this.listaCoros();
    document.title = 'Chorus - Coros';
  },
};
</script>
