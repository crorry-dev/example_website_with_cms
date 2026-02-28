<?php
/**
 * GALERIE-SEITE (Gallery Page) - gallery.php
 * ============================================
 * Zeigt alle Kunstwerke in einem Grid-Layout.
 * Besucher können Bilder anklicken um sie größer zu sehen (Lightbox).
 */

define('CMS_ROOT', __DIR__);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

$settings    = get_settings();
$galleryPage = get_page('gallery');
$gallery     = get_gallery();

$pageTitle = $galleryPage['title'] ?? 'Galerie';

include __DIR__ . '/includes/header.php';
?>

<!-- Platz für den Header (der Header ist fixed, deshalb brauchen wir Abstand oben) -->
<div style="height: 80px"></div>

<!-- ============================================================
     SEITEN-TITEL
     ============================================================ -->
<section class="section--sm">
    <div class="container">
        <div class="section-header" data-reveal>
            <span class="section-header__eyebrow">Portfolio</span>
            <h1><?= escape($galleryPage['title']) ?></h1>
            <?php if (!empty($galleryPage['description'])): ?>
            <p style="color: var(--text-muted); margin-top: 1rem; max-width: 500px; margin-left: auto; margin-right: auto">
                <?= escape($galleryPage['description']) ?>
            </p>
            <?php endif; ?>
        </div>
    </div>
</section>


<!-- ============================================================
     GALERIE-GRID
     ============================================================ -->
<section class="gallery-section" style="padding-top: 0">
    <div class="container">

        <?php if (!empty($gallery)): ?>
        <div class="gallery-grid">
            <?php foreach ($gallery as $i => $item): ?>
            <div class="gallery-item"
                 data-reveal
                 data-delay="<?= min($i * 80, 400) ?>"
                 tabindex="0"
                 role="button"
                 aria-label="<?= escape($item['title'] ?? 'Galerie-Bild') ?> in Großansicht öffnen">

                <?php if (!empty($item['image'])): ?>
                <img class="gallery-item__img"
                     src="<?= escape($item['image']) ?>"
                     alt="<?= escape($item['title'] ?? '') ?>"
                     loading="lazy">
                <?php else: ?>
                <!-- Platzhalter-Grafik -->
                <div class="gallery-item__img" style="
                    background: linear-gradient(135deg, #e8ddd1 0%, var(--accent) 100%);
                    width: 100%; height: 100%;
                    display: flex; align-items: center; justify-content: center;
                    font-family: var(--font-heading); font-style: italic;
                    color: rgba(255,255,255,0.6); font-size: 2rem;
                ">
                    <?= escape(substr($item['title'] ?? '?', 0, 1)) ?>
                </div>
                <?php endif; ?>

                <div class="gallery-item__overlay">
                    <p class="gallery-item__title"><?= escape($item['title'] ?? '') ?></p>
                    <p class="gallery-item__meta"><?= escape($item['medium'] ?? '') ?></p>
                    <?php if (!empty($item['description'])): ?>
                    <p class="gallery-item__meta" style="margin-top: 0.25rem; font-style: italic">
                        <?= escape($item['description']) ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
        <!-- Wenn noch keine Bilder hochgeladen wurden -->
        <div style="text-align: center; padding: 4rem; color: var(--text-muted)">
            <p style="font-size: 3rem; margin-bottom: 1rem">🎨</p>
            <p>Noch keine Werke vorhanden.</p>
            <p style="margin-top: 1rem">
                <a href="/admin/gallery.php">Bilder im Admin-Bereich hochladen →</a>
            </p>
        </div>
        <?php endif; ?>

    </div>
</section>


<?php include __DIR__ . '/includes/footer.php'; ?>
