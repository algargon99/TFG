<template>
  <div class="titulo">
    <span>Coro {{ nombre }}</span>
  </div>
  <div class="row my-4 g-0">
    <div class="col-10 offset-1">
      <div class="row my-4 g-0">
        <div class="primero col-10 col-xl-5 d-flex align-items-center justify-content-center">
          <img class="img-fluid mx-auto w-8" :src='archivo' alt="Coro">
        </div>
        <div class="col-xl-5 col-10 ms-4 bloque d-flex align-items-center">
          <p class="p-4"> Somos el coro {{ tipo }} de {{ estilo }} {{ nombre }} de la ciudad de {{ ciudad }}.
            {{ descripcion }} <br><br> Nos situamos en {{ direccion }}. Puedes contactarnos a través de la página de
            contacto.
          </p>
        </div>
      </div>
      <div>
        <span class="titulito">Directores</span>
      </div>
      <div class="row g-0 my-3">
        <div class="bloque d-flex flex-wrap">
          <div v-if="cargandoDirectores">
            <h4>Cargando...</h4>
          </div>
          <div class="mx-4" v-for="(director, i) in directores" :key="director.id">
            <div class="mb-4">
              <div class="d-flex justify-content-center mb-3">
                <img :src="'http://localhost:8000/' + director.archivo" class="img-fluid" width="150">
              </div>
              <div class="d-flex justify-content-center">
                <span><b>{{ director.nombre }} {{ director.apellidos }}</b></span>
              </div>
              <div class="d-flex justify-content-center">
                <span>{{ director.correo }}</span>
              </div>
              <div v-if="this.$store.state.rol === '1'" class="d-flex justify-content-center py-2">
                <button v-on:click="desasignar(director.id, id, director.nombre)" class="btn btn-danger">Dar de baja</button>
              </div>
            </div>
          </div>
          <div v-if="directores === null && !cargandoPartituras">
            <h4>No hay directores</h4>
          </div>
        </div>
      </div>
      <div v-if="this.$store.state.rol != '0'">
        <div>
          <span class="titulito">Cantores</span>
        </div>
        <div class="row g-0 my-3">
          <div class="col-lg-10 offset-lg-1">
            <div class="table-responsive borde bloque">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Voz</th>
                    <th v-if="this.$store.state.rol === '1' || this.$store.state.rol === '2'" scope="col"
                      class="text-center">
                      Fecha incorporaci&oacute;n</th>
                  </tr>
                </thead>
                <tbody class="table-group-divider">
                  <tr v-if="cargandoCantores">
                    <td colspan="8">
                      <h4>Cargando...</h4>
                    </td>
                  </tr>
                  <tr v-for="(cantor, i) in cantoresPaginados" :key="cantor.id">
                    <td>{{ cantor.nombre }} {{ cantor.apellidos }}</td>
                    <td v-text="cantor.correo"></td>
                    <td v-text="cantor.cantor.voz"></td>
                    <td v-if="this.$store.state.rol === '1' || this.$store.state.rol === '2'"
                      v-text="new Date(cantor.created_at).toLocaleDateString()" class="text-center">
                    </td>
                    <td v-if="this.$store.state.rol === '1' || this.$store.state.rol === '2'">
                      <div>
                        <button v-on:click="desasignar(cantor.id, id, cantor.nombre)"
                          class="btn btn-danger">Dar de baja</button>
                      </div>
                    </td>
                  </tr>
                  <tr v-if="cantoresPaginados.length === 0 && !cargandoCantores">
                    <td colspan="4">
                      <h4>No hay cantores asociados a este coro</h4>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="d-flex justify-content-center">
                <ul class="pagination">
                  <li class="page-item" v-for="page in paginasCantores" :key="page"
                    :class="{ active: page === currentPageCantor }">
                    <a @click="changePageCantores(page)" class="page-link">{{ page }}</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="this.$store.state.rol == '1' || (this.$store.state.rol != '1' && this.esta == 1)">
        <div>
          <span class="titulito">Partituras</span>
        </div>
        <div class="row g-0 my-3">
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
                  <tr v-if="cargandoPartituras">
                    <td colspan="4">
                      <h4>Cargando...</h4>
                    </td>
                  </tr>
                  <tr v-if="partiturasPaginadas.length === 0 && !cargandoPartituras">
                    <td colspan="3">
                      <h4>No hay partituras asociadas a este coro</h4>
                    </td>
                  </tr>
                  <tr v-if="partiturasPaginadas.length != 0 && !cargandoPartituras"
                    v-for="(partitura, i) in partiturasPaginadas" :key="partitura.id">
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
                          <button v-on:click="eliminarPartitura(partitura.id, partitura.nombre)" class="btn btn-danger">
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
                  <li class="page-item" v-for="page in paginasPartituras" :key="page"
                    :class="{ active: page === currentPagePartitura }">
                    <a @click="changePagePartituras(page)" class="page-link">{{ page }}</a>
                  </li>
                </ul>
              </div>
              <div class="m-2 d-flex justify-content-center align-items-center">
                <span>Filtrar por nombre: </span>
                <input type="text" class="form-control mx-2 w-25" v-model="buscador" @input="filtroPartitura"
                  placeholder="Nombre de la partitura">
              </div>
              <div v-if="this.$store.state.rol != '3'" class="d-flex justify-content-center">
                <router-link :to="{ path: '/crearPartitura/' + this.id }" class='btn btn-secondary my-3'>
                  Nueva partitura
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="(this.$store.state.rol != '0' && this.esta == 0) || this.$store.state.rol == '0'">
        <div>
          <span class="titulito">V&iacute;deo</span>
        </div>
        <div class="row g-0 my-3">
          <div class="bloque col-10 offset-1">
            <div v-if="video" class="mx-4">
              <div class="d-flex justify-content-center mb-3">
                <video :src="video" controls class="w-75" />
              </div>
            </div>
            <div v-if="!video">
              <h4>No hay v&iacute;deos</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>



