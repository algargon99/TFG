import { createRouter, createWebHistory } from 'vue-router'

//USUARIOS
import Login from '../views/Login.vue';
import Usuario from '../views/Usuario.vue';
import Registro from '../views/Registro.vue';
import Contacto from '../views/Contacto.vue';
import Pass from '../views/Pass.vue';

//ASIGNACIONES
import Asignar from '../views/Asignar.vue';
import AsignarUsuario from '../views/AsignarUsuario.vue';

//INICIO

import Inicio from '../views/Inicio.vue';

//COROS
import Coros from '../views/Coros.vue'
import CoroNuevo from '../views/CoroNuevo.vue'
import CoroEditar from '../views/CoroEditar.vue'
import CoroVer from '../views/CoroVer.vue'

//CANTORES
import Cantores from '../views/Cantores.vue'
import CantorNuevo from '../views/CantorNuevo.vue'
import CantorEditar from '../views/CantorEditar.vue'
import CantorVer from '../views/CantorVer.vue'

//DIRECTORES
import Directores from '../views/Directores.vue'
import DirectorNuevo from '../views/DirectorNuevo.vue'
import DirectorEditar from '../views/DirectorEditar.vue'
import DirectorVer from '../views/DirectorVer.vue'

//PARTITURAS
import PartituraNueva from '../views/PartituraNueva.vue'
import PartituraEditar from '../views/PartituraEditar.vue'
import PartituraVer from '../views/PartituraVer.vue'

//AUDIOS
import AudioNuevo from '../views/AudioNuevo.vue'
import AudioEditar from '../views/AudioEditar.vue'
import AudioVer from '../views/AudioVer.vue'

//VIDEOS
import VideoNuevo from '../views/VideoNuevo.vue'
import VideoEditar from '../views/VideoEditar.vue'
import VideoVer from '../views/VideoVer.vue'

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/pass',
    name: 'pass',
    component: Pass
  },
  {
    path: '/',
    name: 'inicio',
    component: Inicio
  },
  {
    path: '/contacto',
    name: 'contacto',
    component: Contacto
  },
  {
    path: '/datosUsuario',
    name: 'datosUsuario',
    component: Usuario
  },
  {
    path: '/registro',
    name: 'resgistro',
    component: Registro
  },
  {
    path: '/asignar',
    name: 'asignar',
    component: Asignar
  },
  {
    path: '/asignarUsuario/:id',
    name: 'asignarUsuario',
    component: AsignarUsuario
  },
  {
    path: '/coros',
    name: 'coros',
    component: Coros
  },

  {
    path: '/crearCoro',
    name: 'crearCoro',
    component: CoroNuevo
  },
  {
    path: '/verCoro/:id',
    name: 'verCoro',
    component: CoroVer
  },
  {
    path: '/editarCoro/:id',
    name: 'editarCoro',
    component: CoroEditar
  },
  {
    path: '/cantores',
    name: 'cantores',
    component: Cantores
  },
  {
    path: '/crearCantor',
    name: 'crearCantor',
    component: CantorNuevo
  },
  {
    path: '/verCantor/:id',
    name: 'verCantor',
    component: CantorVer
  },
  {
    path: '/editarCantor/:id',
    name: 'editarCantor',
    component: CantorEditar
  },
  {
    path: '/directores',
    name: 'directores',
    component: Directores
  },
  {
    path: '/crearDirector',
    name: 'crearDirector',
    component: DirectorNuevo
  },
  {
    path: '/verDirector/:id',
    name: 'verDirector',
    component: DirectorVer
  },
  {
    path: '/editarDirector/:id',
    name: 'editarDirector',
    component: DirectorEditar
  },
  {
    path: '/crearPartitura/:id',
    name: 'crearPartitura',
    component: PartituraNueva
  },
  {
    path: '/verPartitura/:id',
    name: 'verPartitura',
    component: PartituraVer
  },
  {
    path: '/editarPartitura/:id',
    name: 'editarPartitura',
    component: PartituraEditar
  },
  {
    path: '/crearAudio/:id',
    name: 'crearAudio',
    component: AudioNuevo
  },
  {
    path: '/verAudio/:id',
    name: 'verAudio',
    component: AudioVer
  },
  {
    path: '/editarAudio/:id',
    name: 'editarAudio',
    component: AudioEditar
  },
  {
    path: '/editarVideo/:id',
    name: 'editarVideo',
    component: VideoEditar
  }, 
  {
    path: '/crearVideo/:id',
    name: 'crearVideo',
    component: VideoNuevo
  },
  {
    path: '/verVideo/:id',
    name: 'verVideo',
    component: VideoVer
  },

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
