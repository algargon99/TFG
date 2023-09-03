<template>
  <div v-if="this.$store.state.isAuthenticated == true  && this.$store.state.rol == 1 ">
    <div class="titulo">
      <span class="h1 text-white">Lista de cantores</span>
    </div>
    <div class="row my-5 g-0">
      <div class="col-lg-10 offset-lg-1">
        <div class="table-responsive bloque borde">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Voz</th>
                <th scope="col">Fecha incorporaci&oacute;n</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              <tr v-if="this.cargando">
                <td colspan="9">
                  <h4>Cargando...</h4>
                </td>
              </tr>
              <tr v-else v-for="(cantor, i) in paginatedItems" :key="cantor.id">
                <td>{{ cantor.usuario.nombre }} {{ cantor.usuario.apellidos }}</td>
                <td v-text="cantor.usuario.correo"></td>
                <td v-text="cantor.voz"></td>
                <td v-text="new Date(cantor.created_at).toLocaleDateString()"></td>
                <td>
                  <div class="d-flex justify-content-center">
                    <div class="mx-2">
                      <router-link :to="{ path: 'verCantor/' + cantor.id }" class="btn btn-info">
                        <i class="fa-solid fa-eye"></i>
                      </router-link>
                    </div>
                    <div class="mx-2">
                      <router-link :to="{ path: 'editarCantor/' + cantor.id }" class="btn btn-warning">
                        <i class="fa-solid fa-edit"></i>
                      </router-link>
                    </div>
                    <div class="mx-2">
                      <button v-on:click="eliminarCantor(cantor.id, cantor.usuario.nombre, cantor.usuario.apellidos)"
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
  </div>
  <div v-else class="titulo">
    <span>Acceso denegado</span>
    <p class="acceso">No tienes permiso para acceder a esta página</p>
    <div class="py-5">
      <router-link :to="{ path: '/' }" class="btn btn-danger">
        Volver al inicio
      </router-link>
    </div>
  </div>
</template>
  
<script>



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
    eliminarCantor(id, nombre, apellidos) {
      confirmar('/api/cantores/', id, 'Eliminar cantor', 'Confirmar eliminación del cantor ' + nombre + ' ' + apellidos, "cantores");
      this.cargando = false;
    },
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      this.listaCantores();
    }
    document.title = 'Chorus - Cantores';
  },
};
</script>
  