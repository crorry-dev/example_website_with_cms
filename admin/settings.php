<?php
/**
 * ADMIN EINSTELLUNGEN - admin/settings.php
 * ==========================================
 * Hier kann der Admin die Website-Einstellungen anpassen:
 * - Seitenname und Tagline
 * - Farben (Akzent, Hintergrund, Text)
 * - Schriftarten
 * - Social-Media-Links
 * - Passwort ändern
 */

define('CMS_ROOT', dirname(__DIR__));
require_once CMS_ROOT . '/config/config.php';
require_once CMS_ROOT . '/includes/functions.php';
require_once CMS_ROOT . '/includes/auth.php';

require_login();

$settings = get_settings();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Einstellungen – CMS Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="admin-main">

        <div class="admin-topbar">
            <h2 class="admin-topbar__title">Einstellungen</h2>
            <div class="admin-topbar__actions">
                <a href="/" target="_blank" class="btn btn--secondary btn--sm">🌐 Website</a>
            </div>
        </div>

        <!-- Vorschau-Link -->
        <div class="preview-bar">
            <span>Änderungen werden sofort auf der Website sichtbar.</span>
            <a href="/" target="_blank" class="btn btn--sm" style="background: var(--admin-accent); color: white">
                Vorschau öffnen →
            </a>
        </div>

        <!-- ============================================================
             ALLGEMEINE EINSTELLUNGEN
             ============================================================ -->
        <div class="card">
            <div class="card__header">
                <h3 class="card__title">🌐 Allgemein</h3>
            </div>

            <form data-save-form="/admin/save.php">
                <input type="hidden" name="action" value="settings">

                <div class="form-row">
                    <div class="form-group">
                        <label for="site_name">Seitenname *</label>
                        <input type="text" id="site_name" name="site_name"
                               value="<?= escape($settings['site_name']) ?>"
                               required placeholder="z.B. Anna Müller – Künstlerin">
                        <p class="form-help">Erscheint im Browser-Tab und im Header</p>
                    </div>
                    <div class="form-group">
                        <label for="site_tagline">Tagline / Kurzbeschreibung</label>
                        <input type="text" id="site_tagline" name="site_tagline"
                               value="<?= escape($settings['site_tagline']) ?>"
                               placeholder="z.B. Malerei, Fotografie, Installation">
                        <p class="form-help">Kurzer Beschreibungssatz für Suchmaschinen</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="site_email">E-Mail-Adresse</label>
                    <input type="email" id="site_email" name="site_email"
                           value="<?= escape($settings['site_email']) ?>"
                           placeholder="deine@email.de">
                    <p class="form-help">Hierhin werden Kontaktformular-Nachrichten geschickt</p>
                </div>

                <div class="form-group">
                    <label for="footer_text">Footer-Text</label>
                    <input type="text" id="footer_text" name="footer_text"
                           value="<?= escape($settings['footer_text']) ?>"
                           placeholder="2026 Dein Name. Alle Rechte vorbehalten.">
                </div>

                <button type="submit" class="btn btn--primary">💾 Speichern</button>
            </form>
        </div>


        <!-- ============================================================
             DESIGN (Farben & Schriften)
             ============================================================ -->
        <div class="card">
            <div class="card__header">
                <h3 class="card__title">🎨 Design</h3>
            </div>

            <form data-save-form="/admin/save.php">
                <input type="hidden" name="action" value="settings">

                <p style="color: var(--admin-muted); font-size: 0.85rem; margin-bottom: 1.5rem">
                    Alle Farbänderungen sind sofort auf deiner Website sichtbar.
                    Klicke auf das Farbfeld um den Farbwähler zu öffnen.
                </p>

                <!-- Farben -->
                <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr">

                    <div class="form-group">
                        <label for="accent_color">Akzentfarbe</label>
                        <div style="display: flex; gap: 0.5rem; align-items: center">
                            <input type="color" id="accent_color" name="accent_color"
                                   value="<?= escape($settings['accent_color']) ?>">
                            <span style="font-size: 0.85rem; color: var(--admin-muted)">
                                <?= escape($settings['accent_color']) ?>
                            </span>
                        </div>
                        <p class="form-help">Links, Hervorhebungen, Dekorationen</p>
                    </div>

                    <div class="form-group">
                        <label for="bg_color">Hintergrundfarbe</label>
                        <div style="display: flex; gap: 0.5rem; align-items: center">
                            <input type="color" id="bg_color" name="bg_color"
                                   value="<?= escape($settings['bg_color']) ?>">
                            <span style="font-size: 0.85rem; color: var(--admin-muted)">
                                <?= escape($settings['bg_color']) ?>
                            </span>
                        </div>
                        <p class="form-help">Seitenhintergrund (empfohlen: helles Weiß/Beige)</p>
                    </div>

                    <div class="form-group">
                        <label for="text_color">Textfarbe</label>
                        <div style="display: flex; gap: 0.5rem; align-items: center">
                            <input type="color" id="text_color" name="text_color"
                                   value="<?= escape($settings['text_color']) ?>">
                            <span style="font-size: 0.85rem; color: var(--admin-muted)">
                                <?= escape($settings['text_color']) ?>
                            </span>
                        </div>
                        <p class="form-help">Haupttextfarbe (empfohlen: Dunkelgrau/Schwarz)</p>
                    </div>

                </div>

                <!-- Schriften -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="font_heading">Schrift für Überschriften</label>
                        <select id="font_heading" name="font_heading">
                            <?php
                            $headingFonts = [
                                'Playfair Display' => 'Playfair Display (elegant, Serifen)',
                                'Cormorant Garamond' => 'Cormorant Garamond (klassisch)',
                                'Libre Baskerville' => 'Libre Baskerville (traditionell)',
                                'Josefin Sans' => 'Josefin Sans (modern, geometrisch)',
                                'Raleway' => 'Raleway (schlank, elegant)',
                                'Montserrat' => 'Montserrat (modern, klar)',
                                'Georgia' => 'Georgia (System-Schrift, Serifen)',
                                'Arial' => 'Arial (System-Schrift, serifenlos)',
                            ];
                            foreach ($headingFonts as $value => $label):
                            ?>
                            <option value="<?= escape($value) ?>"
                                    <?= $settings['font_heading'] === $value ? 'selected' : '' ?>>
                                <?= escape($label) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="font_body">Schrift für Fließtext</label>
                        <select id="font_body" name="font_body">
                            <?php
                            $bodyFonts = [
                                'Lato'    => 'Lato (klar, lesbar)',
                                'Open Sans' => 'Open Sans (freundlich)',
                                'Roboto'  => 'Roboto (technisch, modern)',
                                'Source Sans Pro' => 'Source Sans Pro (neutral)',
                                'Nunito'  => 'Nunito (rund, freundlich)',
                                'Inter'   => 'Inter (digital-optimiert)',
                                'Arial'   => 'Arial (System-Schrift)',
                            ];
                            foreach ($bodyFonts as $value => $label):
                            ?>
                            <option value="<?= escape($value) ?>"
                                    <?= $settings['font_body'] === $value ? 'selected' : '' ?>>
                                <?= escape($label) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn--primary">💾 Design speichern</button>
            </form>
        </div>


        <!-- ============================================================
             EIGENE SCHRIFTART HOCHLADEN
             ============================================================ -->
        <div class="card" data-upload-section>
            <div class="card__header">
                <h3 class="card__title">🔤 Eigene Schriftart</h3>
            </div>

            <p style="color: var(--admin-muted); font-size: 0.85rem; margin-bottom: 1.5rem">
                Du kannst deine eigene Schriftart hochladen (TTF, OTF, WOFF, WOFF2-Dateien).
                Deine Schriftart wird dann als zusätzliche Option für Überschriften verfügbar.
            </p>

            <?php if (!empty($settings['custom_font'])): ?>
            <div class="alert alert--info" style="margin-bottom: 1rem">
                Aktuelle eigene Schrift: <strong><?= escape($settings['custom_font']) ?></strong>
            </div>
            <?php endif; ?>

            <div class="upload-zone" data-upload-type="font">
                <input type="file" accept=".ttf,.otf,.woff,.woff2">
                <span class="upload-zone__icon">🔤</span>
                <p class="upload-zone__text">
                    Schriftart hier ablegen oder klicken<br>
                    <span style="font-size: 0.78rem; color: var(--admin-muted)">TTF, OTF, WOFF, WOFF2 – max. 10 MB</span>
                </p>
            </div>
        </div>


        <!-- ============================================================
             SOCIAL MEDIA
             ============================================================ -->
        <div class="card">
            <div class="card__header">
                <h3 class="card__title">📱 Social Media</h3>
            </div>

            <form data-save-form="/admin/save.php">
                <input type="hidden" name="action" value="settings">

                <div class="form-group">
                    <label for="social_instagram">Instagram URL</label>
                    <input type="url" id="social_instagram" name="social_instagram"
                           value="<?= escape($settings['social_instagram']) ?>"
                           placeholder="https://instagram.com/dein-profil">
                </div>

                <div class="form-group">
                    <label for="social_facebook">Facebook URL</label>
                    <input type="url" id="social_facebook" name="social_facebook"
                           value="<?= escape($settings['social_facebook']) ?>"
                           placeholder="https://facebook.com/deine-seite">
                </div>

                <button type="submit" class="btn btn--primary">💾 Speichern</button>
            </form>
        </div>


        <!-- ============================================================
             PASSWORT ÄNDERN
             ============================================================ -->
        <div class="card">
            <div class="card__header">
                <h3 class="card__title">🔒 Passwort ändern</h3>
            </div>

            <div class="alert alert--info" style="margin-bottom: 1.5rem">
                ⚠️ Bitte ändere das Standard-Passwort (admin123) sofort nach dem ersten Login!
            </div>

            <form id="passwordForm">
                <input type="hidden" name="action" value="change_password">

                <div class="form-row">
                    <div class="form-group">
                        <label for="new_password">Neues Passwort</label>
                        <input type="password" id="new_password" name="new_password"
                               placeholder="Mindestens 6 Zeichen" minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Passwort wiederholen</label>
                        <input type="password" id="confirm_password" name="confirm_password"
                               placeholder="Passwort nochmals eingeben">
                    </div>
                </div>

                <button type="submit" class="btn btn--primary">🔒 Passwort ändern</button>
            </form>
        </div>

    </main>
</div>

<script src="/assets/js/admin.js"></script>
</body>
</html>
