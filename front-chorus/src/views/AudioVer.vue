<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span class="h1 text-white">Audio {{ obra }}</span>
    </div>
    <div class="row g-0">
      <div class="row g-0 col-10 offset-1 bloque">
        <div class="m-4 col-md-5 d-flex justify-content-center align-items-center"
          v-if="this.$store.state.isAuthenticated">
          <audio :src="archivo" controls></audio>
        </div>
        <div class="col-md-5 offset-1 ">
          <div class="mb-3">
            <span>Obra:</span>
            <label v-text="obra" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>Voz:</span>
            <label v-text="voz" class="form-control bg-dark text-white"></label>
          </div>
          <div class="mb-3">
            <span>Int&eacute;rprete:</span>
            <label v-text="interprete" class="form-control bg-dark text-white"></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-else class="titulo">
    <span>Acceso denegado</span>
    <p class="acceso">Inicia sesión para acceder a la aplicación</p>
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
      obra: '',
      voz: '',
      interprete: '',
      url: '/api/audios',
      cargando: false,
      archivo: ''
    };
  },
  methods: {
    getAudio() {
      axios.get(this.url).then(
        res => {
          this.obra = res.data.obra;
          this.voz = res.data.voz;
          this.interprete = res.data.interprete;
          this.archivo = 'http://localhost:8000/' + res.data.audio;
          this.idPartitura = res.data.idPartitura;
        }
      );
    },
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      const route = useRoute();
      this.idAudio = route.params.id;
      this.url += '/' + this.idAudio;
      this.getAudio();
    }
    document.title = 'Chorus - Ver Audio';
  },
};
</script>