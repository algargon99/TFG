<template>
  <div>
    <h2>Iniciar sesión</h2>
    <form @submit.prevent="login">
      <input type="email" v-model="email" placeholder="Correo electrónico" required>
      <input type="password" v-model="password" placeholder="Contraseña" required>
      <button type="submit">Iniciar sesión</button>
    </form>
  </div>
</template>
  
<script>
export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    login() {
      // Aquí puedes realizar la llamada a la API de Laravel para iniciar sesión
    },
  },
};
</script>