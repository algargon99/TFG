import { createRouter, createWebHistory } from 'vue-router'

//COROS
import HomeView from '../views/HomeView.vue'
import CoroNuevo from '../views/CoroNuevo.vue'
import CoroEditar from '../views/CoroEditar.vue'
import CoroVer from '../views/CoroVer.vue'

//CANTORES
import CantoresView from '../views/CantoresView.vue'
import CantorNuevo from '../views/CantorNuevo.vue'
import CantorEditar from '../views/CantorEditar.vue'
import CantorVer from '../views/CantorVer.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/cantores',
    name: 'cantores',
    component: CantoresView
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
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
