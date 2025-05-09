<template>
    <footer class="site-footer">
      <div class="footer-container">
        <div class="footer-section">
          <h3 class="footer-title">ALWAYS FIT @</h3>
          <ul class="footer-links">
            <li><router-link to="/#">Saúde Longevidade e Autoestima</router-link></li>
          </ul>
        </div>
  
        <div class="footer-section">
          <h3 class="footer-title">POLÍTICA</h3>
          <ul class="footer-links">
            <li><router-link to="/#">Quem somos</router-link></li>
            <li><router-link to="/#">Política de segurança</router-link></li>
            <li><router-link to="/#">Política de privacidade</router-link></li>
            <li><router-link to="/#">Política de Entrega</router-link></li>
            <li><router-link to="/#">Política de Cookies</router-link></li>
            <li><router-link to="/#">Política de Devolução</router-link></li>
          </ul>
        </div>
 
      </div>
  
      <div class="footer-bottom">
        <p>&copy; {{ currentYear }} Always Fit.</p>
      </div>
    </footer>
  </template>
  
  <script>
  export default {
    name: 'AppFooter',
    data() {
      return {
        currentYear: new Date().getFullYear()
      }
    }
  }
  </script>