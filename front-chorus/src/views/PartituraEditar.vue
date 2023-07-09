<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Editar partitura {{ nombre }}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Editar partitura
        </div>
        <div class="card-body">
          <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="editar()">
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
              <input v-on:change="previsualizarPDF" ref="archivoInput" type="file" id="partitura" accept="application/pdf"
                class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Editar partitura</button>
            </div>
          </form>
        </div>
      </div>
      <div class="d-flex justify-content-center my-4">
        <embed :src="this.archivo" type="application/pdf" width="80%" height="1000px" id="archivo" />
      </div>
    </div>
    <div class="col-6 mx-auto my-3">
      <router-link :to="{ path: '/coros' }" class='btn btn-danger'>
        <i class="fa-solid fa-arrow-left"></i> Volver
      </router-link>
    </div>
  </div>
</template>

<script>

document.title = 'Chorus - Editar Coro';

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
      coro: '',
      url: '/api/partituras',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getPartitura();
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
          this.coro = res.data.idCoro;
        }
        
      );
    },
    editar() {
      event.preventDefault();
      
      var archivo = this.$refs.archivoInput.files[0];
      if (typeof archivo === 'undefined') {
        archivo = "Antiguo";
      }
      this.cargando = true;
      if (this.nombre.trim() === '') {
        mostrarAlerta('Ingrese un nombre', 'warning', 'nombre')
      } else if (this.autor.trim() === '') {
        mostrarAlerta('Ingrese un autor', 'warning', 'autor')
      } else if (this.anio === '') {
        mostrarAlerta('Ingrese un año', 'warning', 'anio')
      } else if (this.voces === '') {
        mostrarAlerta('Ingrese un número de voces', 'warning', 'voces')
      } else {
        var coro = this.coro;
        var parametros = {
          nombre: this.nombre.trim(),
          autor: this.autor.trim(),
          anio: this.anio,
          voces: this.voces,
          partitura: archivo
        };
        console.log(this.url);
        enviarSolicitud('PUT', parametros, this.url, 'Partitura actualizada','verCoro/'+ coro);
      }
    },
    previsualizarPDF(event) {
      var file = event.target.files[0];
      var reader = new FileReader();
      reader.onload = function () {
        var url = URL.createObjectURL(file); // Obtiene la URL del archivo
        this.archivo = url;
      }.bind(this);
      reader.readAsArrayBuffer(file);
      var archivoPDF = this.$refs.archivoInput.files[0];
      console.log(archivoPDF);
    }
  },
};
</script>