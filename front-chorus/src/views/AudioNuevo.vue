<template>
  <div v-if="this.$store.state.isAuthenticated == true && (this.$store.state.rol == 1 || this.$store.state.rol == 2)">
    <div class="titulo">
      <span class="h1 text-white">Crear audio</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-md-6 offset-md-3 bloque">
        <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="crearAudio()">
          <div class=" mb-3">
            <span>Obra: </span>
            <input type="text" required v-model="obra" id="obra" placeholder="Nombre de la obra" class="form-control">
          </div>
          <div class=" mb-3">
            <span>Duraci&oacute;n (segs): </span>
            <input type="text" required v-model="duracion" id="duracion" placeholder="Duración del audio"
              class="form-control">
          </div>
          <div class=" mb-3">
            <span>Voz: </span>
            <input type="text" required v-model="voz" id="voz" placeholder="Voz del audio" class="form-control">
          </div>
          <div class=" mb-3">
            <span>Int&eacute;rprete:</span>
            <input type="text" required v-model="interprete" id="interprete" placeholder="Intérprete del audio"
              class="form-control">
          </div>
          <div class=" mb-3">
            <span>Archivo:</span>
            <input v-on:change="previsualizarAudio" ref="archivoInput" type="file" id="audio" required accept="audio/mp3"
              class="form-control">
          </div>
          <div class="d-grid col-3 mx-auto py-3">
            <button class="btn btn-primary">Crear audio</button>
          </div>
        </form>
      </div>
      <div v-if="this.archivo != ''" class="d-flex justify-content-center my-4">
        <audio :src="this.archivo" controls id="archivo" />
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



import { mostrarAlerta, enviarSolicitud } from '../funciones';
import { useRoute } from "vue-router";

export default {
  data() {
    return {
      obra: '',
      voz: '',
      duracion: '',
      interprete: '',
      archivo: '',
      partitura: 0,
      url: '/api/audios',
      cargando: false,
    };
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      const route = useRoute();
      this.partitura = route.params.id;
      this.url += '/' + this.partitura;
    }
    document.title = 'Chorus - Crear Audio';
  },
  methods: {
    crearAudio() {
      event.preventDefault();
      var audio = this.$refs.archivoInput.files[0];
      this.cargando = true;
      if (this.obra.trim() === '') {
        mostrarAlerta('Ingrese una obra', 'warning', 'obra')
      } else if (this.voz.trim() === '') {
        mostrarAlerta('Ingrese una voz', 'warning', 'voz')
      } else if (this.duracion.trim() === '') {
        mostrarAlerta('Ingrese una duración en segundos', 'warning', 'duracion')
      } else if (this.interprete.trim() === '') {
        mostrarAlerta('Ingrese un intérprete', 'warning', 'interprete')
      } else {
        var parametros = {
          obra: this.obra.trim(),
          voz: this.voz.trim(),
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