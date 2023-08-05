<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <router-link class="navbar-brand " to="/">
        <img src='../public/logoBlanco.png' alt="Logo" height="60">
      </router-link>
      <div v-if="this.$store.state.isAuthenticated === true">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Coros
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <router-link class="dropdown-item" to="/coros">Lista de coros</router-link>
                </li>
                <li v-if="this.$store.state.rol === '1'">
                  <hr class="dropdown-divider">
                </li>
                <li v-if="this.$store.state.rol === '1'">
                  <router-link to="/crearCoro" class="dropdown-item">Crear coro</router-link>
                </li>
              </ul>
            </li>
            <li v-if="this.$store.state.rol === '1'" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Cantores
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <router-link class="dropdown-item" to="/cantores">Lista de cantores</router-link>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <router-link to="/crearCantor" class="dropdown-item">Crear cantor</router-link>
                </li>
              </ul>
            </li>
            <li v-if="this.$store.state.rol === '1'" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Directores
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <router-link class="dropdown-item" to="/directores">Lista de directores</router-link>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <router-link to="/crearDirector" class="dropdown-item">Crear director</router-link>
                </li>
              </ul>
            </li>
            <li v-if="this.$store.state.rol === '1'" class="nav-item">
              <router-link to="/asignar" class="nav-link">Asignar</router-link>
            </li>
          </ul>
        </div>
      </div>
      <div class="d-flex justify-content-end ">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link v-if="this.$store.state.isAuthenticated === false" class="nav-link" to="/login">Iniciar
              sesi&oacute;n</router-link>
            <router-link v-if="this.$store.state.isAuthenticated === true" class="nav-link" to='/datosUsuario'>{{
              this.$store.state.user }}</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/contacto" class="nav-link">Contacto</router-link>
          </li>
        </ul>

      </div>
    </div>
  </nav>
  <div id="contenedor" class="min-vh-100">
    <router-view />
  </div>

  <div>
    <footer class="fixed-sticked bottom-0 navbar-dark bg-dark ">
      <div class="gradienteInverso titulo ps-5 pt-4"></div>
      <div class="d-flex justify-content-center p-4" style="color: rgba(255, 255, 255, 0.55);">
        © Chorus - Alberto García González 2023. Todos los derechos reservados.
      </div>
    </footer>
  </div>
</template>