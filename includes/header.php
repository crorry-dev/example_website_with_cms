<?php
/**
 * HTML-KOPFBEREICH (Header)
 * ==========================
 * Diese Datei wird am Anfang jeder Seite eingebunden.
 * Sie enthält alles, was im <head>-Bereich des HTML steht:
 * - Meta-Tags (für Suchmaschinen und Mobilgeräte)
 * - CSS-Verlinkungen (Stylesheets)
 * - Schriftarten (Google Fonts)
 *
 * Warum auslagern? → Damit du es nur einmal schreiben musst!
 * Wenn du z.B. den Seitentitel änderst, machst du das nur hier.
 *
 * @var array $settings   Website-Einstellungen (wird von der aufrufenden Seite übergeben)
 * @var string $pageTitle Seitentitel (optional, wird von der aufrufenden Seite gesetzt)
 */

// Sichergehen, dass $settings vorhanden ist
if (!isset($settings)) {
    $settings = get_settings();
}
if (!isset($pageTitle)) {
    $pageTitle = $settings['site_name'];
}

$currentPage = current_page();
?>
<!DOCTYPE html>
<!--
    DOCTYPE html: Sagt dem Browser, dass dies eine moderne HTML5-Seite ist.
    Immer die erste Zeile einer HTML-Datei!
-->
<html lang="de">
<!--
    lang="de": Gibt die Sprache der Seite an.
    Wichtig für Barrierefreiheit und Suchmaschinen!
-->
<head>
    <!-- Zeichensatz: UTF-8 unterstützt alle Sonderzeichen (ä,ö,ü,€,...) -->
    <meta charset="UTF-8">

    <!-- Viewport: Macht die Seite auf Mobilgeräten richtig skaliert -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Seitentitel (erscheint im Browser-Tab) -->
    <title><?= escape($pageTitle) ?> – <?= escape($settings['site_name']) ?></title>

    <!-- Meta-Description für Suchmaschinen (SEO) -->
    <meta name="description" content="<?= escape($settings['site_tagline']) ?>">

    <!-- Google Fonts: Elegante Schriftarten aus dem Internet laden -->
    <!-- Preconnect: Browser stellt schon früh eine Verbindung zu Google her → schneller! -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <?php if (!empty($settings['custom_font_url'])): ?>
    <!-- Eigene hochgeladene Schriftart einbinden -->
    <style>
        @font-face {
            font-family: '<?= escape($settings['custom_font']) ?>';
            src: url('<?= escape($settings['custom_font_url']) ?>') format('woff2'),
                 url('<?= escape($settings['custom_font_url']) ?>') format('woff');
            font-display: swap; /* Seite zeigt erst System-Schrift, dann wechselt sie */
        }
    </style>
    <?php endif; ?>

    <!-- Haupt-Stylesheet einbinden -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- CSS-Variablen aus den Einstellungen dynamisch setzen -->
    <!--
        CSS Custom Properties (--variablen-name): Das ist modern CSS!
        Diese Werte werden vom PHP aus den Einstellungen gesetzt
        und können dann überall im CSS verwendet werden.
    -->
    <style>
        :root {
            --accent:       <?= escape($settings['accent_color']) ?>;
            --bg:           <?= escape($settings['bg_color']) ?>;
            --text:         <?= escape($settings['text_color']) ?>;
            --font-heading: '<?= escape($settings['font_heading']) ?>', Georgia, serif;
            --font-body:    '<?= escape($settings['font_body']) ?>', Arial, sans-serif;
            <?php if (!empty($settings['custom_font'])): ?>
            --font-custom:  '<?= escape($settings['custom_font']) ?>', var(--font-heading);
            <?php endif; ?>
        }
    </style>
</head>
<body class="page-<?= escape($currentPage) ?>">

<!-- LADE-ANIMATION (Loading Screen) -->
<!-- Wird kurz beim Laden der Seite angezeigt, dann weggefadet -->
<div id="loader" class="loader" aria-hidden="true">
    <div class="loader__dot"></div>
    <div class="loader__dot"></div>
    <div class="loader__dot"></div>
</div>

<!-- KOPFZEILE (Header) -->
<header class="site-header" id="site-header">
    <div class="container">
        <!-- Logo / Seitenname -->
        <a href="/" class="site-header__logo">
            <?= escape($settings['site_name']) ?>
        </a>

        <!-- Hamburger-Button für Mobile (erscheint auf kleinen Bildschirmen) -->
        <button class="nav-toggle" id="navToggle" aria-label="Menü öffnen" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- NAVIGATION -->
        <nav class="site-nav" id="siteNav" aria-label="Hauptnavigation">
            <ul class="site-nav__list">
                <li>
                    <a href="/" class="site-nav__link <?= $currentPage === 'home' ? 'is-active' : '' ?>">
                        Start
                    </a>
                </li>
                <li>
                    <a href="/gallery.php" class="site-nav__link <?= $currentPage === 'gallery' ? 'is-active' : '' ?>">
                        Galerie
                    </a>
                </li>
                <li>
                    <a href="/about.php" class="site-nav__link <?= $currentPage === 'about' ? 'is-active' : '' ?>">
                        Über mich
                    </a>
                </li>
                <li>
                    <a href="/contact.php" class="site-nav__link <?= $currentPage === 'contact' ? 'is-active' : '' ?>">
                        Kontakt
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<!-- HAUPTINHALT beginnt direkt nach dem Header -->
<main id="main-content">
