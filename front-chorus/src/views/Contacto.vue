<template>
  <div class="gradiente">
    <img :src="logoUrl" alt="Chorus">
  </div>
  <div class="col-lg-8 offset-lg-2">
    <div class="bg-white borde" id="fondo">
      <h1 class="m-3">Contacta con el director del coro</h1>
      <p class="m-4">
        Bienvenido a Chorus, la plataforma perfecta para todos los amantes de la m&uacute;sica coral. &iquest;Te apasiona
        el canto en coros y buscas una manera de conectarte con otros entusiastas como t&uacute;? &iexcl;No busques
        m&aacute;s! Chorus te ofrece una experiencia &uacute;nica para descubrir y unirte a diversos coros en tu
        &aacute;rea y m&aacute;s all&aacute;. Con nuestra intuitiva aplicaci&oacute;n, podr&aacute;s explorar una amplia
        gama de coros, desde aquellos que se centran en cl&aacute;sicos atemporales hasta los que celebran la
        m&uacute;sica contempor&aacute;nea. &iexcl;La comunidad coral te espera con los brazos abiertos y estamos
        emocionados de que te unas a nosotros en este emocionante viaje musical!
      </p>
      <p class="m-4">
        &iquest;Listo para dar el siguiente paso en tu viaje vocal? Reg&iacute;strate hoy mismo en Chorus y descubre un
        mundo lleno de armon&iacute;a y melod&iacute;a. Nuestro formulario de inscripci&oacute;n es r&aacute;pido y
        sencillo. Proporciona tu nombre, apellidos y direcci&oacute;n de correo electr&oacute;nico, elige el coro que
        m&aacute;s te atraiga y d&eacute;janos un mensaje personal si deseas compartir tus expectativas o preguntas con el
        director del coro. Una vez que env&iacute;es el formulario, te aseguramos que tus datos ser&aacute;n enviados con
        seguridad al director correspondiente. Prep&aacute;rate para sumergirte en emocionantes ensayos, presentaciones
        inolvidables y nuevas amistades en el fascinante mundo coral. &iexcl;&Uacute;nete a Chorus hoy y d&eacute;jate
        llevar por la m&uacute;sica!
      </p>
    </div>
  </div>
  <div class="row mt-3 g-0">
    <div class="col-md-6 offset-md-3">
      <div class="card m-3">
        <div class="card-header bg-dark text-white text-center">
          Datos de contacto
        </div>
        <div class="card-body">
          <form @submit.prevent="submitForm">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" v-model="nombre" required>
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control" id="apellidos" v-model="apellidos" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="email" v-model="email" required>
            </div>
            <div class="mb-3">
              <label for="coro" class="form-label">Coro</label>
              <select class="form-control" id="coro" v-model="coro" required>
                <option v-for="ncoro in coros" :key="ncoro.id" :value="ncoro.nombre">{{ ncoro.nombre }}</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Comentario</label>
              <textarea class="form-control" id="message" rows="5" v-model="comentario" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 d-flex justify-content-center">
    <router-link :to="{ path: '/' }" class='btn btn-danger'>
      <i class="fa-solid fa-arrow-left"></i> Volver
    </router-link>
  </div>
</template>

<script>


import axios from "../../axiosConfig";
import { mostrarAlerta, enviarSolicitud } from '../funciones';

export default {
  data() {
    return {
      logoUrl: process.env.BASE_URL + 'logoBlanco.png',
      nombre: '',
      apellidos: '',
      email: '',
      coro: '',
      comentario: '',
      coros: ''
    };
  },
  methods: {
    submitForm() {
      var parametros = {
        nombre: this.nombre,
        apellidos: this.apellidos,
        email: this.email,
        coro: this.coro,
        comentario: this.comentario
      };
      enviarSolicitud('POST', parametros, '/api/usuario','¡Gracias por enviar el formulario! Los datos se han registrado correctamente.', '');

    },
    listaCoros() {
      this.cargando = true;
      axios.get('/api/coros').then(
        res => {
          this.coros = res.data;
          this.coro = this.coros[0].id;
          this.cargando = false;
        }
      ).catch(error => {
        console.error(error);
      });
    }
  },
  mounted() {
    this.listaCoros();
    document.title = "Chorus - Contacta con el director del coro";
  }
};
</script>
