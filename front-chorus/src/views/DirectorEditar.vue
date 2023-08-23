<template>
  <div class="titulo">
    <span class="h1 text-white">Editar director {{nombre}} {{apellidos}}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Editar director
        </div>
        <div class="card-body">
          <form class="form" v-on:submit="editar()">
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
                placeholder="Fecha de nacimiento del director" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-city"></i>&nbsp; Escuela</span>
              <input type="text" required v-model="escuela" id="escuela" placeholder="Escuela del director" class="form-control">
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-warning"><i class="fa-solid fa-refresh"></i> Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-6 mx-auto my-3">
      <router-link :to="{ path: '/directores' }" class='btn btn-danger'>
        <i class="fa-solid fa-arrow-left"></i> Volver
      </router-link>
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
      escuela: '',
      url: '/api/directores',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getDirector();
    document.title = 'Chorus - Editar director';
  },
  methods: {
    getDirector() {
      axios.get(this.url).then(
        res => {
          console.log(res);
          this.nombre = res.data.usuario.nombre;
          this.apellidos = res.data.usuario.apellidos;
          this.direccion = res.data.usuario.direccion;
          this.telefono = res.data.usuario.telefono;
          this.correo = res.data.usuario.correo;
          this.fechaNacimiento = res.data.usuario.fechaNacimiento;
          this.escuela = res.data.escuela;
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
        console.log(parametros);
        enviarSolicitud('PUT', parametros, this.url, 'Director actualizado','directores');
      }
    },
  },
};
</script>