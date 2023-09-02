<template>
  <div v-if="this.$store.state.isAuthenticated == true">
    <div class="titulo">
      <span>Contacta con los coros</span>
    </div>
    <div class="row g-0 mt-6">
      <div class="col-10 col-sm-5 offset-1 bloque d-flex align-items-center">
        <p class="m-4">
          &iquest;Listo para dar el siguiente paso en tu viaje vocal? Elige el coro que
          m&aacute;s te atraiga y d&eacute;janos un mensaje personal si deseas compartir tus expectativas o preguntas con
          el director del coro. Una vez que env&iacute;es el formulario, te aseguramos que tus datos ser&aacute;n enviados
          con
          seguridad al director correspondiente. Prep&aacute;rate para sumergirte en emocionantes ensayos, presentaciones
          inolvidables y nuevas amistades en el fascinante mundo coral. &iexcl;&Uacute;nete a Chorus hoy y d&eacute;jate
          llevar por la m&uacute;sica!
        </p>
      </div>
      <div class="col-10 col-sm-4 offset-1 bloque d-flex align-items-center">
        <form @submit.prevent="contactar" class="w-100 p-5">
          <div class="mb-3">
            <label for="coro" class="form-label">Coro:</label>
            <select class="form-control" id="coro" v-model="coro" required>
              <option class="text-black" v-for="ncoro in coros" :key="ncoro.id" :value="ncoro.id">{{ ncoro.nombre }}
              </option>
            </select>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Comentario:</label>
            <textarea class="form-control" id="message" rows="5" v-model="comentario" required></textarea>
          </div>
          <div class="mb-3 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Enviar comentario</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div v-else class="titulo">
    <span>Acceso denegado</span>
    <p class="acceso">Inicia sesión para acceder a la aplicación</p>
    <div class="py-5">
      <router-link :to="{ path: '/' }" class="btn btn-danger">
        Volver al inicio
      </router-link>
    </div>
  </div>
</template>

<script>


import axios from "../../axiosConfig";
import { enviarSolicitud } from '../funciones';

export default {
  data() {
    return {
      coro: '',
      comentario: '',
      coros: ''
    };
  },
  methods: {
    contactar() {
      var parametros = {
        id: this.$store.state.id,
        coro: this.coro,
        comentario: this.comentario
      };
      enviarSolicitud('POST', parametros, '/api/usuario', '¡Gracias por enviar el formulario! Los datos se han registrado correctamente.', 'coros');

    },
    listaCoros() {
      this.cargando = true;
      axios.get('/api/coros').then(
        res => {
          this.coros = res.data;
          this.coros.sort((a, b) => a.nombre.localeCompare(b.nombre));
          this.coro = this.coros[0].id;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    }
  },
  mounted() {
    if (this.$store.state.isAuthenticated == true) {
      this.listaCoros();
    }
    document.title = "Chorus - Contacta con el director del coro";
  }
};
</script>
