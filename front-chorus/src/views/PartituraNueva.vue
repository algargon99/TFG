<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Crear partitura</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Crear nueva partitura
        </div>
        <div class="card-body">
          <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="guardar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i>&nbsp; Nombre</span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre de la partitura"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-city"></i>&nbsp; Autor</span>
              <input type="text" required v-model="autor" id="autor" placeholder="Autor de la partitura"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-location-dot"></i>&nbsp; A&ntilde;o</span>
              <input type="text" required v-model="anio" id="anio" placeholder="Año de la partitura" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i>&nbsp; Voces</span>
              <input type="text" required v-model="voces" id="voces" placeholder="Voces de la partitura"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-guitar"></i>&nbsp; Archivo</span>
              <input v-on:change="previsualizarPDF" ref="archivoInput" type="file" id="partitura" required
                accept="application/pdf" class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Crear partitura</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div v-if="this.archivo != ''" class="d-flex justify-content-center my-4">
      <embed :src="this.archivo" type="application/pdf" width="80%" height="1000px" id="archivo" />
    </div>
  </div>
  <div class="col-6 mx-auto my-3">
    <router-link :to="{ path: '/verCoro/' + this.coro }" class='btn btn-danger'>
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
    const route = useRoute();
    this.coro = route.params.id;
    this.url += '/' + this.coro;
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
      } else if (this.voces.trim() === '') {
        mostrarAlerta('Ingrese un número de voces', 'warning', 'voces')
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          autor: this.autor.trim(),
          anio: this.anio.trim(),
          voces: this.voces.trim(),
          archivo: partitura,
        };
        enviarSolicitud('POST', parametros, this.url, 'Partitura creada', "coros");
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