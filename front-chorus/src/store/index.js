import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';


const store = createStore({
  state: {
    id: -1,
    user: null,
    rol: '0', // 0 invitado/no logueado, 1 administrador, 2 director, 3 cantor
    isAuthenticated: false,
    icono: 'icono.png',
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
    SET_ROL(state, rol) {
      state.rol = rol;
    },
    SET_ID(state, id) {
      state.id = id;
    },
    SET_AUTHENTICATED(state, value) {
      state.isAuthenticated = value;
    },
    SET_IMAGE(state, value) {
      state.icono = value;
    },
  },
  plugins: [createPersistedState()],
});

export default store;