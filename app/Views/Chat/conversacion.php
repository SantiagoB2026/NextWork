<?= view('templates/header') ?>

<main class="np-page np-page--angosta">
    <a class="np-volver" href="<?= site_url('mensajes') ?>">&larr; Mis mensajes</a>

    <div class="np-chat">
        <div class="np-chat__cab">
            <span class="np-avatar"><?= esc(mb_strtoupper(mb_substr($otro['alias'], 0, 1))) ?></span>
            <strong>@<?= esc($otro['alias']) ?></strong>
            <span class="np-insignia np-insignia--chico"><?= esc(ucfirst($otro['tipo'])) ?></span>
        </div>

        <div class="np-chat__mensajes" id="chat-mensajes" aria-live="polite">
            <?php if (empty($mensajes)): ?>
                <p class="np-vacio" id="chat-vacio">Todavía no hay mensajes. ¡Escribe el primero!</p>
            <?php endif; ?>

            <?php foreach ($mensajes as $m): ?>
                <div class="np-msg <?= $m['mio'] ? 'np-msg--mio' : 'np-msg--otro' ?>" data-id="<?= (int) $m['id'] ?>">
                    <div class="np-msg__texto"><?= esc($m['texto']) ?></div>
                    <span class="np-msg__hora"><?= esc($m['hora']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <form id="chat-form" class="np-chat__form" autocomplete="off">
            <input type="text" id="chat-texto" class="np-form__input" maxlength="500"
                   placeholder="Escribe un mensaje…" required>
            <button type="submit" class="np-btn np-btn--verde">Enviar</button>
        </form>
    </div>
</main>

<script>
(function () {
    var caja      = document.getElementById('chat-mensajes');
    var form      = document.getElementById('chat-form');
    var campo     = document.getElementById('chat-texto');
    var vacio     = document.getElementById('chat-vacio');
    var urlEnviar = '<?= site_url('mensajes/' . (int) $otro['id_usuario'] . '/enviar') ?>';
    var urlNuevos = '<?= site_url('mensajes/' . (int) $otro['id_usuario'] . '/nuevos') ?>';
    var csrf      = { nombre: '<?= csrf_token() ?>', valor: '<?= csrf_hash() ?>' };
    var ultimoId  = <?= (int) $ultimoId ?>;
    var enviando  = false;

    function abajo() { caja.scrollTop = caja.scrollHeight; }

    function pintar(m) {
        if (caja.querySelector('[data-id="' + m.id + '"]')) { return; }   // evita duplicados
        if (vacio) { vacio.remove(); vacio = null; }

        var fila = document.createElement('div');
        fila.className = 'np-msg ' + (m.mio ? 'np-msg--mio' : 'np-msg--otro');
        fila.setAttribute('data-id', m.id);

        var texto = document.createElement('div');
        texto.className = 'np-msg__texto';
        texto.textContent = m.texto;            // textContent: el texto nunca se interpreta como HTML

        var hora = document.createElement('span');
        hora.className = 'np-msg__hora';
        hora.textContent = m.hora;

        fila.appendChild(texto);
        fila.appendChild(hora);
        caja.appendChild(fila);

        if (m.id > ultimoId) { ultimoId = m.id; }
    }

    // Cada 3 segundos pregunta si hay mensajes nuevos (solo si la pestaña está visible)
    function traer() {
        if (document.hidden) { return; }

        fetch(urlNuevos + '?desde=' + ultimoId, {
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.ok ? r.json() : null; })
        .then(function (d) {
            if (!d || !d.ok || !d.mensajes.length) { return; }
            var estabaAbajo = caja.scrollHeight - caja.scrollTop - caja.clientHeight < 80;
            d.mensajes.forEach(pintar);
            if (estabaAbajo) { abajo(); }
        })
        .catch(function () { /* sin conexión: se reintenta en el siguiente ciclo */ });
    }

    setInterval(traer, 3000);
    document.addEventListener('visibilitychange', function () { if (!document.hidden) { traer(); } });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var texto = campo.value.trim();
        if (!texto || enviando) { return; }
        enviando = true;

        var datos = new FormData();
        datos.append('texto', texto);
        datos.append(csrf.nombre, csrf.valor);

        fetch(urlEnviar, {
            method: 'POST',
            body: datos,
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d.csrf) { csrf.valor = d.csrf; }           // el token se renueva en cada envío
            if (d.ok) { pintar(d.mensaje); campo.value = ''; abajo(); }
            else { alert(d.error || 'No se pudo enviar el mensaje.'); }
        })
        .catch(function () { alert('No se pudo enviar el mensaje. Recarga la página e inténtalo de nuevo.'); })
        .then(function () { enviando = false; campo.focus(); });
    });

    abajo();
})();
</script>

<?= view('templates/footer') ?>
