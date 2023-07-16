<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Audio {{ obra }}</span>
  </div>
  <div class="row g-0">
    <div class="col-md-1"></div>
    <div class="m-4 col-md-4 d-flex align-items-center">
      <audio :src="archivo" controls></audio>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5 d-flex align-items-center justify-content-center">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Detalle del audio
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-music"></i>&sbquo; Obra</span>
            <label v-text="obra" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-clock"></i>&sbquo; Duraci&oacute;n (segs)</span>
            <label v-text="duracion" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i>&sbquo; Int&eacute;rprete</span>
            <label v-text="interprete" class="form-control"></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="my-3 mx-4" >
    <router-link :to="{ path: '/verPartitura/' + idPartitura }" class='btn btn-danger'>
      <i class="fa-solid fa-arrow-left"></i> Volver
    </router-link>
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
      duracion: '',
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
          this.duracion = res.data.duracion;
          this.interprete = res.data.interprete;
          this.archivo = 'http://localhost:8000/' + res.data.audio;
          this.idPartitura = res.data.idPartitura;
        }
      );
    },
  },
  mounted() {
    const route = useRoute();
    this.idAudio = route.params.id;
    this.url += '/' + this.idAudio;
    this.getAudio();
    document.title = 'Chorus - Ver Audio';
  },
};
</script>