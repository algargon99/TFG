<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span class="h1 text-white">Crear coro</span>
    </div>
    <form class="form" method="POST" enctype="multipart/form-data" v-on:submit="crearCoro()">
      <div class="row mt-3 g-0">
        <div class="col-md-2 offset-md-2 align-items-center icono">
          <div class="d-flex justify-content-center mb-3" v-if="this.archivo != ''">
            <img :src=archivo alt="Foto" class="img-fluid" id="archivo">
          </div>
          <div class="d-flex justify-content-center">
            <input v-on:change="previsualizarImagen" ref="archivoInput" type="file" id="foto" required accept="image/*"
              class="form-control">
          </div>
        </div>
        <div class="col-md-5 offset-md-1">
          <div class="bloque">
            <div class="mb-3">
              <span>Nombre:</span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del coro" class="form-control">
            </div>
            <div class="mb-3">
              <span>Ciudad:</span>
              <input type="text" required v-model="ciudad" id="ciudad" placeholder="Ciudad del coro" class="form-control">
            </div>
            <div class="mb-3">
              <span>Direcci&oacute;n:</span>
              <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección del coro"
                class="form-control">
            </div>
            <div class="mb-3">
              <span>Tipo:</span>
              <input type="text" required v-model="tipo" id="tipo" placeholder="Tipo de coro" class="form-control">
            </div>
            <div class="mb-3">
              <span>Estilo:</span>
              <input type="text" required v-model="estilo" id="estilo" placeholder="Estilo del coro" class="form-control">
            </div>
            <div class="mb-3">
              <span class="w-100">Incluye una peque&ntilde;a descripci&oacute;n:</span>
              <textarea required v-model="descripcion" placeholder="Descripción" id="descripcion" class="form-control" />
            </div>
            <div class="d-grid col-3 mx-auto py-3">
              <button class="btn btn-primary">Crear coro</button>
            </div>
          </div>
        </div>
      </div>
    </form>
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

export default {
  data() {
    return {
      nombre: '',
      ciudad: '',
      direccion: '',
      tipo: '',
      estilo: '',
      descripcion: '',
      archivo: process.env.BASE_URL + 'blanco.png',
      url: '/api/coros',
      cargando: false,
    };
  },
  methods: {
    crearCoro() {
      event.preventDefault();
      this.cargando = true;
      var imagen = this.$refs.archivoInput.files[0];
      if (this.nombre.trim() === '') {
        mostrarAlerta('Ingrese un nombre', 'warning', 'nombre')
      } else if (this.ciudad.trim() === '') {
        mostrarAlerta('Ingrese una ciudad', 'warning', 'ciudad')
      } else if (this.direccion.trim() === '') {
        mostrarAlerta('Ingrese una dirección', 'warning', 'direccion')
      } else if (this.tipo.trim() === '') {
        mostrarAlerta('Ingrese un tipo', 'warning', 'tipo')
      } else if (this.estilo.trim() === '') {
        mostrarAlerta('Ingrese un estilo', 'warning', 'estilo')
      } else if (this.descripcion.trim() === '') {
        mostrarAlerta('Ingrese una descripción', 'warning', 'descripcion')
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          ciudad: this.ciudad.trim(),
          direccion: this.direccion.trim(),
          tipo: this.tipo.trim(),
          estilo: this.estilo.trim(),
          descripcion: this.descripcion.trim(),
          archivo: imagen
        };
        enviarSolicitud('POST', parametros, this.url, 'Coro creado', 'coros');
      }
    },
    previsualizarImagen(event) {
      var file = event.target.files[0];
      if (typeof file != 'undefined') {
        var reader = new FileReader();
        reader.onload = function () {
          var url = URL.createObjectURL(file);
          this.archivo = url;
        }.bind(this);
        reader.readAsArrayBuffer(file);
      } else {
        this.archivo = process.env.BASE_URL + 'blanco.png';
      }
    }
  },
  mounted() {
    document.title = 'Chorus - Crear Coro';
  },
};
</script>