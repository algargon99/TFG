<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Lista de coros</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-lg-8 offset-lg-2">
      <div class="table-responsive bg-white borde">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Nº</th>
              <th scope="col">Nombre</th>
              <th scope="col">Ciudad</th>
              <th scope="col">Direcci&oacute;n</th>
              <th scope="col">Tipo</th>
              <th scope="col">Estilo</th>
              <th scope="col">Fecha creaci&oacute;n</th>
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
            <tr v-else v-for="(coro, i) in paginatedItems" :key="coro.id">
              <td v-text="(i + 1)"></td>
              <td v-text="coro.nombre"></td>
              <td v-text="coro.ciudad"></td>
              <td v-text="coro.direccion"></td>
              <td v-text="coro.tipo"></td>
              <td v-text="coro.estilo"></td>
              <td v-text="new Date(coro.created_at).toLocaleDateString()"></td>
              <td>
                <router-link :to="{ path: 'verCoro/' + coro.id }" class="btn btn-info">
                  <i class="fa-solid fa-eye"></i>
                </router-link>
              </td>
              <td>
                <router-link :to="{ path: 'editarCoro/' + coro.id }" class="btn btn-warning">
                  <i class="fa-solid fa-edit"></i>
                </router-link>
              </td>
              <td>
                <button v-on:click="eliminar(coro.id, coro.nombre)" class="btn btn-danger">
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
</template>

<script>

document.title = 'Chorus - Coros';

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
      axios.get('/api/coros').then(
        res => {
          console.log(res);
          this.coros = res.data;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    eliminar(id, nombre) {
      confirmar('/api/coros/', id, 'Eliminar coro', 'Confirmar eliminación del coro ' + nombre,'coros');
      this.cargando = false;
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    this.listaCoros();
  },
};
</script>
