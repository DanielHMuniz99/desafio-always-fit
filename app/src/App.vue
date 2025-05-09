<script setup>
import { useRoute } from 'vue-router';
import Footer from './components/Footer.vue';
import Header from './components/Header.vue';
import { computed } from 'vue';

const route = useRoute();
const showPage = computed(() => !['/login', '/register'].includes(route.path));

</script>

<template>
  <div class="app-layout">
    <Header v-if="showPage"/>
    
    <main class="main-content">
      <router-view />
    </main>
    
    <Footer/>
  </div>
</template>

<style>
.app-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding: 20px;
}
</style>