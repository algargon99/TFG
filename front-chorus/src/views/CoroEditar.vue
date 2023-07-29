<template>
  <div class="gradiente titulo ps-5 pt-4">
    <span class="h1 text-white">Editar coro {{ nombre }}</span>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-dark text-white text-center">
          Editar coro
        </div>
        <div class="card-body">
          <form class="form" v-on:submit="editar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i> &nbsp; Nombre</span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del coro" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-city"></i>&nbsp; Ciudad</span>
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
            <div class="input-group mb-3">
              <span class="w-100">Incluye una peque&ntilde;a descripci&oacute;n:</span>
              <textarea required v-model="descripcion" placeholder="Descripción" id="descripcion" class="form-control" />
            </div>
            <div class="d-grid col-6 mx-auto mb-3">
              <button class="btn btn-warning"><i class="fa-solid fa-refresh"></i> Actualizar</button>
            </div>
          </form>
        </div>
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



import { mostrarAlerta, enviarSolicitud } from '../funciones';
import { useRoute } from "vue-router";
import axios from "../../axiosConfig";

export default {
  data() {
    return {
      id: 0,
      nombre: '',
      ciudad: '',
      direccion: '',
      tipo: '',
      estilo: '',
      descripcion: '',
      url: '/api/coros',
      cargando: false,
    };
  },
  mounted() {
    const route = useRoute();
    this.id = route.params.id;
    this.url += '/' + this.id;
    this.getCoro();
    document.title = 'Chorus - Editar Coro';
  },
  methods: {
    getCoro() {
      axios.get(this.url).then(
        res => {
          this.nombre = res.data.nombre;
          this.ciudad = res.data.ciudad;
          this.direccion = res.data.direccion;
          this.tipo = res.data.tipo;
          this.estilo = res.data.estilo;
          this.descripcion = res.data.descripcion;
        }
      );
    },
    editar() {
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
        };
        enviarSolicitud('PUT', parametros, this.url, 'Coro actualizado', 'coros');
      }
    },
  },
};
</script>