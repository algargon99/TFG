import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CoroNuevo from '../views/CoroNuevo.vue'
import CoroEditar from '../views/CoroEditar.vue'
import CoroVer from '../views/CoroVer.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
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
