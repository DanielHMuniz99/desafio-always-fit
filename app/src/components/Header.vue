<template>
    <nav class="navbar">
      <div class="container">
        <router-link to="/" class="navbar-brand">Dashboard</router-link>
        
        <div class="navbar-actions">
          <button @click="handleLogout" class="logout-button">
            <i class="fas fa-sign-out-alt"></i> Sair
          </button>
        </div>
      </div>
    </nav>
  </template>
  
  <script>
    import { useAuthStore } from '@/stores/auth';
    import { useRouter } from 'vue-router';
    
    export default {
      setup() {
        const router = useRouter();
    
        const handleLogout = async () => {
          const authStore = useAuthStore();
          try {
            await authStore.logout();
            router.push('/login');
          } catch (error) {
            console.error('Erro ao fazer logout:', error);
          }
        };
    
        return {
          handleLogout,
        };
      },
    };
  </script>  
  
  <style scoped>
  .navbar {
    background-color: #2c3e50;
    color: white;
    padding: 1rem 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .navbar-brand {
    color: white;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.2rem;
  }
  
  .logout-button {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .logout-button:hover {
    background-color: #c0392b;
  }
  
  .fas {
    font-size: 0.9rem;
  }
  </style>