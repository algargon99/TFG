import { createStore } from 'vuex';

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
});

export default store;