import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Auth/Login.vue';
import Register from '../components/Auth/Register.vue';
import Dashboard from '../components/Dashboard.vue';
import Trainings from '../components/Trainings.vue';
import NutritionPlans from '../components/NutritionPlans.vue';
import { useAuthStore } from '@/stores/auth';

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true }},
  { path: '/', component: Dashboard, meta: { requiresAuth: true }},
  { path: '/trainings', component: Trainings, meta: { requiresAuth: true }},
  { path: '/plans', component: NutritionPlans, meta: { requiresAuth: true }},
  {
    path: '/:pathMatch(.*)*',
    redirect: '/dashboard'
  }  
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

    console.log(authStore.isAuthenticated)

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!authStore.isAuthenticated) {
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      });
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;