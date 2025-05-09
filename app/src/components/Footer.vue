<template>
    <footer class="site-footer">
      <div class="footer-container">
        <div class="footer-section">
          <h3 class="footer-title">ALWAYS FIT @</h3>
          <ul class="footer-links">
            <li><router-link to="/#">Saúde Longevidade e Autoestima</router-link></li>
          </ul>
          <h3 class="footer-title">Contato</h3>
          <ul class="footer-links">
            <li><router-link to="/#">0800 454 5103</router-link></li>
            <li><router-link to="/#">1799126-6117 (Whatsapp)</router-link></li>
          </ul>
          <h3 class="footer-title">Endereço</h3>
          <ul class="footer-links">
            <li><router-link to="/#">Rodovia Fernão Dias, 937</router-link></li>
            <li><router-link to="/#">Complemento: BW Diase -</router-link></li>
            <li><router-link to="/#">DocaLog G500 Modulo 5</router-link></li>
            <li><router-link to="/#">CEP: 37646-202</router-link></li>
            <li><router-link to="/#">Extrema - MG</router-link></li>
            <li><router-link to="/#">30.417.094/0001.60</router-link></li>
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