<template>
  <div v-if="this.$store.state.isAuthenticated == true && this.$store.state.rol == 1">
    <div class="titulo">
      <span class="h1 text-white">Crear director</span>
    </div>
    <div class="row mt-3 g-0">
      <div class="col-4 offset-4 bloque">
        <form class="form" v-on:submit="crearDirector()">
          <div class="mb-3">
            <span>Nombre:</span>
            <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del director"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>Apellidos:</span>
            <input type="text" required v-model="apellidos" id="apellidos" placeholder="Apellidos del director"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>Direcci&oacute;n:</span>
            <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección del director"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>Tel&eacute;fono:</span>
            <input type="text" required v-model="telefono" id="telefono" placeholder="Teléfono del director"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>Correo electr&oacute;nico:</span>
            <input type="email" required v-model="correo" id="correo" placeholder="Correo del director"
              class="form-control">
          </div>
          <div class="mb-3">
            <span>Fecha de nacimiento:</span>
            <input type="date" required v-model="fechaNacimiento" id="fechaNacimiento" class="form-control">
          </div>
          <div class="mb-3">
            <span>Escuela:</span>
            <input type="text" required v-model="escuela" id="escuela" placeholder="Escuela del director"
              class="form-control">
          </div>
          <div class="alert alert-success my-5">
            La foto ser&aacute; asignada por defecto
          </div>
          <div class="d-grid col-4 mx-auto py-3">
            <button class="btn btn-primary">Crear director</button>
          </div>
        </form>
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

export default {
  data() {
    return {
      nombre: '',
      apellidos: '',
      direccion: '',
      telefono: '',
      correo: '',
      fechaNacimiento: '',
      escuela: '',
      url: '/api/directores',
      cargando: false,
    };
  },
  mounted() {
    document.title = 'Chorus - Crear Director';
  },
  methods: {
    crearDirector() {
      event.preventDefault();
      this.cargando = true;
      if (this.nombre.trim() === '') {
        mostrarAlerta('Ingrese un nombre', 'warning', 'nombre')
      } else if (this.apellidos.trim() === '') {
        mostrarAlerta('Ingrese apellidos', 'warning', 'apellidos')
      } else if (this.direccion.trim() === '') {
        mostrarAlerta('Ingrese una dirección', 'warning', 'direccion')
      } else if (this.telefono.trim() === '') {
        mostrarAlerta('Ingrese un teléfono', 'warning', 'telefono')
      } else if (this.correo.trim() === '') {
        mostrarAlerta('Ingrese un correo', 'warning', 'correo')
      } else if (this.fechaNacimiento.trim() === '') {
        mostrarAlerta('Ingrese una fecha de nacimiento', 'warning', 'fechaNacimiento')
      } else if (this.escuela.trim() === '') {
        mostrarAlerta('Ingrese una escuela', 'warning', 'escuela')
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          apellidos: this.apellidos.trim(),
          direccion: this.direccion.trim(),
          telefono: this.telefono.trim(),
          correo: this.correo.trim(),
          fechaNacimiento: this.fechaNacimiento.trim(),
          escuela: this.escuela.trim(),
        };
        enviarSolicitud('POST', parametros, this.url, 'Director creado', 'directores');
      }
    },
  },
};
</script>