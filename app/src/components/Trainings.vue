<template>
    <div class="trainings-container">
      <h1 class="page-title">Meus Treinos</h1>
      
      <!-- Mostrar métricas agregadas -->
      <div class="metrics-container">
        <div class="metric-card">
          <h3>Total de Treinos</h3>
          <p>{{ meta.total_trainings }}</p>
        </div>
        <div class="metric-card">
          <h3>Dias Completados</h3>
          <p>{{ meta.total_completed_days }}</p>
        </div>
        <div class="metric-card">
          <h3>Progresso Médio</h3>
          <p>{{ meta.average_progress }}%</p>
        </div>
      </div>
      
      <div class="trainings-grid">
        <div 
          v-for="(training, index) in trainings" 
          :key="index" 
          class="training-card"
        >
          <div class="training-image-placeholder">
            <img src="/images/image.png" alt="Logo">
            <span class="level-badge" :class="training.level">{{ training.level }}</span>
          </div>
          
          <div class="training-content">
            <h3 class="training-name">{{ training.title }}</h3>
            <p class="training-description">{{ training.description }}</p>
            
            <div class="training-meta">
              <div class="progress-container">
                <span class="progress-text">
                  Progresso: 
                  <span class="progress-days">{{ training.completed_days }}</span> / 
                  30 dias
                </span>
                <div class="progress-bar">
                  <div 
                    class="progress-completed"
                    :style="{ width: training.progress_percentage + '%' }"
                  ></div>
                </div>
              </div>
              
              <div class="last-completed">
                Último treino: {{ formatDate(training.last_completed) }}
              </div>
            </div>
            
            <div class="training-actions">
              <label class="completed-checkbox">
                <input 
                  type="checkbox" 
                  v-model="training.completed_today"
                >
                <span>Realizado hoje?</span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from "axios";
  import { useAuthStore } from '@/stores/auth';
  import { useRouter } from 'vue-router';
  
  const authStore = useAuthStore();
  const router = useRouter();
  
  const trainings = ref([]);
  const meta = ref({
    total_trainings: 0,
    total_completed_days: 0,
    average_progress: 0,
    recent_completions: 0
  });
  
  const formatDate = (dateString) => {
    if (!dateString) return 'Nunca';
    const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
    return new Date(dateString).toLocaleDateString('pt-BR', options);
  };
  
  const fetchWorkouts = async () => {
    try {
      const token = authStore.token || localStorage.getItem('authToken');
      
      const response = await axios.get('http://127.0.0.1:8000/api/progresso', {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      });
      
      trainings.value = response.data.data;
      meta.value = response.data.meta;
      
    } catch (error) {
      console.error('Erro ao buscar treinos:', error);
      if (error.response?.status === 401) {
        alert('Sessão expirada. Faça login novamente.');
        authStore.logout();
        router.push('/login');
      }
    }
  };
  
  onMounted(fetchWorkouts);
  </script>
  
  <style scoped>
  .trainings-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .page-title {
    color: #2c3e50;
    text-align: center;
    margin-bottom: 30px;
  }
  
  .metrics-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
  }
  
  .metric-card {
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    text-align: center;
  }
  
  .metric-card h3 {
    color: #7f8c8d;
    font-size: 1rem;
    margin-bottom: 5px;
  }
  
  .metric-card p {
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0;
  }
  
  .trainings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
  }
  
  .training-card {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
  }
  
  .training-card:hover {
    transform: translateY(-5px);
  }
  
  .training-image-placeholder {
    height: 150px;
    background-color: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #7f8c8d;
    position: relative;
  }
  
  .level-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: bold;
    color: white;
  }
  
  .level-badge.beginner {
    background-color: #3498db;
  }
  
  .level-badge.intermediate {
    background-color: #2ecc71;
  }
  
  .level-badge.advanced {
    background-color: #e74c3c;
  }
  
  .training-content {
    padding: 15px;
  }
  
  .training-name {
    color: #2c3e50;
    margin-bottom: 10px;
  }
  
  .training-description {
    color: #7f8c8d;
    font-size: 0.9rem;
    margin-bottom: 15px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .training-meta {
    margin-bottom: 15px;
  }
  
  .progress-container {
    margin-bottom: 10px;
  }
  
  .progress-text {
    display: block;
    margin-bottom: 5px;
    color: #34495e;
    font-size: 0.9rem;
  }
  
  .progress-days {
    font-weight: bold;
    color: #27ae60;
  }
  
  .progress-bar {
    height: 8px;
    background-color: #ecf0f1;
    border-radius: 4px;
    overflow: hidden;
  }
  
  .progress-completed {
    height: 100%;
    background-color: #27ae60;
    border-radius: 4px;
  }
  
  .last-completed {
    font-size: 0.8rem;
    color: #95a5a6;
    margin-top: 8px;
  }
  
  .training-actions {
    padding-top: 10px;
    border-top: 1px solid #eee;
  }
  
  .completed-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    color: #34495e;
  }
  
  .completed-checkbox input {
    cursor: pointer;
  }
  
  @media (max-width: 768px) {
    .trainings-grid {
      grid-template-columns: 1fr;
    }
  }
  </style>