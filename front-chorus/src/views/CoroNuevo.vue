<template>
  <div class="row mt-3">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header bg-primary text-white text-center">
            Crear nuevo coro
        </div>
        <div class="card-body">
          <form class="form" v-on:submit="guardar()">
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
              <input type="text" required v-model="nombre" id="nombre" placeholder="Nombre del coro" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-city"></i></span>
              <input type="text" required v-model="ciudad" id="ciudad" placeholder="Ciudad del coro" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
              <input type="text" required v-model="direccion" id="direccion" placeholder="Dirección del coro" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
              <input type="text" required v-model="tipo" id="tipo" placeholder="Tipo del coro" class="form-control">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa-solid fa-guitar"></i></span>
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

document.title = 'Chorus - Crear Coro';

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
      if (this.nombre.trim()==='') {
        mostrarAlerta('Ingrese un nombre','warning','nombre')
      } else if (this.ciudad.trim()==='') {
        mostrarAlerta('Ingrese una ciudad','warning','ciudad')
      }else if (this.direccion.trim()==='') {
        mostrarAlerta('Ingrese una dirección','warning','direccion')
      }else if (this.tipo.trim()==='') {
        mostrarAlerta('Ingrese un tipo','warning','tipo')
      }else if (this.estilo.trim()==='') {
        mostrarAlerta('Ingrese un estilo','warning','estilo')
      } else{
        var parametros = {
          nombre: this.nombre.trim(),
          ciudad: this.ciudad.trim(),
          direccion: this.direccion.trim(),
          tipo: this.tipo.trim(),
          estilo: this.estilo.trim(),
        };
        enviarSolicitud('POST',parametros,this.url,'Coro creado');
      }
    },
  },
};
</script>