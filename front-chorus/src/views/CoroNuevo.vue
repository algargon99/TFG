<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Crear coro</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Crear nuevo coro
        </div>
        <div class="card-body">
          <form class="form" v-on:submit="guardar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i>&nbsp; Nombre</span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del coro" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-city"></i> &nbsp; Ciudad</span>
              <input type="text" required v-model="ciudad" id="ciudad" placeholder="Ciudad del coro" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-location-dot"></i>&nbsp; Direcci&oacute;n</span>
              <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección del coro"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i>&nbsp; Tipo</span>
              <input type="text" required v-model="tipo" id="tipo" placeholder="Tipo del coro" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-guitar"></i>&nbsp; Estilo</span>
              <input type="text" required v-model="estilo" id="estilo" placeholder="Estilo del coro" class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">

              <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Crear coro</button>
            </div>
          </form>
        </div>
      </div>
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
      url: '/api/coros',
      cargando: false,
    };
  },
  methods: {
    guardar() {
      event.preventDefault();
      this.cargando = true;
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
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          ciudad: this.ciudad.trim(),
          direccion: this.direccion.trim(),
          tipo: this.tipo.trim(),
          estilo: this.estilo.trim(),
        };
        enviarSolicitud('POST', parametros, this.url, 'Coro creado', 'coros');
      }
    },
  },
  mounted() {
    document.title = 'Chorus - Crear Coro';
  },
};
</script>