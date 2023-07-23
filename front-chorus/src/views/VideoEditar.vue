<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Editar v&iacute;deo {{ nombre }}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Editar v&iacute;deo
        </div>
        <div class="card-body">
          <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="editar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-music"></i>&sbquo; Nombre</span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del vídeo"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-user"></i>&sbquo; Int&eacute;rprete</span>
              <input type="text" required v-model="interprete" id="interprete" placeholder="Intérprete del vídeo"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-calendar"></i>&sbquo; A&ntilde;o</span>
              <input type="text" required v-model="year" id="year" placeholder="Año del vídeo" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-video-camera"></i>&sbquo; Archivo</span>
              <input v-on:change="previsualizarVideo" ref="archivoInput" type="file" id="vídeo" accept="video/mp4"
                class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-warning"><i class="fa-solid fa-refresh"></i> Editar v&iacute;deo</button>
            </div>
          </form>
        </div>
      </div>
      <div class="d-flex justify-content-center my-4">
        <video width="600" type="video/mp4" :src="this.archivo" controls id="archivo" />
      </div>
    </div>
    <div class="col-6 mx-auto my-3">
      <router-link :to="{ path: '/verPartitura/' + this.partitura }" class='btn btn-danger'>
        <i class="fa-solid fa-arrow-left"></i> Volver
      </router-link>
    </div>
  </div>
</template>

<script>



import { mostrarAlerta, enviarSolicitud } from '../funciones';
import { useRoute } from "vue-router";
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: 0,
      nombre: '',
      year: '',
      interprete: '',
      archivo: '',
      archivoBase: '',
      partitura: 0,
      url: '/api/videos',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getPartitura();
    document.title = 'Chorus - Editar Vídeo';
  },
  methods: {
    getPartitura() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.nombre;
          this.year = res.data.year;
          this.interprete = res.data.interprete;
          this.archivo = 'http://localhost:8000/' + res.data.video;
          this.partitura = res.data.idPartitura;
        }

      );
    },
    editar() {
      event.preventDefault();
      var video = this.$refs.archivoInput.files[0];
      if (typeof video === 'undefined') {
        video = "Antiguo";
      }
      this.cargando = true;
      if (this.nombre.trim() === '') {
        mostrarAlerta('Ingrese un nombre', 'warning', 'nombre')
      } else if (this.year === '') {
        mostrarAlerta('Ingrese un año', 'warning', 'year')
      } else if (this.interprete.trim() === '') {
        mostrarAlerta('Ingrese un interprete', 'warning', 'interprete')
      } else {

        var parametros = {
          nombre: this.nombre.trim(),
          year: this.year,
          interprete: this.interprete.trim(),
          archivo: video
        };
        enviarSolicitud('PUT', parametros, this.url, 'Vídeo actualizado', 'verPartitura/' + this.partitura);
      }
    },
    previsualizarVideo(event) {
      var file = event.target.files[0];
      if (typeof file != 'undefined') {
        var reader = new FileReader();
        reader.onload = function () {
          var url = URL.createObjectURL(file);
          this.archivo = url;
        }.bind(this);
        reader.readAsArrayBuffer(file);
      } else {
        this.archivo = process.env.BASE_URL + 'video/ejemplo.mp4';
      }
    }
  },
};
</script>