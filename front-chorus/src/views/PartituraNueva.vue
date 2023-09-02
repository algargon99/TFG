<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span class="h1 text-white">Crear partitura</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-md-4 offset-md-4 bloque">
        <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="crearPartitura()">
          <div class="mb-3">
            <span>Nombre:</span>
            <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre de la partitura"
              class="form-control">
          </div>
          <div class=" mb-3">
            <span>Autor:</span>
            <input type="text" required v-model="autor" id="autor" placeholder="Autor de la partitura"
              class="form-control">
          </div>
          <div class=" mb-3">
            <span>A&ntilde;o:</span>
            <input type="text" required v-model="anio" id="anio" placeholder="Año de la partitura" class="form-control">
          </div>
          <div class=" mb-3">
            <span>Voces:</span>
            <input type="number" min="1" required v-model="voces" id="voces" placeholder="Voces de la partitura"
              class="form-control">
          </div>
          <div class=" mb-3">
            <span>Archivo:</span>
            <input v-on:change="previsualizarPDF" ref="archivoInput" type="file" id="partitura" required
              accept="application/pdf" class="form-control">
          </div>
          <div class="d-grid col-3 mx-auto py-3">
            <button class="btn btn-primary">Crear partitura</button>
          </div>
        </form>
      </div>
      <div v-if="this.archivo != ''" class="d-flex justify-content-center my-4">
        <embed :src="this.archivo" type="application/pdf" width="80%" height="1000px" id="archivo" />
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
      autor: '',
      anio: '',
      voces: '',
      template: process.env.BASE_URL + 'pdf/archivo.pdf',
      archivo: '',
      coro: '',
      url: '/api/partituras',
      cargando: false,
    };
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      const route = useRoute();
      this.coro = route.params.id;
      this.url += '/' + this.coro;
    }
    document.title = 'Chorus - Crear Partitura';
  },
  methods: {
    guardar() {
      event.preventDefault();
      var partitura = this.$refs.archivoInput.files[0];
      this.cargando = true;
      if (this.nombre.trim() === '') {
        mostrarAlerta('Ingrese un nombre', 'warning', 'nombre')
      } else if (this.autor.trim() === '') {
        mostrarAlerta('Ingrese un autor', 'warning', 'autor')
      } else if (this.anio.trim() === '') {
        mostrarAlerta('Ingrese un año', 'warning', 'anio')
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          autor: this.autor.trim(),
          anio: this.anio.trim(),
          voces: this.voces,
          archivo: partitura,
        };
        enviarSolicitud('POST', parametros, this.url, 'Partitura creada', "verCoro/" + this.coro);
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
        this.archivo = '';
      }
    }
  },
};
</script>