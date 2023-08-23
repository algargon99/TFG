<template>
  <div class="titulo">
    <span class="h1 text-white">Crear director</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          A&ntilde;adir nuevo cantor
        </div>
        <div class="card-body">
          <form class="form" v-on:submit="guardar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-user"></i>&nbsp; Nombre</span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del director"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-user"></i>&nbsp; Apellidos</span>
              <input type="text" required v-model="apellidos" id="apellidos" placeholder="Apellidos del director"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-location-dot"></i>&nbsp; Direcci&oacute;n</span>
              <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección del director"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-phone"></i>&nbsp; Tel&eacute;fono</span>
              <input type="text" required v-model="telefono" id="telefono" placeholder="Teléfono del director"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-envelope"></i>&nbsp; Correo electr&oacute;nico</span>
              <input type="email" required v-model="correo" id="correo" placeholder="Correo del director"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-calendar"></i>&nbsp; Fecha de nacimiento</span>
              <input type="date" required v-model="fechaNacimiento" id="fechaNacimiento"
                class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-city"></i>&nbsp; Escuela</span>
              <input type="text" required v-model="escuela" id="escuela"
                placeholder="Escuela del director" class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Crear director</button>
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
    guardar() {
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
      }else if (this.escuela.trim() === '') {
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
        enviarSolicitud('POST', parametros, this.url, 'Director creado','directores');
      }
    },
  },
};
</script>