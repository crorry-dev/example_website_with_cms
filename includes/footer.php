<?php
/**
 * HTML-FUSSBEREICH (Footer)
 * ==========================
 * Diese Datei wird am Ende jeder Seite eingebunden.
 * Enthält: Copyright, Links, Social Media, JavaScript-Einbindung
 *
 * Warum am Ende? → JavaScript lädt am Ende der Seite, damit die Seite
 * zuerst angezeigt wird und dann erst die Skripte ausgeführt werden.
 * Das macht die Seite schneller für den Benutzer!
 *
 * @var array $settings   Website-Einstellungen
 */
if (!isset($settings)) {
    $settings = get_settings();
}
?>

<!-- Ende des Hauptinhalts -->
</main>

<!-- ============================================================
     FOOTER (Fußbereich)
     Sichtbar am Ende jeder Seite
     ============================================================ -->
<footer class="site-footer">
    <div class="container">
        <div class="site-footer__grid">

            <!-- Spalte 1: Seitenname + Tagline -->
            <div class="site-footer__brand">
                <p class="site-footer__name"><?= escape($settings['site_name']) ?></p>
                <p class="site-footer__tagline"><?= escape($settings['site_tagline']) ?></p>
            </div>

            <!-- Spalte 2: Navigation -->
            <nav class="site-footer__nav" aria-label="Footer Navigation">
                <ul>
                    <li><a href="/">Start</a></li>
                    <li><a href="/gallery.php">Galerie</a></li>
                    <li><a href="/about.php">Über mich</a></li>
                    <li><a href="/contact.php">Kontakt</a></li>
                </ul>
            </nav>

            <!-- Spalte 3: Social Media -->
            <?php if (!empty($settings['social_instagram']) || !empty($settings['social_facebook'])): ?>
            <div class="site-footer__social">
                <?php if (!empty($settings['social_instagram'])): ?>
                <a href="<?= escape($settings['social_instagram']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <!-- SVG-Icon für Instagram -->
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                        <circle cx="12" cy="12" r="4"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                    Instagram
                </a>
                <?php endif; ?>
                <?php if (!empty($settings['social_facebook'])): ?>
                <a href="<?= escape($settings['social_facebook']) ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                    </svg>
                    Facebook
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>

        <!-- Copyright-Zeile -->
        <div class="site-footer__bottom">
            <p><?= escape($settings['footer_text']) ?></p>
            <!-- Kleiner Hinweis auf das CMS – kannst du entfernen -->
            <p><small><a href="/admin/" class="admin-link">Verwalten</a></small></p>
        </div>
    </div>
</footer>

<!-- ============================================================
     JAVASCRIPT EINBINDUNG
     JS wird am Ende geladen damit die Seite zuerst angezeigt wird.
     ============================================================ -->

<!-- Haupt-JavaScript-Datei -->
<script src="/assets/js/main.js"></script>

<!-- Falls auf einer Seite extra-JS benötigt wird, kommt es hier hin -->
<?php if (isset($extraJs)): ?>
<script><?= $extraJs ?></script>
<?php endif; ?>

</body>
</html>
