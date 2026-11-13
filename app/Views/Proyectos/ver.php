<?= view('templates/header') ?>
<?php
helper('proyectos');

$idProyecto    = (int) $proyecto['id_proyecto'];
$falta         = max(0, (float) $proyecto['dinero_conseguir'] - (float) $proyecto['recaudado']);
$idCreador     = (int) ($proyecto['id_usuario'] ?? 0);
// Todo el equipo son desarrolladores: pueden escribirles inversionistas y otros desarrolladores
$puedeEscribir = \App\Models\MensajeModel::puedenChatear($tipo, 'desarrollador');
$puedeComentar = in_array($tipo, ['desarrollador', 'inversionista'], true);
$maxImagenes   = \App\Libraries\ImagenesProyecto::MAX_POR_PROYECTO;
?>

<main class="np-page">
    <?php if (session()->getFlashdata('exito')): ?>
        <div class="np-flash np-flash--ok"><?= esc(session()->getFlashdata('exito')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="np-flash np-flash--error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <a class="np-volver" href="<?= site_url('/') ?>">&larr; Volver al inicio</a>

    <?php if ($financiado): ?>
        <div class="np-flash np-flash--meta">
            <?php if ($esEquipo || $tipo === 'admin'): ?>
                <strong>¡Meta alcanzada!</strong> Este proyecto ya no es visible para el público y no recibe más donaciones.
            <?php else: ?>
                <strong>¡Este proyecto alcanzó su meta!</strong> Gracias por tu aporte.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="np-detalle">
        <section class="np-detalle__main">
            <?php if ($tipo === 'inversionista'): ?>
                <span class="np-insignia">Vista de inversionista</span>
            <?php elseif ($esDueno): ?>
                <span class="np-insignia">Tu proyecto</span>
            <?php elseif ($esColaborador): ?>
                <span class="np-insignia">Eres parte del equipo</span>
            <?php endif; ?>

            <h1 class="np-detalle__titulo"><?= esc($proyecto['titulo']) ?></h1>
            <p class="np-card__autor">
                por <strong><?= esc($proyecto['autor']) ?></strong>
                · publicado el <?= esc(date('d/m/Y', strtotime($proyecto['fecha_publicacion']))) ?>
            </p>

            <?php if (! empty($proyecto['etiquetas'])): ?>
                <div class="np-tags">
                    <?php foreach ($proyecto['etiquetas'] as $et): ?>
                        <a class="np-tag" href="<?= site_url('etiqueta/' . $et['slug']) ?>">#<?= esc($et['nombre']) ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Galería de imágenes -->
            <?php if (! empty($imagenes)): ?>
                <div class="np-galeria">
                    <img id="galeria-principal" class="np-galeria__principal"
                         src="<?= base_url('uploads/proyectos/' . $imagenes[0]['archivo']) ?>" alt="<?= esc($proyecto['titulo']) ?>">
                    <?php if (count($imagenes) > 1): ?>
                        <div class="np-galeria__minis">
                            <?php foreach ($imagenes as $img): ?>
                                <img class="np-galeria__mini" src="<?= base_url('uploads/proyectos/' . $img['archivo']) ?>"
                                     alt="Imagen del proyecto" loading="lazy">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <script>
                    document.querySelectorAll('.np-galeria__mini').forEach(function (mini) {
                        mini.addEventListener('click', function () {
                            document.getElementById('galeria-principal').src = this.src;
                        });
                    });
                </script>
            <?php endif; ?>

            <p class="np-detalle__desc"><?= nl2br(esc($proyecto['descripcion'])) ?></p>

            <!-- Equipo del proyecto -->
            <h2 class="np-subtitulo" style="margin-top: 28px;">Equipo</h2>
            <ul class="np-equipo">
                <li>
                    <span class="np-avatar"><?= esc(mb_strtoupper(mb_substr($proyecto['autor'], 0, 1))) ?></span>
                    <span class="np-equipo__nombre">@<?= esc($proyecto['autor']) ?> <small>Creador</small></span>
                    <?php if ($puedeEscribir && $idCreador > 0 && $idCreador !== $yo): ?>
                        <a class="np-btn np-btn--borde" href="<?= site_url('mensajes/' . $idCreador) ?>">Escribir</a>
                    <?php endif; ?>
                </li>
                <?php foreach ($equipo as $miembro): ?>
                    <li>
                        <span class="np-avatar"><?= esc(mb_strtoupper(mb_substr($miembro['alias'], 0, 1))) ?></span>
                        <span class="np-equipo__nombre">@<?= esc($miembro['alias']) ?> <small>Colaborador</small></span>
                        <?php if ($puedeEscribir && (int) $miembro['id_usuario'] !== $yo): ?>
                            <a class="np-btn np-btn--borde" href="<?= site_url('mensajes/' . (int) $miembro['id_usuario']) ?>">Escribir</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php if ($esDueno): ?>
                <form action="<?= site_url('desarrollador/proyectos/' . $idProyecto . '/invitar') ?>" method="POST" class="np-invitar">
                    <?= csrf_field() ?>
                    <input type="text" name="alias" class="np-form__input" maxlength="30" required
                           placeholder="Alias del desarrollador a invitar">
                    <button type="submit" class="np-btn np-btn--verde">Invitar al equipo</button>
                </form>
                <?php if (! empty($invitados)): ?>
                    <p class="np-nota">
                        Invitaciones pendientes:
                        <?php foreach ($invitados as $i => $inv): ?>
                            <?= $i > 0 ? ', ' : '' ?>@<?= esc($inv['alias']) ?>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Administrar imágenes (solo el equipo) -->
            <?php if ($esEquipo): ?>
                <h2 class="np-subtitulo" style="margin-top: 28px;">Imágenes del proyecto</h2>

                <?php if (! empty($imagenes)): ?>
                    <div class="np-imagenes-admin">
                        <?php foreach ($imagenes as $i => $img): ?>
                            <div class="np-imagen-item">
                                <img src="<?= base_url('uploads/proyectos/' . $img['archivo']) ?>" alt="Imagen del proyecto" loading="lazy">
                                <?php if ($i === 0): ?><span class="np-chip-portada">Portada</span><?php endif; ?>
                                <form action="<?= site_url('desarrollador/imagenes/' . (int) $img['id_imagen'] . '/eliminar') ?>" method="POST"
                                      onsubmit="return confirm('¿Eliminar esta imagen?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="np-link-peligro">Eliminar</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (count($imagenes) < $maxImagenes): ?>
                    <form action="<?= site_url('desarrollador/proyectos/' . $idProyecto . '/imagenes') ?>" method="POST"
                          enctype="multipart/form-data" class="np-subir">
                        <?= csrf_field() ?>
                        <input type="file" name="imagenes[]" accept="image/jpeg,image/png,image/webp" multiple required>
                        <button type="submit" class="np-btn np-btn--verde">Subir imágenes</button>
                    </form>
                    <p class="np-nota">Hasta <?= $maxImagenes ?> imágenes por proyecto, de 2 MB cada una (JPG, PNG o WebP). La primera es la portada.</p>
                <?php else: ?>
                    <p class="np-nota">Llegaste al máximo de <?= $maxImagenes ?> imágenes. Elimina alguna para subir otra.</p>
                <?php endif; ?>
            <?php endif; ?>
        </section>

        <aside class="np-panel">
            <?= view('Proyectos/_barra', ['proy' => $proyecto]) ?>

            <ul class="np-stats">
                <li><strong><?= (int) $proyecto['donantes'] ?></strong> <?= ((int) $proyecto['donantes'] === 1) ? 'inversionista' : 'inversionistas' ?></li>
                <li><strong><?= (int) $proyecto['total_donaciones'] ?></strong> <?= ((int) $proyecto['total_donaciones'] === 1) ? 'aporte' : 'aportes' ?></li>
                <li>
                    <?php if ($falta > 0): ?>
                        Faltan <strong><?= dinero($falta) ?></strong>
                    <?php else: ?>
                        <strong>¡Meta alcanzada!</strong>
                    <?php endif; ?>
                </li>
            </ul>

            <!-- Calificación -->
            <div id="calificacion" class="np-rating">
                <?= view('Proyectos/_estrellas', ['proy' => $proyecto]) ?>

                <?php if ($tipo === 'inversionista'): ?>
                    <form action="<?= site_url('proyecto/' . $idProyecto . '/calificar') ?>" method="POST" class="np-rating-form">
                        <?= csrf_field() ?>
                        <p class="np-nota" style="margin: 8px 0 4px;"><?= $miCalificacion > 0 ? 'Tu calificación (puedes cambiarla):' : 'Califica este proyecto:' ?></p>
                        <div class="np-rating-input">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" id="estrella<?= $i ?>" name="puntaje" value="<?= $i ?>"<?= $miCalificacion === $i ? ' checked' : '' ?> required>
                                <label for="estrella<?= $i ?>" title="<?= $i ?> <?= $i === 1 ? 'estrella' : 'estrellas' ?>">★</label>
                            <?php endfor; ?>
                        </div>
                        <button type="submit" class="np-btn np-btn--borde">Guardar calificación</button>
                    </form>
                <?php endif; ?>
            </div>

            <?php if ($tipo === 'inversionista'): ?>
                <?php if ($miAporte > 0): ?>
                    <p class="np-miaporte">Tu aporte hasta ahora: <strong><?= dinero($miAporte) ?></strong></p>
                <?php endif; ?>
                <?php if (! $financiado): ?>
                    <a class="np-btn np-btn--verde np-btn--block" href="<?= site_url('inversionista/proyectos/' . $idProyecto . '/donar') ?>">
                        Donar a este proyecto
                    </a>
                <?php else: ?>
                    <p class="np-nota">Este proyecto ya alcanzó su meta y no recibe más donaciones.</p>
                <?php endif; ?>
                <?php if ($idCreador > 0): ?>
                    <a class="np-btn np-btn--borde np-btn--block" href="<?= site_url('mensajes/' . $idCreador) ?>">
                        Escribir al desarrollador
                    </a>
                <?php endif; ?>
            <?php elseif ($esEquipo): ?>
                <p class="np-nota">Así ven los inversionistas este proyecto. La barra se llena con cada donación.</p>
            <?php elseif ($tipo === null): ?>
                <a class="np-btn np-btn--verde np-btn--block" href="<?= site_url('login') ?>">Inicia sesión para donar</a>
                <p class="np-nota">Solo las cuentas de inversionista pueden donar.</p>
            <?php else: ?>
                <p class="np-nota">Solo las cuentas de inversionista pueden donar a los proyectos.</p>
            <?php endif; ?>
        </aside>
    </div>

    <?php if ($esEquipo): ?>
        <section class="np-panel np-panel--ancho">
            <h2 class="np-subtitulo">Últimos aportes</h2>
            <?php if (! empty($recientes)): ?>
                <table class="np-tabla">
                    <thead><tr><th>Inversionista</th><th>Monto</th><th>Fecha</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach ($recientes as $r): ?>
                            <tr>
                                <td><?= esc($r['alias'] ?? 'Cuenta eliminada') ?></td>
                                <td><?= dinero($r['monto']) ?></td>
                                <td><?= esc(date('d/m/Y H:i', strtotime($r['created_at']))) ?></td>
                                <td>
                                    <?php if (! empty($r['id_usuario'])): ?>
                                        <a href="<?= site_url('mensajes/' . (int) $r['id_usuario']) ?>">Escribir</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="np-vacio">Todavía no hay aportes en este proyecto.</p>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <!-- Comentarios -->
    <section id="comentarios" class="np-panel np-panel--ancho">
        <h2 class="np-subtitulo">Comentarios (<?= count($comentarios) ?>)</h2>

        <?php if ($puedeComentar): ?>
            <form action="<?= site_url('proyecto/' . $idProyecto . '/comentar') ?>" method="POST" class="np-comentar">
                <?= csrf_field() ?>
                <textarea name="texto" class="np-form__input" maxlength="500" rows="3" required
                          placeholder="Escribe un comentario sobre este proyecto…"></textarea>
                <button type="submit" class="np-btn np-btn--verde">Comentar</button>
            </form>
        <?php elseif ($tipo === null): ?>
            <p class="np-nota"><a href="<?= site_url('login') ?>">Inicia sesión</a> para comentar.</p>
        <?php endif; ?>

        <?php if (! empty($comentarios)): ?>
            <ul class="np-comentarios">
                <?php foreach ($comentarios as $c): ?>
                    <li class="np-comentario">
                        <div class="np-comentario__cab">
                            <strong>@<?= esc($c['alias'] ?? 'cuenta eliminada') ?></strong>
                            <small>
                                <?php if ((int) $c['id_usuario'] === $idCreador): ?>Creador
                                <?php elseif (! empty($c['tipo'])): ?><?= esc(ucfirst($c['tipo'])) ?><?php endif; ?>
                                · <?= esc(date('d/m/Y H:i', strtotime($c['created_at']))) ?>
                            </small>
                            <?php if ($esEquipo): ?>
                                <form action="<?= site_url('desarrollador/comentarios/' . (int) $c['id_comentario'] . '/eliminar') ?>" method="POST"
                                      onsubmit="return confirm('¿Eliminar este comentario?');" class="np-comentario__borrar">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="np-link-peligro">Eliminar</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <p class="np-comentario__texto"><?= nl2br(esc($c['texto'])) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="np-vacio">Todavía no hay comentarios. ¡Sé el primero!</p>
        <?php endif; ?>
    </section>
</main>

<?= view('templates/footer') ?>
