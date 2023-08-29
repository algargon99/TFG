<template>
  <div class=" titulo">
    <span class="h1 text-white">Editar cantor {{ nombre }} {{ apellidos }}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-4 offset-md-4">
      <form class="form" v-on:submit="editarCantor()">
        <div class="mb-3">
          <span>Nombre:</span>
          <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del cantor" class="form-control">
        </div>
        <div class="mb-3">
          <span>Apellidos:</span>
          <input type="text" required v-model="apellidos" id="apellidos" placeholder="Apellidos del cantor"
            class="form-control">
        </div>
        <div class="mb-3">
          <span>Direcci&oacute;n:</span>
          <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección del cantor"
            class="form-control">
        </div>
        <div class="mb-3">
          <span>Tel&eacute;fono:</span>
          <input type="text" required v-model="telefono" id="telefono" placeholder="Teléfono del cantor"
            class="form-control">
        </div>
        <div class="mb-3">
          <span>Correo electr&oacute;nico:</span>
          <input type="email" required v-model="correo" id="correo" placeholder="Correo del cantor" class="form-control">
        </div>
        <div class="mb-3">
          <span>Fecha de nacimiento:</span>
          <input type="date" required v-model="fechaNacimiento" id="fechaNacimiento"
            placeholder="Fecha de nacimiento del cantor" class="form-control">
        </div>
        <div class="mb-3">
          <span>Voz:</span>
          <input type="text" required v-model="voz" id="voz" placeholder="Voz del cantor" class="form-control">
        </div>
        <div class="d-grid col-3 mx-auto py-3">
          <button class="btn btn-warning">Actualizar</button>
        </div>
      </form>
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
      apellidos: '',
      direccion: '',
      telefono: '',
      correo: '',
      fechaNacimiento: '',
      voz: '',
      url: '/api/cantores',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getCantor();
    document.title = 'Chorus - Editar cantor';
  },
  methods: {
    getCantor() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.direccion = res.data.usuario.direccion;
          this.telefono = res.data.usuario.telefono;
          this.correo = res.data.usuario.correo;
          this.fechaNacimiento = res.data.usuario.fechaNacimiento;
          this.voz = res.data.voz;
        }
      );
    },
    editarCantor() {
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
        mostrarAlerta('Ingrese una fecha', 'warning', 'fechaNacimiento')
      } else if (this.voz.trim() === '') {
        mostrarAlerta('Ingrese una voz', 'warning', 'voz')
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          apellidos: this.apellidos.trim(),
          direccion: this.direccion.trim(),
          telefono: this.telefono.trim(),
          correo: this.correo.trim(),
          fechaNacimiento: this.fechaNacimiento.trim(),
          voz: this.voz.trim(),
        };
        enviarSolicitud('PUT', parametros, this.url, 'Cantor actualizado', 'cantores');
      }
    },
  },
};
</script>