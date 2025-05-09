<template>
    <div class="nutrition-plans-container">
      <h1 class="page-title">Planos Nutricionais</h1>
      
      <!-- Mensagem de erro -->
      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>
      
      <!-- Loading state -->
      <div v-if="isLoading" class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Carregando...</span>
        </div>
      </div>
      
      <!-- Lista de planos -->
      <div v-else class="plans-grid">
        <div 
          v-for="plan in plans" 
          :key="plan.id" 
          class="plan-card"
        >
          <div class="plan-header">
            <h3>{{ plan.title }}</h3>
            <span class="created-at">
              Criado em: {{ formatDate(plan.created_at) }}
            </span>
          </div>
          
          <div class="plan-details">
            <h4>Detalhes:</h4>
            <ul>
              <li 
                v-for="(meal, index) in parseMeals(plan.details)" 
                :key="index"
              >
                {{ meal }}
              </li>
            </ul>
          </div>        
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  import { useAuthStore } from '@/stores/auth';
  
  export default {
    setup() {
      const router = useRouter();
      const authStore = useAuthStore();
  
      const plans = ref([]);
      const isLoading = ref(true);
      const isSelecting = ref(false);
      const error = ref(null);
  
      const fetchPlans = async () => {
        try {
          const token = authStore.token || localStorage.getItem('authToken');
  
          if (!token) {
            throw new Error('Não autenticado');
          }
  
          const response = await axios.get('http://127.0.0.1:8000/api/planos', {
            headers: {
              'Authorization': `Bearer ${token}`,
              'Accept': 'application/json'
            }
          });
  
          plans.value = response.data;
          error.value = null;
        } catch (err) {
          if (err.response?.status === 401) {
            error.value = 'Sessão expirada. Redirecionando para login...';
            setTimeout(() => {
              authStore.logout();
              router.push('/login');
            }, 2000);
          } else {
            error.value = 'Erro ao carregar planos nutricionais.';
            console.error('Erro:', err);
          }
        } finally {
          isLoading.value = false;
        }
      };
  
      const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString('pt-BR');
      };
  
      const parseMeals = (details) => {
        return details.split(' | ').map(meal => meal.trim());
      };
  
      onMounted(() => {
        fetchPlans();
      });
  
      return {
        plans,
        isLoading,
        isSelecting,
        error,
        fetchPlans,
        formatDate,
        parseMeals
      };
    }
  };
  </script>  
  
  <style scoped>
  .nutrition-plans-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .page-title {
    color: #2c3e50;
    text-align: center;
    margin-bottom: 30px;
  }
  
  .plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 25px;
  }
  
  .plan-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
  }
  
  .plan-card:hover {
    transform: translateY(-5px);
  }
  
  .plan-header {
    padding: 15px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #eee;
  }
  
  .plan-header h3 {
    color: #2c3e50;
    margin: 0;
  }
  
  .created-at {
    font-size: 0.8rem;
    color: #7f8c8d;
  }
  
  .plan-details {
    padding: 15px;
    flex-grow: 1;
  }
  
  .plan-details h4 {
    color: #34495e;
    margin-bottom: 10px;
  }
  
  .plan-details ul {
    padding-left: 20px;
    margin: 0;
  }
  
  .plan-details li {
    margin-bottom: 8px;
    color: #2c3e50;
  }
  
  .plan-actions {
    padding: 15px;
    border-top: 1px solid #eee;
    text-align: center;
  }
  
  .btn-select {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .btn-select:hover {
    background-color: #2980b9;
  }
  
  .btn-select:disabled {
    background-color: #95a5a6;
    cursor: not-allowed;
  }
  
  .loading-spinner {
    display: flex;
    justify-content: center;
    padding: 40px;
  }
  
  .alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
  }
  
  @media (max-width: 768px) {
    .plans-grid {
      grid-template-columns: 1fr;
    }
  }
  </style>