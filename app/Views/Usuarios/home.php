<?= view('templates/header') ?>

 <main class="main-content">
        <div class="welcome-container">
            <h1 class="title-welcome">BIENVENIDO A <span class="brand-name">NEXTWORK</span></h1>
            
            <div class="button-group">
                <a href="<?= site_url('login') ?>" class="btn btn-dark">Crear cuenta</a>
                <a href="<?= site_url('register') ?>" class="btn btn-green">Ya tengo cuenta</a>
            </div>
        </div>
    </main>
<?= view('templates/footer') ?>