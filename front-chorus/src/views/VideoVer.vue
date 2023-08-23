<template>
  <div class="titulo">
    <span class="h1 text-white">V&iacute;deo {{ nombre }}</span>
  </div>
  <div class="row g-0">
    <div class="col-md-1"></div>
    <div class="m-4 col-md-4 d-flex align-items-center">
      <video :src="archivo" width="600" controls />
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-5 d-flex align-items-center justify-content-center">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Detalle del v&iacute;deo
        </div>
        <div class="card-body">
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-video"></i>&sbquo; Nombre</span>
            <label v-text="nombre" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-user"></i>&sbquo; Int&eacute;rprete</span>
            <label v-text="interprete" class="form-control"></label>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-calendar"></i>&sbquo; A&ntilde;o</span>
            <label v-text="year" class="form-control"></label>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="my-3 mx-4">
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
    const route = useRoute();
    this.idVideo = route.params.id;
    this.url += '/' + this.idVideo;
    this.getVideo();
    document.title = 'Chorus - Ver Vídeo';
  },
};
</script>