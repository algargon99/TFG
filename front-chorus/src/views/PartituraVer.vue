<template>
  <div class="titulo ps-5 py-4">
    <span class="h1 text-white">Partitura {{ nombre }}, de {{ autor }}</span>
  </div>
  <div class="row g-0">
    <div class="col-xxl-5 col-10 offset-1">
      <embed :src="archivo" type="application/pdf" width="100%" height="1000px">
    </div>
    <div class="col-xxl-5 col-10 mx-5">
      <div>
        <span class="titulito">Audios</span>
      </div>
      <div class="table-responsive bloque borde">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Duraci&oacute;n (en segs)</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-if="!cargando && this.audios.length == 0">
              <td colspan="8">
                <h4>No hay audios disponibles</h4>
              </td>
            </tr>
            <tr v-if="this.audios.length != 0" v-for="(audio, i) in paginatedItemsAudio" :key="audio.id">

              <td v-text="audio.obra"></td>
              <td v-text="audio.duracion"></td>
              <td>
                <div class="d-flex justify-content-end">
                  <div class="px-3">
                    <router-link :to="{ path: '/verAudio/' + audio.id }" class="btn btn-info">
                      <i class="fa-solid fa-eye"></i>
                    </router-link>
                  </div>
                  <div class="px-3" v-if="this.$store.state.rol != '3'">
                    <router-link :to="{ path: '/editarAudio/' + audio.id }" class="btn btn-warning">
                      <i class="fa-solid fa-edit"></i>
                    </router-link>
                  </div>
                  <div class="px-3" v-if="this.$store.state.rol != '3'">
                    <button v-on:click="eliminarAudio(audio.id, audio.obra)" class="btn btn-danger">
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
            <li class="page-item" v-for="page in totalPagesAudio" :key="page"
              :class="{ active: page === currentPageAudio }">
              <a @click="changePageAudio(page)" class="page-link" href="#">{{ page }}</a>
            </li>
          </ul>
        </div>
        <div v-if="this.$store.state.rol != '3'" class="d-flex justify-content-center">
          <router-link :to="{ path: '/crearAudio/' + this.id }" class='btn btn-primary'>
            <i class="fa-solid fa-archive"></i> Nuevo audio
          </router-link>
        </div>
      </div>

      <div class="py-4">
        <span class="titulito">V&iacute;deos</span>
      </div>
      <div class="table-responsive bloque borde">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Int&eacute;rprete</th>
              <th scope="col">A&ntilde;o</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-if="!cargando && this.videos.length == 0">
              <td colspan="8">
                <h4>No hay v&iacute;deos disponibles</h4>
              </td>
            </tr>
            <tr v-if="this.videos.length != 0" v-for="(video, i) in paginatedItemsVideo" :key="video.id">
              <td v-text="video.nombre"></td>
              <td v-text="video.interprete"></td>
              <td v-text="video.year"></td>
              <td>
                <div class="d-flex justify-content-end">
                  <div class="px-3">
                    <router-link :to="{ path: '/verVideo/' + video.id }" class="btn btn-info">
                      <i class="fa-solid fa-eye"></i>
                    </router-link>

                  </div>
                  <div class="px-3" v-if="this.$store.state.rol != '3'">
                    <router-link :to="{ path: '/editarVideo/' + video.id }" class="btn btn-warning">
                      <i class="fa-solid fa-edit"></i>
                    </router-link>
                  </div>
                  <div class="px-3" v-if="this.$store.state.rol != '3'">
                    <button v-on:click="eliminarVideo(video.id, video.nombre)" class="btn btn-danger">
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
            <li class="page-item" v-for="page in totalPagesVideo" :key="page"
              :class="{ active: page === currentPageVideo }">
              <a @click="changePageVideo(page)" class="page-link" href="#">{{ page }}</a>
            </li>
          </ul>
        </div>
        <div v-if="this.$store.state.rol != '3'" class="d-flex justify-content-center">
          <router-link :to="{ path: '/crearVideo/' + this.id }" class='btn btn-primary'>
            <i class="fa-solid fa-archive"></i> Nuevo v&iacute;deo
          </router-link>
        </div>
      </div>
    </div>
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
      idPartitura: 0,
      nombre: '',
      autor: '',
      anio: '',
      voces: '',
      url: '/api/partituras',
      cargando: false,
      audios: [],
      videos: [],
      currentPageAudio: 1,
      currentPageVideo: 1,
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
        const start = (this.currentPageAudio - 1) * this.perPage;
        const end = start + this.perPage;
        return this.audios.slice(start, end);
      } else {
        return [];
      }
    },
    totalPagesVideo() {
      if (Array.isArray(this.videos)) {
        return Math.ceil(this.videos.length / this.perPage);
      } else {
        return 0;
      }
    },
    paginatedItemsVideo() {
      if (Array.isArray(this.videos)) {
        const start = (this.currentPageVideo - 1) * this.perPage;
        const end = start + this.perPage;
        return this.videos.slice(start, end);
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
      this.currentPageAudio = page;
    },
    changePageVideo(page) {
      this.currentPageVideo = page;
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
    listaVideos() {
      this.cargando = true;
      axios.get('/api/partitura/' + this.idPartitura + '/videos').then(
        res => {
          this.videos = res.data;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    eliminarAudio(idAudio, nombre) {
      confirmar('/api/audios/', idAudio, 'Eliminar audio', 'Confirmar eliminación de audio ' + nombre, 'verPartitura/' + this.idPartitura);
      this.cargando = false;
    },
    eliminarVideo(idVideo, nombre) {
      confirmar('/api/videos/', idVideo, 'Eliminar vídeo', 'Confirmar eliminación de vídeo ' + nombre, 'verPartitura/' + this.idPartitura);
      this.cargando = false;
    },
  },
  mounted() {
    const route = useRoute();
    this.idPartitura = route.params.id;
    this.url += '/' + this.idPartitura;
    this.getPartitura();
    this.listaAudios();
    this.listaVideos();
    document.title = 'Chorus - Ver Partitura';
  },
};
</script>