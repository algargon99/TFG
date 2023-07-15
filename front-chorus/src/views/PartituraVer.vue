<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Partitura {{ nombre }}</span>
  </div>
  <div class="row g-0">
    <div class="col-md-1"></div>
    <div class="col-md-4  d-flex align-items-center">
      <div class="card w-75">
        <div class="card-header bg-dark text-white text-center">
          Detalle de la partitura
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
            <label v-text="nombre" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
            <label v-text="autor" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
            <label v-text="anio" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-music"></i></span>
            <label v-text="voces" class="form-control"></label>
          </div>
        </div>
      </div>
    </div>
    <div class="m-4 col-md-6">
      <iframe :src="archivo" type="application/pdf" width="100%" height="1000px" />
    </div>

    <div class="col-md-1"></div>
  </div>
  <div class="titulo ps-5 pt-4">
    <span class="h1 text-white">Audios de la partitura {{ nombre }}</span>
  </div>
  <div class="row g-0 my-5">
    <div class="col-lg-8 offset-lg-2">
      <div class="table-responsive bg-white borde">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Nº</th>
              <th scope="col">Obra</th>
              <th scope="col">Duraci&oacute;n</th>
              <th scope="col">Int&eacute;rprete</th>
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
            <tr v-else v-for="(audio, i) in paginatedItemsAudio" :key="audio.id">
              <td v-text="(i + 1)"></td>
              <td v-text="audio.obra"></td>
              <td v-text="audio.duracion"></td>
              <td v-text="audio.interprete"></td>
              <td>
                <router-link :to="{ path: '/verAudio/' + audio.id }" class="btn btn-info">
                  <i class="fa-solid fa-eye"></i>
                </router-link>
              </td>
              <td>
                <router-link :to="{ path: '/editarAudio/' + audio.id }" class="btn btn-warning">
                  <i class="fa-solid fa-edit"></i>
                </router-link>
              </td>
              <td>
                <button v-on:click="eliminar(audio.id, audio.obra)" class="btn btn-danger">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-center">
          <ul class="pagination">
            <li class="page-item" v-for="page in totalPagesAudio" :key="page" :class="{ active: page === currentPage }">
              <a @click="changePageAudio(page)" class="page-link" href="#">{{ page }}</a>
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-center">
          <router-link :to="{ path: '/crearAudio/' + this.id }" class='btn btn-primary'>
            <i class="fa-solid fa-archive"></i> Nuevo audio
          </router-link>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 mx-auto my-3">
    <router-link :to="{ path: '/verCoro/' + id }" class='btn btn-danger'>
      <i class="fa-solid fa-arrow-left"></i> Volver
    </router-link>
  </div>
</template>

<script>

document.title = 'Chorus - Ver Partitura';

import { useRoute } from "vue-router";
import { confirmar } from '../funciones';
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: 0,
      idPartitura: 0,
      nombre: '',
      autor: '',
      anio: '',
      voces: '',
      url: '/api/partituras',
      cargando: false,
      audios: null,
      currentPage: 1,
      perPage: 5,
      archivo: ''
    };
  },
  computed: {
    totalPagesAudio() {
      if (Array.isArray(this.audios)) {
        return Math.ceil(this.audios.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItemsAudio() {
      if (Array.isArray(this.audios)) {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        return this.audios.slice(start, end);
      } else {
        return [];
      }
    },
  },

  methods: {
    getPartitura() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.nombre;
          this.autor = res.data.autor;
          this.anio = res.data.anio;
          this.voces = res.data.voces;
          this.archivo = 'http://localhost:8000/' + res.data.archivo;
          this.id = res.data.idCoro;
        }
      );
    },
    changePageAudio(page) {
      this.currentPage = page;
    },
    listaAudios() {
      this.cargando = true;
      axios.get('/api/partitura/' + this.idPartitura + '/audios').then(
        res => {
          this.audios = res.data;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    eliminar(idAudio, nombre) {
      confirmar('/api/audios/', idAudio, 'Eliminar audio', 'Confirmar eliminación de audio ' + nombre, 'verPartitura/' + this.idPartitura);
      this.cargando = false;
    },
  },
  mounted() {
    const route = useRoute();
    this.idPartitura = route.params.id;
    this.url += '/' + this.idPartitura;
    this.getPartitura();
    this.listaAudios();
  },
};
</script>