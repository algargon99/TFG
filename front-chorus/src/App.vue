<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand me-auto">
              <img src='../public/logo.png' alt="Logo" height="60">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Coros
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                          <router-link class="dropdown-item" to="/">Listar coros</router-link>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                        <router-link to="/crearCoro" class="dropdown-item">Crear coro</router-link>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Partituras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Usuarios</a>
                    </li>
                </ul>
            </div> 
        </div>
    </nav>
    <div class="container-fluid">
      <router-view/>    
    </div>
</template>