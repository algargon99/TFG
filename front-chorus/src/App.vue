<template>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <div class="nav-item">
      <router-link to="/">
        <img class="navbar-brand" src='../public/logoBlanco.png' alt="Logo" width="200">
      </router-link>
    </div>
    <div class="nav-item d-flex">
      <div>
        <button class="navbar-toggler d-md-none collapsed m-3" type="button" data-bs-toggle="collapse"
          data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="me-4 d-flex">
        <div v-if="this.$store.state.isAuthenticated === false" class="m-2">
          <router-link class="nav-link" to="/login">Iniciar sesi&oacute;n</router-link>
        </div>
        <div v-if="this.$store.state.isAuthenticated === true" class="m-2 dropdown d-flex align-items-center">
          <a class="nav-link d-flex" href="#" id="sesion" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="d-flex">
              <div><img :src=imagen width="30"></div>
              <div class="d-flex align-items-center mx-2">{{ this.$store.state.user }}</div>
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="sesion">
            <li><router-link class="dropdown-item" to='/datosUsuario'>Mi perfil</router-link></li>
            <li><router-link class="dropdown-item" to='/datosUsuario'>Cerrar sesi&oacute;n</router-link></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <div>
    <nav v-if="this.$store.state.rol != '0'" id="sidebarMenu"
      class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column p-2">
          <li class="nav-item dropdown">
            <button class="btn nav-link btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
              data-bs-target="#coros-collapse" aria-expanded="false">
              Coros
            </button>
            <div class="collapse" id="coros-collapse">
              <ul class="navbar btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                <li class="nav-item">
                  <router-link class="nav-link" to="/coros">Lista de coros</router-link>
                </li>
                <li class="nav-item" v-if="this.$store.state.rol === '1'">
                  <router-link to="/crearCoro" class="nav-link">Crear coro</router-link>
                </li>
              </ul>
            </div>
          </li>
          <li v-if="this.$store.state.rol === '1'" class="nav-item dropdown">
            <button class="btn nav-link btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
              data-bs-target="#cantores-collapse" aria-expanded="false">
              Cantores
            </button>
            <div class="collapse" id="cantores-collapse">
              <ul class="navbar btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                <li class="nav-item">
                  <router-link class="nav-link" to="/cantores">Lista de cantores</router-link>
                </li>
                <li class="nav-item" v-if="this.$store.state.rol === '1'">
                  <router-link to="/crearCantor" class="nav-link">Crear cantor</router-link>
                </li>
              </ul>
            </div>
          </li>
          <li v-if="this.$store.state.rol === '1'" class="nav-item dropdown">
            <button class="btn nav-link btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
              data-bs-target="#directores-collapse" aria-expanded="false">
              Directores
            </button>
            <div class="collapse" id="directores-collapse">
              <ul class="navbar btn-toggle-nav list-unstyled fw-normal pb-1 small ps-3">
                <li class="nav-item">
                  <router-link class="nav-link" to="/directores">Lista de directores</router-link>
                </li>
                <li class="nav-item" v-if="this.$store.state.rol === '1'">
                  <router-link to="/crearDirector" class="nav-link">Crear director</router-link>
                </li>
              </ul>
            </div>
          </li>
          <li v-if="this.$store.state.rol === '1'" class="nav-item">
            <router-link to="/asignar" class="nav-link">Asignar</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/contacto" class="nav-link">Contacto</router-link>
          </li>
        </ul>
      </div>
    </nav>
  </div>

  <div id="contenedor" :style="{ marginLeft: margenContenedor }">
    <router-view />
  </div>

  <div>
    <footer class="fixed-bottom navbar-dark bg-dark">
      <div class="d-flex justify-content-center p-4" style="color: rgba(255, 255, 255, 0.55);">
        © Chorus - Alberto García González 2023. Todos los derechos reservados.
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      margenContenedor: "0px",
      imagen: 'http://localhost:8000/' + this.$store.state.icono
    };
  },
  methods: {
    rolMargen() {
      if (this.$store.state.isAuthenticated) {
        this.margenContenedor = "200px";
      }
    }
  },
  mounted() {
    this.rolMargen();
  },
};
</script>