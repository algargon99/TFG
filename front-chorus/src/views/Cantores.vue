<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Lista de cantores</span>
  </div>
  <div class="row my-5 g-0">
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
              <th scope="col">Voz</th>
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
            <tr v-else v-for="(cantor, i) in paginatedItems" :key="cantor.id">
              <td v-text="(i + 1)"></td>
              <td v-text="cantor.usuario.nombre"></td>
              <td v-text="cantor.usuario.apellidos"></td>
              <td v-text="cantor.usuario.direccion"></td>
              <td v-text="cantor.usuario.telefono"></td>
              <td v-text="cantor.usuario.fechaNacimiento"></td>
              <td v-text="cantor.voz"></td>
              <td v-text="new Date(cantor.created_at).toLocaleDateString()"></td>
              <td>
                <router-link :to="{ path: 'verCantor/' + cantor.id }" class="btn btn-info">
                  <i class="fa-solid fa-eye"></i>
                </router-link>
              </td>
              <td>
                <router-link :to="{ path: 'editarCantor/' + cantor.id }" class="btn btn-warning">
                  <i class="fa-solid fa-edit"></i>
                </router-link>
              </td>
              <td>
                <button v-on:click="eliminar(cantor.id, cantor.usuario.nombre, cantor.usuario.apellidos)"
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

document.title = 'Chorus - Cantores';

import axios from "../../axiosConfig";
import { confirmar } from '../funciones';

export default {
  data() {
    return {
      cantores: null,
      cargando: false,
      currentPage: 1,
      perPage: 5,
    };
  },
  computed: {
    totalPages() {
      if (Array.isArray(this.cantores)) {
        return Math.ceil(this.cantores.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItems() {
      if (Array.isArray(this.cantores)) {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        return this.cantores.slice(start, end);
      } else {
        return [];
      }
    },
  },
  methods: {
    listaCantores() {
      this.cargando = true;
      axios.get('/api/cantores').then(
        res => {
          this.cantores = res.data;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    eliminar(id, nombre, apellidos) {
      confirmar('/api/cantores/', id, 'Eliminar cantor', 'Confirmar eliminación del cantor ' + nombre + ' ' + apellidos,"cantores");
      this.cargando = false;
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    this.listaCantores();
  },
};
</script>
  