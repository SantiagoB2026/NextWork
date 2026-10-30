<?= view('templates/header') ?>
<!-- CONTENEDOR PRINCIPAL: Insertar en el espacio en blanco de tu maqueta -->
<div class="search-container">
    <?php if (!empty($keyword)): ?>
        <div class="search-title">Resultados para: "<span><?= esc($keyword) ?></span>"</div>


        <!-- Sistema de pestañas estilo TikTok adaptado a Nextwork -->
        <div class="tabs-nav">
            <button class="tab-button active" onclick="switchTab(event, 'usuarios-tab')">
                Usuarios (<?= count($usuarios ?? []) ?>)
            </button>
            <button class="tab-button" onclick="switchTab(event, 'proyectos-tab')">
                Proyectos (<?= count($proyectos ?? []) ?>)
            </button>
        </div>


        <!-- APARTADO USUARIOS -->
        <div id="usuarios-tab" class="tab-content active">
            <?php if (!empty($usuarios) && is_array($usuarios)): ?>
                <ul class="list-container">
                    <?php foreach ($usuarios as $user): ?>
                        <li class="user-item">
                            <!-- Avatar circular con la inicial del alias -->
                            <div class="user-avatar">
                                <?= mb_substr(esc($user['alias']), 0, 1) ?>
                            </div>
                            <div class="user-info">
                                <span class="user-alias">@<?= esc($user['alias']) ?></span>
                                <span class="user-fullname"><?= esc($user['nombre'] ?? '') ?> <?= esc($user['apellido'] ?? '') ?></span>
                            </div>
                            <!-- Botón de acción opcional integrado al estilo de la plataforma -->
                            <button class="btn-view-profile">Ver perfil</button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="empty-message">No se encontraron usuarios con ese criterio.</p>
            <?php endif; ?>
        </div>


        <!-- APARTADO PROYECTOS -->
        <div id="proyectos-tab" class="tab-content">
            <?php if (!empty($proyectos) && is_array($proyectos)): ?>
                <ul class="list-container">
                    <?php foreach ($proyectos as $proy): ?>
                        <li class="project-item">
                            <h4 class="project-title"><?= esc($proy['titulo'] ?? 'Sin título') ?></h4>
                            <p class="project-desc"><?= nl2br(esc($proy['descripcion'] ?? 'Sin descripción')) ?></p>
                            <span class="project-tag">#<?= esc($proy['etiqueta'] ?? 'Ninguna') ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="empty-message">No se encontraron proyectos con ese criterio.</p>
            <?php endif; ?>
        </div>


    <?php else: ?>
        <p class="empty-message">Por favor, ingresá un término de búsqueda en la barra superior.</p>
    <?php endif; ?>
</div>


<!-- ESTILOS CSS ADAPTADOS A NEXTWORK: Agregalos a tu archivo .css o bloque <style> -->
<style>
    :root {
        --nw-green: #00b67a; /* El verde característico de Nextwork */
        --nw-bg: #ffffff;
        --nw-text-main: #111111;
        --nw-text-sub: #666666;
        --nw-border: #e8e8e8;
    }


    .search-container {
        width: 100%;
        max-width: 700px;
        margin: 40px auto;
        padding: 0 20px;
        box-sizing: border-box;
        font-family: sans-serif; /* Cambiala por la tipografía oficial de tu proyecto */
    }


    .search-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 24px;
        color: var(--nw-text-main);
    }
    
    .search-title span {
        color: var(--nw-green);
    }


    /* Pestañas de Navegación */
    .tabs-nav {
        display: flex;
        border-bottom: 2px solid var(--nw-border);
        margin-bottom: 20px;
    }


    .tab-button {
        flex: 1;
        background: none;
        border: none;
        padding: 14px 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--nw-text-sub);
        cursor: pointer;
        transition: all 0.2s ease;
    }


    .tab-button:hover {
        color: var(--nw-text-main);
    }


    .tab-button.active {
        color: var(--nw-green);
        position: relative;
    }


    /* Línea indicadora inferior con el color de Nextwork */
    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: var(--nw-green);
    }


    .tab-content {
        display: none;
    }


    .tab-content.active {
        display: block;
    }


    .list-container {
        list-style: none;
        padding: 0;
        margin: 0;
    }


    /* Estilo de la Lista de Usuarios */
    .user-item {
        display: flex;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid var(--nw-border);
    }


    .user-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background-color: #f0f0f0;
        margin-right: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: var(--nw-green);
        text-transform: uppercase;
        border: 1px solid var(--nw-border);
    }


    .user-info {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }


    .user-alias {
        font-weight: 700;
        font-size: 15px;
        color: var(--nw-text-main);
    }


    .user-fullname {
        font-size: 13px;
        color: var(--nw-text-sub);
        margin-top: 2px;
    }


    .btn-view-profile {
        background-color: transparent;
        border: 1px solid var(--nw-green);
        color: var(--nw-green);
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }


    .btn-view-profile:hover {
        background-color: var(--nw-green);
        color: white;
    }


    /* Estilo de Tarjetas de Proyectos */
    .project-item {
        background-color: var(--nw-bg);
        border: 1px solid var(--nw-border);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 14px;
        transition: transform 0.2s, box-shadow 0.2s;
    }


    .project-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }


    .project-title {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 6px 0;
        color: var(--nw-text-main);
    }


    .project-desc {
        font-size: 14px;
        color: var(--nw-text-sub);
        margin: 0 0 12px 0;
        line-height: 1.4;
    }


    .project-tag {
        display: inline-block;
        background-color: #f5f5f5;
        color: var(--nw-text-main);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }


    .empty-message {
        text-align: center;
        color: var(--nw-text-sub);
        margin-top: 40px;
        font-size: 15px;
    }
</style>


<!-- LÓGICA JAVASCRIPT: Colocala antes del cierre de tu etiqueta </body> -->
<script>
    function switchTab(event, tabId) {
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => content.classList.remove('active'));


        const buttons = document.querySelectorAll('.tab-button');
        buttons.forEach(button => button.classList.remove('active'));


        document.getElementById(tabId).classList.add('active');
        event.currentTarget.classList.add('active');
    }
</script>