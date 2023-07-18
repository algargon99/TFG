import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';


const store = createStore({
  state: {
    user: null,
    isAuthenticated: false,
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
    SET_AUTHENTICATED(state, value) {
      state.isAuthenticated = value;
    },
  },
  plugins: [createPersistedState()],
});

export default store;