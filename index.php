<?php
/**
 * STARTSEITE (Homepage) - index.php
 * ====================================
 * Die Startseite ist die erste Seite, die Besucher sehen.
 * Sie enthält:
 * - Hero-Bereich (großes Intro mit Titel)
 * - Kurze "Über mich"-Vorstellung
 * - Ausgewählte Galerie-Vorschau
 *
 * Warum index.php?
 * → Der Webserver öffnet automatisch "index.php" wenn jemand die
 *   Webadresse ohne Dateinamen aufruft (z.B. https://meinseite.de/)
 */

// Konfiguration und Funktionen laden
// dirname(__FILE__) = Ordner dieser Datei
// __DIR__ ist eine Kurzform dafür (PHP 5.3+)
define('CMS_ROOT', __DIR__);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

// Daten laden
$settings  = get_settings();
$homePage  = get_page('home');
$gallery   = get_gallery();

// Nur die ersten 6 Bilder auf der Startseite zeigen
$galleryPreview = array_slice($gallery, 0, 6);

// Seitentitel setzen
$pageTitle = 'Start';

// Header einbinden
include __DIR__ . '/includes/header.php';
?>

<!-- ============================================================
     HERO-BEREICH (Großes Intro)
     Der Hero ist der erste Bereich der Startseite.
     Er soll sofort die Aufmerksamkeit des Besuchers fangen!
     ============================================================ -->
<section class="hero <?= !empty($homePage['hero_image']) ? 'hero--has-image' : '' ?>">

    <?php if (!empty($homePage['hero_image'])): ?>
    <!-- Hintergrundbild (falls in Admin gesetzt) -->
    <div class="hero__bg" style="background-image: url('<?= escape($homePage['hero_image']) ?>')"></div>
    <?php else: ?>
    <!-- Kein Bild: Eleganter Farbverlauf als Hintergrund -->
    <div class="hero__bg" style="background: linear-gradient(135deg, var(--bg) 0%, #e8ddd1 50%, var(--bg) 100%)"></div>
    <?php endif; ?>

    <!-- Inhalt des Hero-Bereichs -->
    <div class="hero__content">
        <!-- Kleiner Text über dem Haupttitel -->
        <span class="hero__eyebrow" data-reveal>
            <?= escape($settings['site_name']) ?>
        </span>

        <!-- Haupttitel -->
        <h1 class="hero__title" data-reveal data-delay="100">
            <?= escape($homePage['hero_title']) ?>
        </h1>

        <!-- Untertitel -->
        <p class="hero__subtitle" data-reveal data-delay="200">
            <?= escape($homePage['hero_subtitle']) ?>
        </p>

        <!-- Call-to-Action Buttons -->
        <div data-reveal data-delay="300">
            <a href="/gallery.php" class="btn <?= !empty($homePage['hero_image']) ? 'btn--ghost' : 'btn--primary' ?>">
                Galerie ansehen
            </a>
            <a href="/about.php" class="btn btn--outline" style="margin-left: 1rem">
                Über mich
            </a>
        </div>
    </div>

    <!-- Scroll-Indikator -->
    <div class="hero__scroll">
        <div class="hero__scroll-line"></div>
        <span>Scroll</span>
    </div>
</section>


<!-- ============================================================
     ÜBER MICH KURZ-VORSCHAU
     ============================================================ -->
<section class="section">
    <div class="container">
        <div class="divider">
            <span class="divider__text">Wer ich bin</span>
        </div>

        <div style="max-width: 600px; margin: 0 auto; text-align: center" data-reveal>
            <p style="font-size: 1.15rem; line-height: 1.8; color: var(--text-muted)">
                <?= escape($homePage['about_text']) ?>
            </p>
            <a href="/about.php" class="btn btn--outline" style="margin-top: 2rem">
                Mehr über mich →
            </a>
        </div>
    </div>
</section>


<?php if (!empty($galleryPreview) && $homePage['show_gallery']): ?>
<!-- ============================================================
     GALERIE-VORSCHAU auf der Startseite
     ============================================================ -->
<section class="gallery-section">
    <div class="container">

        <!-- Überschrift -->
        <div class="section-header" data-reveal>
            <span class="section-header__eyebrow">Portfolio</span>
            <h2><?= escape($homePage['gallery_title']) ?></h2>
        </div>

        <!-- Galerie-Grid -->
        <div class="gallery-grid">
            <?php foreach ($galleryPreview as $i => $item): ?>
            <!--
                data-reveal: Animiert das Element beim Einblenden
                data-delay: Verzögerung in ms (gestaffeltes Einblenden)
            -->
            <div class="gallery-item"
                 data-reveal
                 data-delay="<?= min($i * 100, 500) ?>"
                 tabindex="0"
                 role="button"
                 aria-label="<?= escape($item['title'] ?? 'Galerie-Bild') ?> vergrößern">

                <?php if (!empty($item['image'])): ?>
                <img class="gallery-item__img"
                     src="<?= escape($item['image']) ?>"
                     alt="<?= escape($item['title'] ?? '') ?>"
                     loading="lazy">
                <?php else: ?>
                <!-- Platzhalter wenn kein Bild hochgeladen -->
                <div class="gallery-item__img" style="
                    background: linear-gradient(135deg, #ddd 0%, #c4a882 50%, #ddd 100%);
                    width: 100%; height: 100%;
                    display: flex; align-items: center; justify-content: center;
                    color: rgba(0,0,0,0.3); font-size: 3rem;
                ">✦</div>
                <?php endif; ?>

                <!-- Overlay mit Titel (erscheint beim Hover) -->
                <div class="gallery-item__overlay">
                    <p class="gallery-item__title"><?= escape($item['title'] ?? '') ?></p>
                    <p class="gallery-item__meta"><?= escape($item['medium'] ?? '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Link zur vollen Galerie -->
        <div style="text-align: center; margin-top: 3rem" data-reveal>
            <a href="/gallery.php" class="btn btn--outline">
                Alle Werke ansehen →
            </a>
        </div>

    </div>
</section>
<?php endif; ?>


<!-- ============================================================
     KONTAKT-CTA (Call to Action)
     Ein einfacher Block am Ende der Seite der zum Kontakt einlädt.
     ============================================================ -->
<section class="section" style="background: var(--text); color: var(--bg); padding: 4rem 0">
    <div class="container" style="text-align: center" data-reveal>
        <span class="section-header__eyebrow" style="color: var(--accent)">Zusammenarbeit</span>
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem; color: inherit">
            Lass uns in Kontakt treten.
        </h2>
        <p style="opacity: 0.7; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto">
            Für Ausstellungsanfragen, Kooperationen oder einfach ein erstes Gespräch.
        </p>
        <a href="/contact.php" class="btn btn--ghost">Kontakt aufnehmen</a>
    </div>
</section>


<?php
// Footer einbinden
include __DIR__ . '/includes/footer.php';
?>
