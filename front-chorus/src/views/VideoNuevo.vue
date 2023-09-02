<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span class="h1 text-white">Crear v&iacute;deo</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-md-6 offset-md-3 bloque">
        <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="crearVideo()">
          <div class="mb-3">
            <span>Nombre:</span>
            <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del vídeo" class="form-control">
          </div>
          <div class="mb-3">
            <span>Int&eacute;rprete:</span>
            <input type="text" required v-model="interprete" id="interprete" placeholder="Intérprete del vídeo"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>A&ntilde;o:</span>
            <input type="text" required v-model="year" id="year" placeholder="Año del vídeo" class="form-control">
          </div>
          <div class="mb-3">
            <span>Archivo:</span>
            <input v-on:change="previsualizarVideo" ref="archivoInput" type="file" id="video" required accept="video/mp4"
              class="form-control">
          </div>
          <div class="d-grid col-3 mx-auto mb-3">
            <button class="btn btn-primary">Crear v&iacute;deo</button>
          </div>
        </form>
      </div>
      <div v-if="this.archivo != ''" class="d-flex justify-content-center my-4">
        <video width="600" :src="this.archivo" type="video/mp4" controls id="archivo" />
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



import { mostrarAlerta, enviarSolicitud } from '../funciones';
import { useRoute } from "vue-router";

export default {
  data() {
    return {
      nombre: '',
      year: '',
      interprete: '',
      archivo: '',
      partitura: 0,
      url: '/api/videos',
      cargando: false,
    };
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      const route = useRoute();
      this.partitura = route.params.id;
      this.url += '/' + this.partitura;
    }
    document.title = 'Chorus - Crear Vídeo';
  },
  methods: {
    crearVideo() {
      event.preventDefault();
      var video = this.$refs.archivoInput.files[0];
      this.cargando = true;
      if (this.nombre.trim() === '') {
        mostrarAlerta('Ingrese un nombre', 'warning', 'nombre')
      } else if (this.year === '') {
        mostrarAlerta('Ingrese un año', 'warning', 'year')
      } else if (this.interprete.trim() === '') {
        mostrarAlerta('Ingrese un intérprete', 'warning', 'interprete')
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          year: this.year.trim(),
          interprete: this.interprete.trim(),
          archivo: video,
        };
        enviarSolicitud('POST', parametros, this.url, 'Vídeo creado', "verPartitura/" + this.partitura);
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