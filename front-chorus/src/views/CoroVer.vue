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
            <span class="input-group-text"><i class="fa-solid fa-users"></i>&nbsp; Nombre</span>
            <label v-text="nombre" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-city"></i>&nbsp; Ciudad</span>
            <label v-text="ciudad" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-location-dot"></i>&nbsp; Direcci&oacute;n</span>
            <label v-text="direccion" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-users"></i>&nbsp; Tipo</span>
            <label v-text="tipo" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-guitar"></i>&nbsp; Estilo</span>
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
              <th v-if="this.$store.state.rol != '3'" scope="col">Editar</th>
              <th v-if="this.$store.state.rol != '3'" scope="col">Borrar</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="(partitura, i) in paginatedItemsPartituras" :key="partitura.id">
              <td v-text="(i + 1)"></td>
              <td v-text="partitura.nombre"></td>
              <td v-text="partitura.anio"></td>
              <td v-text="partitura.voces"></td>
              <td>
                <router-link :to="{ path: '/verPartitura/' + partitura.id }" class="btn btn-info">
                  <i class="fa-solid fa-eye"></i>
                </router-link>
              </td>
              <td v-if="this.$store.state.rol != '3'">
                <router-link :to="{ path: '/editarPartitura/' + partitura.id }" class="btn btn-warning">
                  <i class="fa-solid fa-edit"></i>
                </router-link>
              </td>
              <td v-if="this.$store.state.rol != '3'">
                <button v-on:click="eliminar(partitura.id, partitura.nombre)" class="btn btn-danger">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item" v-for="page in totalPagesPartituras" :key="page"
              :class="{ active: page === currentPagePartitura }">
              <a @click="changePagePartituras(page)" class="page-link" href="#">{{ page }}</a>
            </li>
          </ul>
        </div>
        <div v-if="this.$store.state.rol != '3'" class="d-flex justify-content-center">
          <router-link :to="{ path: '/crearPartitura/' + this.id }" class='btn btn-primary'>
            <i class="fa-solid fa-archive"></i> Nueva partitura
          </router-link>
        </div>
      </div>
    </div>
  </div>

  <div class="titulo ps-5 pt-4">
    <span class="h1 text-white">Cantores del coro {{ nombre }}</span>
  </div>
  <div class="row g-0 my-5">
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
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="(cantor, i) in paginatedItemsCantores" :key="cantor.id">
              <td v-text="(i + 1)"></td>
              <td v-text="cantor.nombre"></td>
              <td v-text="cantor.apellidos"></td>
              <td v-text="cantor.direccion"></td>
              <td v-text="cantor.telefono"></td>
              <td v-text="cantor.fechaNacimiento"></td>
              <td v-text="cantor.cantor.voz"></td>
              <td v-text="new Date(cantor.created_at).toLocaleDateString()"></td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item" v-for="page in totalPagesCantores" :key="page"
              :class="{ active: page === currentPageCantor }">
              <a @click="changePageCantores(page)" class="page-link" href="#">{{ page }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="titulo ps-5 pt-4">
    <span class="h1 text-white">Directores del coro {{ nombre }}</span>
  </div>
  <div class="row g-0 my-5">
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
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="(director, i) in paginatedItemsDirectores" :key="director.id">
              <td v-text="(i + 1)"></td>
              <td v-text="director.nombre"></td>
              <td v-text="director.apellidos"></td>
              <td v-text="director.direccion"></td>
              <td v-text="director.telefono"></td>
              <td v-text="director.fechaNacimiento"></td>
              <td v-text="director.director.voz"></td>
              <td v-text="new Date(director.created_at).toLocaleDateString()"></td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item" v-for="page in totalPagesDirectores" :key="page"
              :class="{ active: page === currentPageDirector }">
              <a @click="changePageDirectores(page)" class="page-link" href="#">{{ page }}</a>
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



import { useRoute } from "vue-router";
import { confirmar } from '../funciones';
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
      cantores: null,
      directores: null,
      currentPagePartitura: 1,
      currentPageCantor: 1,
      currentPageDirector: 1,
      perPage: 5,

    };
  },
  computed: {
    totalPagesPartituras() {
      if (Array.isArray(this.partituras)) {
        return Math.ceil(this.partituras.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItemsPartituras() {
      if (Array.isArray(this.partituras)) {
        const start = (this.currentPagePartitura - 1) * this.perPage;
        const end = start + this.perPage;
        return this.partituras.slice(start, end);
      } else {
        return [];
      }
    },
    totalPagesCantores() {
      if (Array.isArray(this.cantores)) {
        return Math.ceil(this.cantores.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItemsCantores() {
      if (Array.isArray(this.cantores)) {
        const start = (this.currentPageCantor - 1) * this.perPage;
        const end = start + this.perPage;
        return this.cantores.slice(start, end);
      } else {
        return [];
      }
    },
    totalPagesDirectores() {
      if (Array.isArray(this.directores)) {
        return Math.ceil(this.directores.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItemsDirectores() {
      if (Array.isArray(this.directores)) {
        const start = (this.currentPageDirector - 1) * this.perPage;
        const end = start + this.perPage;
        return this.directores.slice(start, end);
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
      confirmar('/api/partituras/', idPartitura, 'Eliminar partitura', 'Confirmar eliminación de partitura ' + nombre, 'partituras');
      this.cargando = false;
    },
    changePagePartituras(page) {
      this.currentPagePartitura = page;
    },
    changePageCantores(page) {
      this.currentPageCantor = page;
    },
    changePageDirectores(page) {
      this.currentPageDirector = page;
    },
    listaCantores() {
      this.cargando = true;
      axios.get('/api/cantoresCoro/' + this.id).then(
        res => {
          this.cantores = res.data;
          console.log(this.cantores);
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },

    listaDirectores() {
      this.cargando = true;
      axios.get('/api/directoresCoro/' + this.id).then(
        res => {
          this.directores = res.data;
          console.log(this.directores);
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
  },


  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getCoro();
    this.listaPartituras();
    this.listaCantores();
    this.listaDirectores();
    document.title = 'Chorus - Ver Coro';
  },
};
</script>