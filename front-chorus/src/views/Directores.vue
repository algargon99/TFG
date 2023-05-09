<template>
  <div class="row my-5">
    <div class="col-lg-8 offset-lg-2">
      <div class="table-responsive bg-white borde">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Nº</th>
              <th scope="col">Nombre</th>
              <th scope="col">Apellidos</th>
              <th scope="col">Direcci&oacute;n</th>
              <th scope="col">Tel&eacute;fono</th>
              <th scope="col">Fecha nacimiento</th>
              <th scope="col">Escuela</th>
              <th scope="col">Fecha incorporaci&oacute;n</th>
              <th scope="col">Ver</th>
              <th scope="col">Editar</th>
              <th scope="col">Borrar</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="this.cargando">
              <td colspan="9">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="(director, i) in paginatedItems" :key="director.id">
              <td v-text="(i + 1)"></td>
              <td v-text="director.usuario.nombre"></td>
              <td v-text="director.usuario.apellidos"></td>
              <td v-text="director.usuario.direccion"></td>
              <td v-text="director.usuario.telefono"></td>
              <td v-text="director.usuario.fechaNacimiento"></td>
              <td v-text="director.escuela"></td>
              <td v-text="new Date(director.created_at).toLocaleDateString()"></td>
              <td>
                <router-link :to="{ path: 'verDirector/' + director.id }" class="btn btn-info">
                  <i class="fa-solid fa-eye"></i>
                </router-link>
              </td>
              <td>
                <router-link :to="{ path: 'editarDirector/' + director.id }" class="btn btn-warning">
                  <i class="fa-solid fa-edit"></i>
                </router-link>
              </td>
              <td>
                <button v-on:click="eliminar(director.id, director.usuario.nombre, director.usuario.apellidos)"
                  class="btn btn-danger">
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

document.title = 'Chorus - Directores';

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
    eliminar(id, nombre, apellidos) {
      confirmar('/api/directores/', id, 'Eliminar director', 'Confirmar eliminación del director ' + nombre + ' ' + apellidos, "directores");
      this.cargando = false;
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    this.listaDirectores();
  },
};
</script>
  