<template>
  <div class="titulo">
    <span>Coro {{ nombre }}</span>
  </div>
  <div class="row my-4 g-0">
    <div class="primero col-10 col-xl-5 d-flex align-items-center justify-content-center">
      <img class="img-fluid mx-auto w-8" :src='archivo' alt="Coro">
    </div>
    <div class="col-xl-5 ms-4 bloque d-flex align-items-center">
      <p class="p-4"> Somos el coro {{ tipo }} de {{ estilo }} {{ nombre }} de la ciudad de {{ ciudad }}.
        {{ descripcion }} <br><br> Nos situamos en {{ direccion }}. Puedes contactarnos a través de la página de contacto.
      </p>
    </div>
  </div>


  <div class="titulo">
    <span class="h1">Directores</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-lg-10 offset-lg-1 bloque d-flex">
      <div v-if="cargando">
        <h4>Cargando...</h4>
      </div>
      <div class="mx-4" v-else v-for="(director, i) in directores" :key="director.id">
        <div>
          <div class="d-flex justify-content-center mb-3">
            <img :src="'http://localhost:8000/' + director.archivo" class="img-fluid" width="150">
          </div>
          <div class="d-flex justify-content-center">
            <span><b>{{ director.nombre }} {{ director.apellidos }}</b></span>
          </div>
          <div class="d-flex justify-content-center">
            <span>{{ director.correo }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="titulo">
    <span class="h1">Cantores</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-lg-10 offset-lg-1">
      <div class="table-responsive borde bloque">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Correo</th>
              <th scope="col">Voz</th>
              <th v-if="this.$store.state.rol === '1' || this.$store.state.rol === '2'" scope="col" class="text-center">
                Fecha incorporaci&oacute;n</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="(cantor, i) in paginatedItemsCantores" :key="cantor.id">
              <td>{{ cantor.nombre }} {{ cantor.apellidos }}</td>
              <td v-text="cantor.correo"></td>
              <td v-text="cantor.cantor.voz"></td>
              <td v-if="this.$store.state.rol === '1' || this.$store.state.rol === '2'"
                v-text="new Date(cantor.created_at).toLocaleDateString()" class="text-center"></td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item" v-for="page in totalPagesCantores" :key="page"
              :class="{ active: page === currentPageCantor }">
              <a @click="changePageCantores(page)" class="page-link">{{ page }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="titulo">
    <span class="h1">Partituras</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-lg-10 offset-lg-1">
      <div class="table-responsive bloque borde p-3">
        <table class="table ">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">A&ntilde;o</th>
              <th scope="col">Voces</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="(partitura, i) in paginatedItemsPartituras" :key="partitura.id">
              <td v-text="partitura.nombre"></td>
              <td v-text="partitura.anio"></td>
              <td v-text="partitura.voces"></td>
              <td>
                <div class="d-flex justify-content-end">
                  <div class="px-3">
                    <router-link :to="{ path: '/verPartitura/' + partitura.id }" class="btn btn-info">
                      <i class="fa-solid fa-eye"></i>
                    </router-link>
                  </div>
                  <div class="px-3" v-if="this.$store.state.rol != '3'">
                    <router-link :to="{ path: '/editarPartitura/' + partitura.id }" class="btn btn-warning">
                      <i class="fa-solid fa-edit"></i>
                    </router-link>
                  </div>
                  <div class="px-3" v-if="this.$store.state.rol != '3'">
                    <button v-on:click="eliminar(partitura.id, partitura.nombre)" class="btn btn-danger">
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
            <li class="page-item" v-for="page in totalPagesPartituras" :key="page" :class="{ active: page === currentPagePartitura }">
              <a @click="changePagePartituras(page)" class="page-link">{{ page }}</a>
            </li>
          </ul>
        </div>
        <div v-if="this.$store.state.rol != '3'" class="d-flex justify-content-center">
          <router-link :to="{ path: '/crearPartitura/' + this.id }" class='btn btn-secondary'>
            <i class="fa-solid fa-archive"></i> Nueva partitura
          </router-link>
        </div>
      </div>
    </div>
  </div>s
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
      descripcion: '',
      archivo: '',
      url: '/api/coros',
      cargando: false,
      partituras: null,
      cantores: null,
      directores: null,
      currentPagePartitura: 1,
      currentPageCantor: 1,
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
          this.descripcion = res.data.descripcion;
          this.archivo = 'http://localhost:8000/' + res.data.archivo;
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
      confirmar('/api/partituras/', idPartitura, 'Eliminar partitura', 'Confirmar eliminación de partitura ' + nombre, 'verCoro/' + this.id);
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