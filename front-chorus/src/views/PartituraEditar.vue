<template>
  <div v-if="this.$store.state.isAuthenticated == true && (this.$store.state.rol == 1 || this.$store.state.rol == 2)">
    <div class="titulo">
      <span class="h1 text-white">Editar partitura {{ nombre }}</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-md-4 offset-md-4 bloque">
        <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="editarPartitura()">
          <div class="mb-3">
            <span>Nombre:</span>
            <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre de la partitura"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>Autor:</span>
            <input type="text" required v-model="autor" id="autor" placeholder="Autor de la partitura"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>A&ntilde;o:</span>
            <input type="text" required v-model="anio" id="anio" placeholder="Año de la partitura" class="form-control">
          </div>
          <div class="mb-3">
            <span>Voces:</span>
            <input type="number" min="1" required v-model="voces" id="voces" placeholder="Voces de la partitura"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>Archivo:</span>
            <input v-on:change="previsualizarPDF" ref="archivoInput" type="file" id="partitura" accept="application/pdf"
              class="form-control">
          </div>
          <div class="d-grid col-3 mx-auto mb-3 py-3">
            <button class="btn btn-warning">Editar partitura</button>
          </div>
        </form>
      </div>
      <div class="d-flex justify-content-center my-4">
        <embed :src="this.archivo" type="application/pdf" width="80%" height="1000px" id="archivo" />
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
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: 0,
      nombre: '',
      autor: '',
      anio: '',
      voces: '',
      archivo: '',
      archivoBase: '',
      coro: 0,
      url: '/api/partituras',
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
    document.title = 'Chorus - Editar Partitura';
  },
  methods: {
    getPartitura() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.nombre;
          this.autor = res.data.autor;
          this.anio = res.data.anio;
          this.voces = res.data.voces;
          this.archivo = 'http://localhost:8000/' + res.data.archivo;
          this.archivoBase = this.archivo;
          this.coro = res.data.idCoro;
        }
      );
    },
    editarPartitura() {
      event.preventDefault();

      var partitura = this.$refs.archivoInput.files[0];
      if (typeof partitura === 'undefined') {
        partitura = "Antiguo";
      }
      this.cargando = true;
      if (this.nombre.trim() === '') {
        mostrarAlerta('Ingrese un nombre', 'warning', 'nombre')
      } else if (this.autor.trim() === '') {
        mostrarAlerta('Ingrese un autor', 'warning', 'autor')
      } else if (this.anio === '') {
        mostrarAlerta('Ingrese un año', 'warning', 'anio')
      } else {
        var coro = this.coro;
        var parametros = {
          nombre: this.nombre.trim(),
          autor: this.autor.trim(),
          anio: this.anio,
          voces: this.voces,
          archivo: partitura
        };
        enviarSolicitud('PUT', parametros, this.url, 'Partitura actualizada', 'verCoro/' + coro);
      }
    },
    previsualizarPDF(event) {
      var file = event.target.files[0];
      if (typeof file != 'undefined') {
        var reader = new FileReader();
        reader.onload = function () {
          var url = URL.createObjectURL(file);
          this.archivo = url;
        }.bind(this);
        reader.readAsArrayBuffer(file);
      } else {
        this.archivo = this.archivoBase;
      }
    }
  },
};
</script>