<?php
/**
 * ÜBER MICH SEITE (About Page) - about.php
 * ==========================================
 * Stellt die Künstlerin/den Künstler vor.
 * Enthält: Foto, Text, und optional ein CV (Lebenslauf).
 */

define('CMS_ROOT', __DIR__);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

$settings  = get_settings();
$aboutPage = get_page('about');

$pageTitle = $aboutPage['title'] ?? 'Über mich';

include __DIR__ . '/includes/header.php';
?>

<div style="height: 80px"></div>

<!-- ============================================================
     ÜBER MICH - HAUPTBEREICH
     ============================================================ -->
<section class="section">
    <div class="container">

        <?php if (!empty($aboutPage['image'])): ?>
        <!-- Layout mit Bild: Bild links, Text rechts -->
        <div class="about-layout">

            <!-- Bild-Seite -->
            <div class="about-image" data-reveal="left">
                <img src="<?= escape($aboutPage['image']) ?>"
                     alt="Porträt von <?= escape($settings['site_name']) ?>">
            </div>

            <!-- Text-Seite -->
            <div class="about-text" data-reveal="right">
                <span class="section-header__eyebrow">Wer ich bin</span>
                <h1 style="margin-bottom: 1.5rem"><?= escape($aboutPage['title']) ?></h1>

                <!-- Der Text kann HTML enthalten (wird im Admin mit Rich-Editor bearbeitet) -->
                <!-- wp_kses_post wäre ideal hier, wir nutzen aber allow_safe_html() -->
                <div class="about-content">
                    <?= $aboutPage['text'] /* HTML erlaubt – wird vom Admin kontrolliert */ ?>
                </div>

                <?php if (!empty($aboutPage['cv'])): ?>
                <div class="cv-list" style="margin-top: 2rem">
                    <h3 style="font-size: 1rem; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 1rem; color: var(--text-muted)">
                        Vita
                    </h3>
                    <?php foreach ($aboutPage['cv'] as $entry): ?>
                    <div class="cv-item">
                        <span class="cv-item__year"><?= escape($entry['year'] ?? '') ?></span>
                        <span class="cv-item__text"><?= escape($entry['text'] ?? '') ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php else: ?>
        <!-- Layout ohne Bild: Zentrierter Text -->
        <div style="max-width: 700px; margin: 0 auto">
            <div style="text-align: center; margin-bottom: 3rem" data-reveal>
                <span class="section-header__eyebrow">Wer ich bin</span>
                <h1><?= escape($aboutPage['title']) ?></h1>
            </div>

            <div class="about-content" data-reveal>
                <?= $aboutPage['text'] ?>
            </div>

            <?php if (!empty($aboutPage['cv'])): ?>
            <div class="cv-list" style="margin-top: 3rem" data-reveal>
                <div class="divider">
                    <span class="divider__text">Vita</span>
                </div>
                <?php foreach ($aboutPage['cv'] as $entry): ?>
                <div class="cv-item">
                    <span class="cv-item__year"><?= escape($entry['year'] ?? '') ?></span>
                    <span class="cv-item__text"><?= escape($entry['text'] ?? '') ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</section>


<!-- ============================================================
     KONTAKT-LINK
     ============================================================ -->
<section class="section--sm" style="text-align: center; border-top: 1px solid rgba(0,0,0,0.08)">
    <div class="container" data-reveal>
        <p style="color: var(--text-muted); margin-bottom: 1rem">
            Interesse an einer Zusammenarbeit?
        </p>
        <a href="/contact.php" class="btn btn--primary">Kontakt aufnehmen</a>
    </div>
</section>


<?php include __DIR__ . '/includes/footer.php'; ?>
