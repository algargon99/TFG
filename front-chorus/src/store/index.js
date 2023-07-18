import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';


const store = createStore({
  state: {
    id: -1,
    user: null,
    isAuthenticated: false,
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
    SET_ID(state, id) {
      state.id = id;
    },
    SET_AUTHENTICATED(state, value) {
      state.isAuthenticated = value;
    },
  },
  plugins: [createPersistedState()],
});

export default store;