import { useRoute } from "vue-router";
import { confirmar, desasignarCoro } from '../funciones';
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
      esta: 0,
      url: '/api/coros',
      cargandoPartituras: false,
      cargandoCantores: false,
      cargandoDirectores: false,
      partituras: null,
      filtroPartituras: [],
      buscador: '',
      partiturasPaginadas: [],
      paginasPartituras: 0,
      cantores: null,
      cantoresPaginados: [],
      paginasCantores: 0,
      directores: null,
      currentPagePartitura: 1,
      currentPageCantor: 1,
      perPage: 5,
      video: 'http://localhost:8000/',
    };
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
    filtroPartitura() {
      if (this.buscador === '') {
        this.filtroPartituras = this.partituras;
      } else {
        this.filtroPartituras = this.partituras.filter(partitura => partitura.nombre.includes(this.buscador));
      }
      this.totalPagesPartituras();
      this.paginatedItemsPartituras();
      this.currentPage = 1;
    },
    eliminarPartitura(idPartitura, nombre) {
      confirmar('/api/partituras/', idPartitura, 'Eliminar partitura', 'Confirmar eliminación de partitura ' + nombre, 'verCoro/' + this.id);
      this.cargando = false;
    },
    desasignar(idUsuario, idCoro, nombre) {
      desasignarCoro('/api/relsdesasignar/', idUsuario, idCoro, 'Dar de baja del coro', 'Dar de baja a ' + nombre, 'verCoro/' + this.id);
      this.cargando = false;
    },
    changePagePartituras(page) {
      this.currentPagePartitura = page;
      this.paginatedItemsPartituras();

    },
    changePageCantores(page) {
      this.currentPageCantor = page;
      this.paginatedItemsCantores();

    },
    listarPartituras() {
      this.cargandoPartituras = true;
      axios.get('/api/coros/' + this.id + '/partituras')
        .then(res => {
          this.partituras = res.data;
          this.filtroPartituras = this.partituras;
          this.totalPagesPartituras();
          this.paginatedItemsPartituras();
        })
        .catch(error => {
          console.error(error);
        })
        .finally(() => {
          this.cargandoPartituras = false;
        });
    },

    listarCantores() {
      this.cargandoCantores = true;
      axios.get('/api/cantoresCoro/' + this.id)
        .then(res => {
          this.cantores = res.data;
          this.totalPagesCantores();
          this.paginatedItemsCantores();
        })
        .catch(error => {
          console.error(error);
        })
        .finally(() => {
          this.cargandoCantores = false;
        });
    },

    listarDirectores() {
      this.cargandoDirectores = true;
      axios.get('/api/directoresCoro/' + this.id)
        .then(res => {
          this.directores = res.data;
        })
        .catch(error => {
          console.error(error);
        })
        .finally(() => {
          this.cargandoDirectores = false;
        });
    },
    totalPagesPartituras() {
      if (Array.isArray(this.filtroPartituras)) {
        this.paginasPartituras = Math.ceil(this.filtroPartituras.length / this.perPage);
      } else {
        this.paginasPartituras = 0;
      }
    },
    paginatedItemsPartituras() {
      if (Array.isArray(this.filtroPartituras)) {
        const start = (this.currentPagePartitura - 1) * this.perPage;
        const end = start + this.perPage;
        this.partiturasPaginadas = this.filtroPartituras.slice(start, end);
      } else {
        this.partiturasPaginadas = [];
      }
    },
    totalPagesCantores() {
      if (Array.isArray(this.cantores)) {
        this.paginasCantores = Math.ceil(this.cantores.length / this.perPage);
      } else {
        this.paginasCantores = 0;
      }
    },
    paginatedItemsCantores() {
      if (Array.isArray(this.cantores)) {
        const start = (this.currentPageCantor - 1) * this.perPage;
        const end = start + this.perPage;
        this.cantoresPaginados = this.cantores.slice(start, end);
      } else {
        this.cantoresPaginados = [];
      }
    },
    estaEnCoro() {
      axios.get("/api/estaCoro/" + this.id + "/" + this.$store.state.id).then(
        res => {
          this.esta = res.data;
        }
      )
    },
    getVideo() {
      axios.get("/api/videoAleatorio/" + this.id).then(
        res => {
          this.video += res.data.video;
        }
      )
    },
  },


  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getCoro();
    this.estaEnCoro();
    this.getVideo();
    this.listarPartituras();
    this.listarCantores();
    this.listarDirectores();
    document.title = 'Chorus - Ver Coro';
  },
};
</script>