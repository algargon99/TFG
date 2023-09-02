<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span class="h1 text-white">Editar audio {{ obra }}</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-md-6 offset-md-3 bloque">

        <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="editarAudio()">
          <div class=" mb-3">
            <span>Obra:</span>
            <input type="text" required v-model="obra" id="obra" placeholder="Obra del audio" class="form-control">
          </div>
          <div class=" mb-3">
            <span>Duraci&oacute;n (segs):</span>
            <input type="text" required v-model="duracion" id="duracion" placeholder="Duración del audio"
              class="form-control">
          </div>
          <div class=" mb-3">
            <span>Voz:</span>
            <input type="text" required v-model="voz" id="voz" placeholder="Voz del audio" class="form-control">
          </div>
          <div class=" mb-3">
            <span>Int&eacute;rprete:</span>
            <input type="text" required v-model="interprete" id="interprete" placeholder="Intérprete del audio"
              class="form-control">
          </div>

          <div class=" mb-3">
            <span>Archivo:</span>
            <input v-on:change="previsualizarAudio" ref="archivoInput" type="file" id="audio" accept="audio/mp3"
              class="form-control">
          </div>
          <div class="d-grid col-3 mx-auto mb-3">
            <button class="btn btn-warning">Editar audio</button>
          </div>
        </form>
        <div class="d-flex justify-content-center my-4" v-if="this.$store.state.isAuthenticated">
          <audio :src="this.archivo" controls id="archivo" />
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



import { mostrarAlerta, enviarSolicitud } from '../funciones';
import { useRoute } from "vue-router";
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: 0,
      obra: '',
      duracion: '',
      voz: '',
      interprete: '',
      archivo: '',
      archivoBase: '',
      partitura: 0,
      url: '/api/audios',
      cargando: false,
    };
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      const route = useRoute();
      this.id = route.params.id;
      this.url += '/' + this.id;
      this.getPartitura();
    }
    document.title = 'Chorus - Editar Audio';
  },
  methods: {
    getPartitura() {
      axios.get(this.url).then(
        res => {
          this.obra = res.data.obra;
          this.duracion = res.data.duracion;
          this.voz = res.data.voz;
          this.interprete = res.data.interprete;
          this.archivo = 'http://localhost:8000/' + res.data.audio;
          this.partitura = res.data.idPartitura;
        }

      );
    },
    editarAudio() {
      event.preventDefault();
      var audio = this.$refs.archivoInput.files[0];
      if (typeof audio === 'undefined') {
        audio = "Antiguo";
      }
      this.cargando = true;
      if (this.obra.trim() === '') {
        mostrarAlerta('Ingrese una obra', 'warning', 'obra')
      } else if (this.duracion === '') {
        mostrarAlerta('Ingrese una duración', 'warning', 'duracion')
      } else if (this.voz === '') {
        mostrarAlerta('Ingrese una voz', 'warning', 'voz')
      } else if (this.interprete === '') {
        mostrarAlerta('Ingrese un interprete', 'warning', 'interprete')
      } else {

        var parametros = {
          obra: this.obra.trim(),
          voz: this.voz.trim(),
          duracion: this.duracion,
          interprete: this.interprete.trim(),
          archivo: audio
        };
        enviarSolicitud('PUT', parametros, this.url, 'Audio actualizado', 'verPartitura/' + this.partitura);
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