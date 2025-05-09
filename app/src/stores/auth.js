import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('authToken') || null,
    user: JSON.parse(localStorage.getItem('authUser')) || null
  }),
  actions: {
    setToken(token) {
      this.token = token;
      localStorage.setItem('authToken', token);

      if (token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      } else {
        delete axios.defaults.headers.common['Authorization'];
      }
    },
    setUser(user) {
      this.user = user;
      console.log("setar usuario")
      localStorage.setItem('authUser', JSON.stringify(user));
    },
    logout() {
      this.token = null;
      this.user = null;
      localStorage.removeItem('authToken');
      localStorage.removeItem('authUser');
      delete axios.defaults.headers.common['Authorization'];

      if (this.router) {
        this.router.push('/login');
      }
    },
    initialize() {
      if (this.token) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
      }
    }
  },
  getters: {
    isAuthenticated: (state) => !!state.token
  }
});