<template>
  <div class="container d-flex justify-content-center align-content-center mt-5">
    <div class="card login bg-dark">
      <div class="d-flex justify-content-center m-3">
        <img :src="logoUrl" alt="Chorus" class="w-75">
      </div>
      <div id="login" class="d-flex justify-content-center">
        <span>Iniciar sesi&oacute;n</span>
      </div>
      <div class="card-body">
        <form @submit.prevent="login">
          <div class="form-group m-3">
            <label for="email" class="text-white my-1">Correo electrónico:</label>
            <input type="email" v-model="email" class="form-control" id="email" placeholder="Correo electrónico" required>
          </div>
          <div class="form-group m-3">
            <label for="password" class="text-white my-1">Contrase&ntilde;a: </label>
            <input type="password" v-model="password" class="form-control" id="password" placeholder="Contraseña"
              required>
          </div>
          <div class="d-flex justify-content-center my-4">
            <button type="submit" class="btn btn-primary ">Iniciar sesión</button>
          </div>
        </form>
        <div class="my-5">
          <div class="d-flex justify-content-center m-2">
            <span class="text-white">¿A&uacute;n no te has registrado? &nbsp;</span>
            <router-link :to="{ path: 'registro' }" class="text-secondary">
              Reg&iacute;strate
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>

import { mostrarAlerta, loginBack } from '../funciones';

export default {
  data() {
    return {
      logoUrl: process.env.BASE_URL + 'logoBlanco.png',
      email: '',
      password: '',
    };
  },
  mounted() {
    this.$store.commit('SET_USER', null);
    this.$store.commit('SET_AUTHENTICATED', false);
  },
  methods: {
    login() {
      var email = this.email;
      var password = this.password;
      if (email.trim() === '') {
        mostrarAlerta('Ingrese un correo electrónico', 'warning', 'email')
      } else if (password.trim() === '') {
        mostrarAlerta('Ingrese una constraseña', 'warning', 'password')
      } else {
        loginBack(email, password)
          .then(data => {
            if (Number.isInteger(data[0])) {
              this.$store.commit('SET_ID', data[0]);
              this.$store.commit('SET_USER', email);
              this.$store.commit('SET_AUTHENTICATED', true);
              this.$store.commit('SET_ROL', data[1]);
              this.$store.commit('SET_IMAGE', data[2]);
              window.setTimeout(function () {
                window.location.href = "/coros";
              }, 500);
            } else if (data == "pass") {
              mostrarAlerta("Contraseña incorrecta", 'error');
            } else if (data == "user") {
              mostrarAlerta("Usuario " + email + " no existe", 'error');
            }
          })
          .catch(error => {
            mostrarAlerta(error.message, 'error');
            console.log(error);
          });
      }
    }
  }
};
</script>