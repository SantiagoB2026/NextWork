<footer class="main-footer">
  <div class="footer-container">
    
    <!-- SECCIÓN 1: Columnas superiores -->
    <div class="footer-top">
      <!-- Columna 1: Isotipos superior izquierdo -->
      <div class="footer-logo-symbol">
        <img src="../assets/img/Logo_Nextwork_Blanco.png" alt="Logo Nextwork">
      </div>

      <!-- Columna 2: Descubrir (en 2 subcolumnas) -->
      <div class="footer-col footer-col-discover">
        <h4>Descubrir</h4>
        <div class="discover-lists">
          <ul>
            <li><a href="#">Arte</a></li>
            <li><a href="#">Ciencia</a></li>
            <li><a href="#">Comida</a></li>
            <li><a href="#">Educación</a></li>
            <li><a href="#">Impacto social</a></li>
          </ul>
          <ul>
            <li><a href="#">Moda</a></li>
            <li><a href="#">Música</a></li>
            <li><a href="#">Salud</a></li>
            <li><a href="#">Tecnología</a></li>
            <li><a href="#">Videojuegos</a></li>
          </ul>
        </div>
      </div>

      <!-- Columna 3: Acerca de nosotros -->
      <div class="footer-col footer-col-about">
        <h4>Acerca de nosotros</h4>
        <ul>
          <li><a href="#">Acerca de nosotros</a></li>
          <li><a href="#">Confianza y<br>seguridad</a></li>
          <li><a href="#">Política de privacidad</a></li>
          <li><a href="#">Términos de uso</a></li>
          <li><a href="#">Recursos de marca</a></li>
        </ul>
      </div>
    </div>

    <!-- SECCIÓN 2: Logotipo gigante centrado -->
    <div class="footer-mega-brand">
      <img src="../assets/img/logoblancocompleto.png" class="logo-footer" alt="Logo Nextwork">
    </div>

    <!-- SECCIÓN 3: Redes sociales centradas -->
    <div class="footer-social">
      <!-- Facebook -->
      <a href="#" aria-label="Facebook">
        <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
          <path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z"/>
        </svg>
      </a>

      <!-- Instagram -->
      <a href="#" aria-label="Instagram">
        <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor">
          <path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3Z"/>
        </svg>
      </a>

      <!-- YouTube (Icono + texto) -->
      <a href="#" class="youtube-link" aria-label="YouTube">
        <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor">
          <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
        </svg>
        <span>YouTube</span>
      </a>
    </div>

  </div>

  <!-- SECCIÓN 4: Línea divisoria completa y Copyright centrado -->
  <div class="footer-bottom">
    <span class="copyright-text">Nextwork, PBC © 2026</span>
  </div>
</footer>

</body>
</html>
<style>
/* =========================================
   FOOTER NEXTWORK - ESTILOS COMPLETOS
   ========================================= */

.main-footer {
  background-color: #181818;
  color: #ffffff;
  padding-top: 48px;
  width: 100%;
  box-sizing: border-box;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

.main-footer *,
.main-footer *::before,
.main-footer *::after {
  box-sizing: border-box;
}

/* Contenedor principal apilado verticalmente */
.main-footer .footer-container {
  display: block !important;
  max-width: 1100px;
  width: 100%;
  margin: 0 auto;
  padding: 0 24px;
}

/* --- SECCIÓN 1: Columnas superiores --- */
.main-footer .footer-top {
  display: grid !important;
  grid-template-columns: 1fr 3fr 1fr;
  width: 100%;
  align-items: start;
  margin-bottom: 130px;
}

.main-footer .footer-logo-symbol img {
  height: 30px;
  width: auto;
  display: block;
}

.main-footer .footer-col h4 {
  font-size: 13px;
  font-weight: 600;
  color: #8e8e8e;
  margin: 0 0 14px 0;
}

.main-footer .footer-col ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.main-footer .footer-col li {
  margin-bottom: 10px;
  line-height: 1.3;
}

.main-footer .footer-col a {
  color: #e5e5e5;
  text-decoration: none;
  font-size: 13px;
  font-weight: 400;
  transition: color 0.2s ease;
}

.main-footer .footer-col a:hover {
  text-decoration: underline;
  color: #ffffff;
}

/* Subcolumnas dentro de "Descubrir" */
.main-footer .discover-lists {
  display: flex !important;
  gap: 48px;
}

/* Columna derecha ("Acerca de nosotros") */
.main-footer .footer-col-about {
  justify-self: end;
  white-space: nowrap;
}

/* --- SECCIÓN 2: Logo Gigante --- */
.main-footer .footer-mega-brand {
  display: flex !important;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin-bottom: 24px;
}

.main-footer .logo-footer {
  width: 100%;
  max-width: 680px;
  height: auto;
  display: block;
}

/* --- SECCIÓN 3: Redes Sociales --- */
.main-footer .footer-social {
  display: flex !important;
  justify-content: center;
  align-items: center;
  width: 100%;
  gap: 16px;
  margin-bottom: 48px;
}

.main-footer .footer-social a {
  color: #ffffff;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  transition: opacity 0.2s ease;
}

.main-footer .footer-social a:hover {
  opacity: 0.75;
}

.main-footer .youtube-link {
  gap: 4px;
  font-weight: 700;
  font-size: 20px;
  letter-spacing: -0.04em;
}

/* --- SECCIÓN 4: Línea inferior y Copyright --- */
.main-footer .footer-bottom {
  display: block !important;
  width: 100%;
  border-top: 1px solid #3c3c3c !important;
  padding: 24px;
  text-align: center;
}

.main-footer .copyright-text {
  font-size: 11px;
  color: #b5b5b5;
}

/* --- RESPONSIVE (Móviles y Tablets) --- */
@media (max-width: 768px) {
  .main-footer .footer-top {
    grid-template-columns: 1fr;
    gap: 36px;
    margin-bottom: 70px;
  }

  .main-footer .footer-col-about {
    justify-self: start;
    white-space: normal;
  }

  .main-footer .discover-lists {
    gap: 32px;
  }

  .main-footer .logo-footer {
    max-width: 90%;
  }
}

</style>