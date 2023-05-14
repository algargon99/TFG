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
          <form class="form" enctype="multipart/form-data" v-on:submit="guardar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre de la partitura"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-city"></i></span>
              <input type="text" required v-model="autor" id="autor" placeholder="Autor de la partitura"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
              <input type="text" required v-model="anio" id="anio" placeholder="Año de la partitura" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
              <input type="text" required v-model="voces" id="voces" placeholder="Voces de la partitura"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-guitar"></i></span>
              <input v-on:change="previsualizarPDF" ref="archivoInput" type="file" id="partitura" required accept="application/pdf" class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Crear partitura</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center my-4">
      <embed v-if="this.archivo" :src="this.archivo" type="application/pdf" width="80%" height="1000px" id="archivo" />
      <embed v-else :src="this.template" type="application/pdf" width="80%" height="1000px" id="archivo" />
    </div>
  </div>
</template>

<script>

document.title = 'Chorus - Crear Coro';

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
  },
  methods: {
    guardar() {
      event.preventDefault();
      var archivo = this.$refs.archivoInput.files[0];
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
          partitura: archivo,
        };
        console.log(parametros);
        enviarSolicitud('POST', parametros, this.url, 'Partitura creada', "coros");
      }
    },
    previsualizarPDF(event) {
      var file = event.target.files[0];
      var reader = new FileReader();
      reader.onload = function () {
        var url = URL.createObjectURL(file); // Obtiene la URL del archivo
        this.archivo = url;
        console.log(this.archivo);
      }.bind(this);
      reader.readAsArrayBuffer(file);
    }
  },
};
</script>