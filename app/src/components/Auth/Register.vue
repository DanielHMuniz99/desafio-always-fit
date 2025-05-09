<template>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-white">
              <h3 class="mb-0">Registro</h3>
            </div>
            <div class="card-body">
              <div v-if="successMessage" class="alert alert-success">
                {{ successMessage }}
              </div>
              <div v-if="errorMessage" class="alert alert-danger">
                {{ errorMessage }}
              </div>
              
              <form @submit.prevent="handleSubmit">
                <div class="mb-3">
                  <label for="name" class="form-label">Nome</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    v-model="form.name"
                    :class="{ 'is-invalid': errors.name }"
                    required
                    :disabled="isLoading"
                  >
                  <div v-if="errors.name" class="invalid-feedback">
                    {{ errors.name[0] }}
                  </div>
                </div>
                
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
  
                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                  <input 
                    type="password" 
                    class="form-control" 
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :class="{ 'is-invalid': errors.password_confirmation }"
                    required
                    :disabled="isLoading"
                  >
                  <div v-if="errors.password_confirmation" class="invalid-feedback">
                    {{ errors.password_confirmation[0] }}
                  </div>
                </div>
                
                <button 
                  type="submit" 
                  class="btn btn-send w-100"
                  :disabled="isLoading"
                >
                  <span v-if="!isLoading">Registrar</span>
                  <span v-else>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Processando...
                  </span>
                </button>
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
  import { useRouter } from 'vue-router';

  export default {
    name: 'Register',
    setup() {
      const authStore = useAuthStore();
      const router = useRouter();
      return { authStore, router };
    },
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: ''
        },
        errors: {},
        isLoading: false,
        successMessage: '',
        errorMessage: ''
      }
    },
    methods: {
      async handleSubmit() {
        this.isLoading = true;
        this.successMessage = '';
        this.errorMessage = '';
        this.errors = {};
        
        try {
          const registerResponse = await axios.post(
            'http://127.0.0.1:8000/api/register', 
            this.form
          );

          const loginResponse = await axios.post(
            'http://127.0.0.1:8000/api/login', 
            {
              email: this.form.email,
              password: this.form.password
            }
          );

          this.authStore.setToken(loginResponse.data.access_token);
          this.authStore.setUser(loginResponse.data.user);

          this.router.push('/dashboard');

        } catch (error) {
          if (error.response) {
            if (error.response.status === 422 && error.response.data.errors) {
              this.errors = error.response.data.errors;
              this.errorMessage = 'Por favor, corrija os erros no formulário.';
            } else {
              this.errorMessage = error.response.data.message || 'Ocorreu um erro no registro.';
            }
          } else {
            this.errorMessage = 'Erro de conexão. Verifique sua internet e tente novamente.';
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
  .card-header {
    padding: 1rem 1.5rem;
    background-color: #2c3e50;
  }

  .btn-send {
    background-color: #2c3e50;
  }
  </style>