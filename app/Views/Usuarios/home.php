<?= view('templates/header') ?>

 <main class="main-content">
        <div class="welcome-container">
            <?php if (!session()->get('isLoggedIn')): ?>
            <h1 class="title-welcome">BIENVENIDO A <span class="brand-name">NEXTWORK</span></h1>
            <div class="button-group">
                <a href="<?= site_url('register') ?>" class="btn btn-dark">Crear cuenta</a>
                <a href="<?= site_url('login') ?>" class="btn btn-green">Ya tengo cuenta</a>
            <?php endif; ?>
            <div class="user-badge">
        <?php if (session()->get('tipo') === 'inversionista'): ?>
            <h1>Inversionista</h1>
        <?php elseif (session()->get('tipo') === 'desarrollador'): ?>
            <h1>Desarrollador</h1>
        <?php endif; ?>
    </div>
            </div>
        </div>
    </main>
<?= view('templates/footer') ?>