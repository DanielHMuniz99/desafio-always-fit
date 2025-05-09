<template>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-white">
              <h3 class="mb-0">Login</h3>
            </div>
            <div class="card-body">
              <div v-if="successMessage" class="alert alert-success">
                {{ successMessage }}
              </div>
              <div v-if="errorMessage" class="alert alert-danger">
                {{ errorMessage }}
              </div>
              
              <form @submit.prevent="handleLogin">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    v-model="form.email"
                    :class="{ 'is-invalid': errors.email }"
                    required
                    :disabled="isLoading"
                  >
                  <div v-if="errors.email" class="invalid-feedback">
                    {{ errors.email[0] }}
                  </div>
                </div>
                
                <div class="mb-3">
                  <label for="password" class="form-label">Senha</label>
                  <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    v-model="form.password"
                    :class="{ 'is-invalid': errors.password }"
                    required
                    :disabled="isLoading"
                  >
                  <div v-if="errors.password" class="invalid-feedback">
                    {{ errors.password[0] }}
                  </div>
                </div>
                  
                <button 
                  type="submit" 
                  class="btn btn-send w-100"
                  :disabled="isLoading"
                >
                  <span v-if="!isLoading">Entrar</span>
                  <span v-else>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Autenticando...
                  </span>
                </button>
  
                <div class="mt-3 text-center">
                  <router-link to="/register">Não tem uma conta? Registre-se</router-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useAuthStore } from '@/stores/auth';
 
  export default {
    name: 'LoginPage',
    data() {
      return {
        form: {
          email: '',
          password: ''
        },
        errors: {},
        isLoading: false,
        successMessage: '',
        errorMessage: ''
      }
    },
    methods: {
      async handleLogin() {
        this.isLoading = true;
        this.successMessage = '';
        this.errorMessage = '';
        this.errors = {};
        
        try {
          const response = await axios.post('http://127.0.0.1:8000/api/login', this.form);

          const authStore = useAuthStore();
          authStore.setToken(response.data.access_token)
          authStore.setUser(response.data.user)
          this.$router.push('/dashboard');
          
        } catch (error) {
          console.error('Erro completo:', error);
          
          if (error.response) {
            if (error.response.status === 422) {
              this.errors = error.response.data.errors || {};
              this.errorMessage = 'Por favor, corrija os erros no formulário.';
            } else if (error.response.status === 401) {
              this.errorMessage = error.response.data.message || 'Credenciais inválidas.';
            } else {
              this.errorMessage = error.response.data.message || 'Ocorreu um erro durante o login.';
            }
          } else if (error.request) {
            this.errorMessage = 'Sem resposta do servidor. Verifique sua conexão.';
          } else {
            console.error('Erro na configuração:', error.message);
            this.errorMessage = 'Erro ao configurar a requisição.';
          }
        } finally {
          this.isLoading = false;
        }
      }
    }
  }
  </script>
  
  <style scoped>
  .invalid-feedback {
    display: block;
  }
  
  .card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  .card-header {
    padding: 1rem 1.5rem;
    background-color: #2c3e50;
  }

  .btn-send {
    background-color: #2c3e50;
  }

  </style>