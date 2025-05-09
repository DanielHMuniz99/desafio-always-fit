<template>
  <div class="dashboard">
    <h1 class="dashboard-title">Dashboard</h1>
    <div class="cards-container">
      <div class="card">
        <div class="card-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-content">
          <h3 class="card-title">Treinos</h3>
          <p class="card-description">Treinos concluídos esta semana</p>
          <router-link to="/trainings" class="view-more-link">Ver todos os treinos →</router-link>
        </div>
      </div>

      <div class="card">
        <div class="card-icon">
          <i class="fas fa-tasks"></i>
        </div>
        <div class="card-content">
          <h3 class="card-title">Plano nutricional</h3>
          <p class="card-description">Exercícios disponíveis</p>
          <router-link to="/plans" class="view-more-link">Ver todos os planos →</router-link>
        </div>
      </div>
    </div>
  </div>
</template>