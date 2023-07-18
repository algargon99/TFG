<template>
  <div class="gradiente titulo ps-5 pt-4"></div>
  <div>
    <h2>Iniciar sesión</h2>
    <form @submit.prevent="login">
      <input type="text" v-model="email" placeholder="Correo electrónico" required>
      <input type="text" v-model="password" placeholder="Contraseña" required>
      <button type="submit">Iniciar sesión</button>
    </form>
  </div>
</template>
  
<script>

import { mostrarAlerta, loginBack } from '../funciones';

export default {
  data() {
    return {
      email: '',
      password: '',
    };
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
            console.log(data);
            mostrarAlerta("Usuario " + email + " ha accedido correctamente", 'success');
            this.$store.commit('SET_USER', email);
            this.$store.commit('SET_AUTHENTICATED', true);
            console.log(this.$store.state.user);
          })
          .catch(error => {
            mostrarAlerta(error.message, 'error');
            console.log(error);
          });
      }

      //this.$router.push('/inicio');

    }
  }
};
</script>