import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '../views/HomeView.vue';

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

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
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
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
