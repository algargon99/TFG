<template>
  <div class="titulo ps-5 pt-4">
    <span class="h1 text-white">Crear cuenta</span>
  </div>
  <div class="my-3 d-flex justify-content-center w-100">
    <div class="bloque w-100">
      <form class="form" v-on:submit="guardar()">
        <div class="w-100 d-flex justify-content-center">
          <div id="izquierda" class="me-5 w-25">
            <div class="mb-3">
              <span>Nombre:</span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre" class="form-control mt-1">
            </div>
            <div class="mb-3">
              <span>Apellidos:</span>
              <input type="text" required v-model="apellidos" id="apellidos" placeholder="Apellidos" class="form-control mt-1">
            </div>
            <div class="mb-3">
              <span>Direcci&oacute;n:</span>
              <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección" class="form-control mt-1">
            </div>
            <div class="mb-3">
              <span>Tel&eacute;fono:</span>
              <input type="text" required v-model="telefono" id="telefono" placeholder="Teléfono" class="form-control mt-1">
            </div>
          </div>
          <div id="derecha" class="ms-5 w-25">
            <div class="mb-3">
              <span>Correo electr&oacute;nico:</span>
              <input type="email" required v-model="correo" id="correo" placeholder="Correo" class="form-control mt-1">
            </div>
            <div class="mb-3">
              <span>Fecha de nacimiento:</span>
              <input type="date" required v-model="fechaNacimiento" id="fechaNacimiento" placeholder="Fecha Nacimiento" class="form-control mt-1">
            </div>
            <div class="mb-3">
              <span>Contrase&ntilde;a:</span>
              <input type="password" required v-model="pass" id="pass" placeholder="Contraseña" class="form-control mt-1">
            </div>
            <div class="mb-3">
              <span>Repetir contrase&ntilde;a:</span>
              <input type="password" required v-model="repass" id="repass" placeholder="Repetir contraseña" class="form-control mt-1">
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <div class="m-3"><button class="btn btn-secondary">Crear cuenta</button></div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>



import { mostrarAlerta, registro } from '../funciones';

export default {
  data() {
    return {
      nombre: '',
      apellidos: '',
      direccion: '',
      telefono: '',
      correo: '',
      fechaNacimiento: '',
      pass: '',
      repass: '',
      url: '/api/cuenta',
      cargando: false,
    };
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
      } else if (this.pass.trim() === '') {
        mostrarAlerta('Ingrese contraseña', 'warning', 'pass')
      } else if (this.repass.trim() != this.pass.trim()) {
        mostrarAlerta('Las contraseñas indicadas no son iguales', 'warning', 'pass')
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          apellidos: this.apellidos.trim(),
          direccion: this.direccion.trim(),
          telefono: this.telefono.trim(),
          correo: this.correo.trim(),
          fechaNacimiento: this.fechaNacimiento.trim(),
          pass: this.pass.trim(),
          repass: this.repass.trim(),

        };
        registro(parametros, this);
      }
    },
  },
  mounted() {
    document.title = 'Chorus - Registro';
  },
};
</script>