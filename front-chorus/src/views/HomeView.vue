<template>
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th scope="col">Nº</th>
              <th scope="col">Nombre</th>
              <th scope="col">Ciudad</th>
              <th scope="col">Direcci&oacute;n</th>
              <th scope="col">Tipo</th>
              <th scope="col">Estilo</th>
              <th scope="col">Fecha creaci&oacute;n</th>
              <th scope="col">Ver</th>
              <th scope="col">Editar</th>
              <th scope="col">Borrar</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <tr v-if="this.cargando">
              <td colspan="8">
                <h4>Cargando...</h4>
              </td>
            </tr>
            <tr v-else v-for="coro, i in this.coros" :key="coro.id">
              <td v-text="(i + 1)"></td>
              <td v-text="coro.nombre"></td>
              <td v-text="coro.ciudad"></td>
              <td v-text="coro.direccion"></td>
              <td v-text="coro.tipo"></td>
              <td v-text="coro.estilo"></td>
              <td v-text="new Date(coro.created_at).toLocaleDateString()"></td>
              <td>
                <router-link :to="{ path: 'verCoro/' + coro.id }" class="btn btn-info">
                  <i class="fa-solid fa-eye"></i>
                </router-link>
              </td>
              <td>
                <router-link :to="{ path: 'editarCoro/' + coro.id }" class="btn btn-warning">
                  <i class="fa-solid fa-edit"></i>
                </router-link>
              </td>
              <td>
                <button v-on:click="eliminar(coro.id, coro.nombre)" class="btn btn-danger">
                  <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>

document.title = 'Chorus - Página principal';

import axios from "../../axiosConfig";
import { confirmar } from '../funciones';

export default {
  data() {
    return {
      coros: null,
      cargando: false,
    };
  },
  mounted() {
    this.listaCoros();
  },
  methods: {
    listaCoros() {
      this.cargando = true;
      axios.get('/api').then(
        res => {
          this.coros = res.data.data;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    },
    eliminar(id, nombre) {
      confirmar('/api/', id, 'Eliminar coro', 'Confirmar eliminación del coro ' + nombre);
      this.cargando = false;
    }
  },
};
</script>
