<template>
  <div class="titulo">
    <span class="h1 text-white">Coros</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-10 offset-1">
      <div v-if="this.$store.state.rol == '0'">
        <span class="titulito">Conoce a los coros</span>
        <div class="text-white my-5" v-if="cargando">
          <h4>Cargando...</h4>
        </div>
        <div v-if="this.coros.length === 0 && !cargando" class="my-5">
          <h4 class="text-white">No hay coros</h4>
        </div>
        <div v-else class="d-flex flex-wrap">
          <div class="etiqueta m-4" v-for="(coro, i) in this.coros" :key="coro.id">
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
      </div>
      <div v-if="this.$store.state.rol == '2' || this.$store.state.rol == '3'">
        <span class="titulito">Mis coros</span>
        <div class="text-white" v-if="cargando">
          <h4>Cargando...</h4>
        </div>
        <div v-if="this.coros.length === 0 && !cargando" class="my-5">
          <h4 class="text-white my-5">No estás en nigún coro</h4>
        </div>
        <div v-else class="d-flex flex-wrap">
          <div class="etiqueta m-4" v-for="(coro, i) in this.coros" :key="coro.id">
            <router-link :to="{ path: 'verCoro/' + coro.id }" class="links text-decoration-none">
              <div class="bg-dark text-white cabecera">
                <span class="text-truncate" style="display: block; max-width: 100%;" v-text="coro.nombre" />
              </div>
              <div class="bg-secondary d-flex justify-content-center cuerpo">
                <img class="img-fluid" width="300" :src="'http://localhost:8000/' + coro.archivo">
              </div>
            </router-link>
            <div v-if="this.$store.state.rol == '2'" class="d-flex justify-content-center">
              <router-link :to="{ path: 'editarCoro/' + coro.id }" class="btn btn-warning mx-3">
                Editar
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <div v-if="this.$store.state.rol == '2' || this.$store.state.rol == '3'">
        <span class="titulito">Conoce al resto</span>
        <div class="text-white my-5" v-if="cargando">
          <h4>Cargando...</h4>
        </div>
        <div v-if="this.restoCoros.length === 0 && !cargando" class="my-5">
          <h4 class="text-white">No hay más coros</h4>
        </div>
        <div else class="d-flex flex-wrap">
          <div class="etiqueta m-4" v-for="(coro, i) in this.restoCoros" :key="coro.id">
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
      </div>
      <div class="row g-0">
        <div v-if="this.$store.state.rol == '1'">
          <span class="titulito">Lista de coros</span>
          <div class="table-responsive borde bloque col-10 offset-1 p-4">
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
                <tr v-if="!cargando && this.filtroCoro.length == 0">
                  <td colspan="8">
                    <h4>No hay coros disponibles</h4>
                  </td>
                </tr>
                <tr v-if="this.filtroCoro.length != 0" v-for="(coro, i) in paginatedItems" :key="coro.id">
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
                      <button v-if="this.$store.state.rol === '1'" v-on:click="eliminarCoro(coro.id, coro.nombre)"
                        class="btn btn-danger mx-3">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-center">
            <ul class="pagination">
              <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: page === currentPage }">
                <a @click="changePage(page)" class="page-link" href="#">{{ page }}</a>
              </li>
            </ul>
          </div>
          <div class="m-2 d-flex justify-content-center align-items-center">
            <span class="text-white">Filtrar por nombre: </span>
            <input type="text" class="form-control mx-2 w-25" v-model="buscador" @input="filtroCoros"
              placeholder="Buscar por nombre del coro">
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
      coros: [],
      restoCoros: [],
      cargando: false,
      buscador: '',
      filtroCoro: [],
      currentPage: 1,
      perPage: 5,
    };
  },
  computed: {
    totalPages() {
      if (Array.isArray(this.filtroCoro)) {
        return Math.ceil(this.filtroCoro.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItems() {
      if (Array.isArray(this.filtroCoro)) {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        return this.filtroCoro.slice(start, end);
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
      axios.get(ruta).then(
        res => {
          if (this.$store.state.rol == 1 || this.$store.state.rol == 0) {
            this.coros = res.data;
            this.filtroCoro = this.coros;

          } else {
            this.coros = res.data.corosUsuario;
            this.restoCoros = res.data.corosNoUsuario;
          }
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    filtroCoros() {
      if (this.buscador === '') {
        this.filtroCoro = this.coros;
      } else {
        this.filtroCoro = this.coros.filter(coro => coro.nombre.includes(this.buscador));
      }
      this.currentPage = 1;

    },
    eliminarCoro(id, nombre) {
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
