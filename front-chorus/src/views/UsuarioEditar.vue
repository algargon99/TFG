<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Editar perfil</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Editar perfil
        </div>
        <div class="card-body">
          <form class="form" v-on:submit="editar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
              <input type="text" required v-model="apellidos" id="apellidos" placeholder="Apellidos" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
              <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
              <input type="text" required v-model="telefono" id="telefono" placeholder="Teléfono" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
              <input type="email" required v-model="correo" id="correo" placeholder="Correo" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
              <input type="date" required v-model="fechaNacimiento" id="fechaNacimiento" class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-warning"><i class="fa-solid fa-refresh"></i> Editar usuario</button>
            </div>
          </form>
          <div class="alert alert-info m-3" role="alert">
            El dato de cantor o director será actualizado avisando al administrador.
          </div>
        </div>
      </div>
    </div>
    <div class="col-6 mx-auto my-3">
      <router-link :to="{ path: '/datosUsuario' }" class='btn btn-danger'>
        <i class="fa-solid fa-arrow-left"></i> Volver
      </router-link>
    </div>
  </div>
</template>

<script>



import { mostrarAlerta, enviarSolicitud } from '../funciones';
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: this.$store.state.id,
      nombre: '',
      apellidos: '',
      direccion: '',
      telefono: '',
      correo: '',
      fechaNacimiento: '',
      url: '/api/usuario',
      cargando: false,
    };
  },
  mounted() {
    this.url += '/' + this.id;
    this.getUsuario();
    document.title = 'Chorus - Editar perfil';
  },
  methods: {
    getUsuario() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.direccion = res.data.usuario.direccion;
          this.telefono = res.data.usuario.telefono;
          this.correo = res.data.usuario.correo;
          this.fechaNacimiento = res.data.usuario.fechaNacimiento;
        }
      );
    },
    editar() {
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
      } else {
        var parametros = {
          nombre: this.nombre.trim(),
          apellidos: this.apellidos.trim(),
          direccion: this.direccion.trim(),
          telefono: this.telefono.trim(),
          correo: this.correo.trim(),
          fechaNacimiento: this.fechaNacimiento.trim(),
        };
        enviarSolicitud('PUT', parametros, this.url, 'Perfil actualizado', 'datosUsuario');
      }
    },
  },
};
</script>