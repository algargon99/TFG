<template>
  <div v-if="this.$store.state.isAuthenticated == true && this.$store.state.rol != 0">
    <div class="titulo">
      <span class="h1 text-white">V&iacute;deo {{ nombre }}</span>
    </div>
    <div class="row g-0">
      <div class="row g-0 col-10 offset-1">
        <div class="m-4 col-xl-5 col-10 offset-1 d-flex align-items-center" v-if="this.$store.state.isAuthenticated">
          <video :src="archivo" controls class="w-100" />
        </div>
        <div class="col-xl-5 col-10 offset-1 bloque">
          <div class="mb-3">
            <span>Nombre:</span>
            <label v-text="nombre" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>Int&eacute;rprete:</span>
            <label v-text="interprete" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>A&ntilde;o:</span>
            <label v-text="year" class="form-control bg-dark text-white"></label>
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



import { useRoute } from "vue-router";
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: 0,
      idPartitura: 0,
      nombre: '',
      year: '',
      interprete: '',
      url: '/api/videos',
      cargando: false,
      archivo: ''
    };
  },
  methods: {
    getVideo() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.nombre;
          this.year = res.data.year;
          this.interprete = res.data.interprete;
          this.archivo = 'http://localhost:8000/' + res.data.video;
          this.idPartitura = res.data.idPartitura;
        }
      );
    },
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      const route = useRoute();
      this.idVideo = route.params.id;
      this.url += '/' + this.idVideo;
      this.getVideo();
    }
    document.title = 'Chorus - Ver Vídeo';
  },
};
</script>