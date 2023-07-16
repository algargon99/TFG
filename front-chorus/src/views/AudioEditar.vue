<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Editar audio {{ obra }}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Editar audio
        </div>
        <div class="card-body">
          <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="editar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-music"></i></span>
              <input type="text" required v-model="obra" id="obra" placeholder="Obra del audio" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
              <input type="text" required v-model="duracion" id="duracion" placeholder="Duración del audio"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
              <input type="text" required v-model="interprete" id="interprete" placeholder="Intérprete del audio"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-guitar"></i></span>
              <input v-on:change="previsualizarAudio" ref="archivoInput" type="file" id="audio" accept="audio/mp3"
                class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-warning"><i class="fa-solid fa-refresh"></i> Editar audio</button>
            </div>
          </form>
        </div>
      </div>
      <div class="d-flex justify-content-center my-4">
        <audio :src="this.archivo" controls id="archivo" />
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
      obra: '',
      duracion: '',
      interprete: '',
      archivo: '',
      archivoBase: '',
      partitura: 0,
      url: '/api/audios',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getPartitura();
    document.title = 'Chorus - Editar Audio';
  },
  methods: {
    getPartitura() {
      axios.get(this.url).then(
        res => {
          this.obra = res.data.obra;
          this.duracion = res.data.duracion;
          this.interprete = res.data.interprete;
          this.archivo = 'http://localhost:8000/' + res.data.audio;
          this.partitura = res.data.idPartitura;
        }

      );
    },
    editar() {
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
      } else if (this.interprete === '') {
        mostrarAlerta('Ingrese un interprete', 'warning', 'interprete')
      } else {

        var parametros = {
          obra: this.obra.trim(),
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