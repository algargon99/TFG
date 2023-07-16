<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Crear audio</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Crear nuevo audio
        </div>

        <div class="card-body">
          <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="guardar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
              <input type="text" required v-model="obra" id="obra" placeholder="Nombre de la obra" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-city"></i></span>
              <input type="text" required v-model="duracion" id="duracion" placeholder="Duración del audio"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
              <input type="text" required v-model="interprete" id="interprete" placeholder="Intérprete del audio"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-guitar"></i></span>
              <input v-on:change="previsualizarAudio" ref="archivoInput" type="file" id="audio" required
                accept="audio/mp3" class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Crear audio</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center my-4">
      <audio v-if="this.archivo" :src="this.archivo" controls id="archivo" />
      <audio v-else :src="this.template" controls id="archivo" />
    </div>
  </div>
  <div class="col-6 mx-auto my-3">
    <router-link :to="{ path: '/verPartitura/' + this.partitura }" class='btn btn-danger'>
      <i class="fa-solid fa-arrow-left"></i> Volver
    </router-link>
  </div>
</template>

<script>



import { mostrarAlerta, enviarSolicitud } from '../funciones';
import { useRoute } from "vue-router";

export default {
  data() {
    return {
      obra: '',
      duracion: '',
      interprete: '',
      template: process.env.BASE_URL + 'audio/ejemplo.mp3',
      archivo: '',
      partitura: 0,
      url: '/api/audios',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.partitura = route.params.id;
    this.url += '/' + this.partitura;
    document.title = 'Chorus - Crear Audio';
  },
  methods: {
    guardar() {
      event.preventDefault();
      var audio = this.$refs.archivoInput.files[0];
      this.cargando = true;
      if (this.obra.trim() === '') {
        mostrarAlerta('Ingrese una obra', 'warning', 'obra')
      } else if (this.duracion.trim() === '') {
        mostrarAlerta('Ingrese una duración en segundos', 'warning', 'duracion')
      } else if (this.interprete.trim() === '') {
        mostrarAlerta('Ingrese un intérprete', 'warning', 'interprete')
      } else {
        var parametros = {
          obra: this.obra.trim(),
          duracion: this.duracion.trim(),
          interprete: this.interprete.trim(),
          archivo: audio,
        };
        enviarSolicitud('POST', parametros, this.url, 'Audio creado', "verPartitura/" + this.partitura);
      }
    },
    previsualizarAudio(event) {
      var file = event.target.files[0];
      if (typeof file != 'undefined') {
        var reader = new FileReader();
        reader.onload = function () {
          var url = URL.createObjectURL(file);
          this.archivo = url;
        }.bind(this);
        reader.readAsArrayBuffer(file);
      } else {
        this.archivo = process.env.BASE_URL + 'audio/ejemplo.mp3';
      }
    }
  },
};
</script>