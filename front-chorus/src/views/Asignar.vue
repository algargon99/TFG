<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Lista de usuarios</span>
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
              <th scope="col">Correo</th>
              <th scope="col">Fecha incorporaci&oacute;n</th>
              <th scope="col">Asignar coro</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="this.cargando">
              <td colspan="9">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-if="!this.cargando && this.filtroUsuarios == null">
              <td colspan="9">
                <h4>No se han encontrado usuarios</h4>
              </td>
            </tr>
            <tr v-else v-for="(usuario, i) in paginatedItems" :key="usuario.id">
              <td v-text="(i + 1)"></td>
              <td v-text="usuario.nombre"></td>
              <td v-text="usuario.apellidos"></td>
              <td v-text="usuario.correo"></td>
              <td v-text="new Date(usuario.created_at).toLocaleDateString()"></td>
              <td>
                <router-link :to="{ path: 'asignarUsuario/' + usuario.id }" class="btn btn-info">
                  <i class="fa-solid fa-link"></i>
                </router-link>
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
        <div class="input-group">
          <span class="input-group-text"><i class="fa-solid fa-envelope"></i> &nbsp; Filtrar por correo: </span>
          <input type="text" class="form-control" v-model="buscador" @input="filtroUsers" placeholder="Buscar por correo electrónico">
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>



import axios from "../../axiosConfig";

export default {
  data() {
    return {
      usuarios: null,
      buscador: '',
      filtroUsuarios: null,
      cargando: false,
      currentPage: 1,
      perPage: 5,
    };
  },
  computed: {
    totalPages() {
      if (Array.isArray(this.filtroUsuarios)) {
        return Math.ceil(this.filtroUsuarios.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItems() {
      if (Array.isArray(this.filtroUsuarios)) {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        return this.filtroUsuarios.slice(start, end);
      } else {
        return [];
      }
    },
  },
  methods: {
    listaUsuarios() {
      this.cargando = true;
      axios.get('/api/usuarios').then(
        res => {
          this.usuarios = res.data;
          this.filtroUsuarios = this.usuarios;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    changePage(page) {
      this.currentPage = page;
    },
    filtroUsers() {
      if (this.buscador === '') {
        this.filtroUsuarios = this.usuarios;
      } else {
        this.filtroUsuarios = this.usuarios.filter(usuario => usuario.correo.includes(this.buscador));
      }
      this.currentPage = 1;
    },
  },
  mounted() {
    this.listaUsuarios();
    document.title = 'Chorus - Asignar usuarios a coros';
  },
};
</script>
  