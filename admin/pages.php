<?php
/**
 * SEITEN BEARBEITEN - admin/pages.php
 * =====================================
 * Ermöglicht das Bearbeiten des Inhalts aller Website-Seiten:
 * - Startseite (home)
 * - Über mich (about)
 * - Galerie (gallery)
 * - Kontakt (contact)
 *
 * Tab-Struktur: Jede Seite hat einen eigenen Tab.
 */

define('CMS_ROOT', dirname(__DIR__));
require_once CMS_ROOT . '/config/config.php';
require_once CMS_ROOT . '/includes/functions.php';
require_once CMS_ROOT . '/includes/auth.php';

require_login();

$settings    = get_settings();
$homePage    = get_page('home');
$aboutPage   = get_page('about');
$galleryPage = get_page('gallery');
$contactPage = get_page('contact');
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seiten – CMS Admin</title>
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
            <h2 class="admin-topbar__title">Seiten bearbeiten</h2>
            <div class="admin-topbar__actions">
                <a href="/" target="_blank" class="btn btn--secondary btn--sm">🌐 Website ansehen</a>
            </div>
        </div>

        <!-- TABS: Jede Seite ist ein Tab -->
        <div class="editor-tabs">
            <button class="editor-tab is-active" data-panel="tab-home">🏠 Startseite</button>
            <button class="editor-tab" data-panel="tab-about">👤 Über mich</button>
            <button class="editor-tab" data-panel="tab-gallery">🖼️ Galerie</button>
            <button class="editor-tab" data-panel="tab-contact">✉️ Kontakt</button>
        </div>


        <!-- ============================================================
             TAB 1: STARTSEITE
             ============================================================ -->
        <div class="editor-panel is-active" id="tab-home">
            <div class="card">
                <div class="card__header">
                    <h3 class="card__title">🏠 Startseite</h3>
                    <a href="/" target="_blank" class="btn btn--secondary btn--sm">Vorschau</a>
                </div>

                <form data-save-form="/admin/save.php">
                    <input type="hidden" name="action" value="page">
                    <input type="hidden" name="page" value="home">

                    <!-- Hero-Bereich -->
                    <h4 style="color: var(--admin-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem">
                        Hero-Bereich (Großes Intro)
                    </h4>

                    <div class="form-group">
                        <label for="hero_title">Haupttitel</label>
                        <input type="text" id="hero_title" name="hero_title"
                               value="<?= escape($homePage['hero_title']) ?>"
                               placeholder="Dein großes Motto oder Slogan">
                        <p class="form-help">Der große Text im Hero-Bereich</p>
                    </div>

                    <div class="form-group">
                        <label for="hero_subtitle">Untertitel</label>
                        <input type="text" id="hero_subtitle" name="hero_subtitle"
                               value="<?= escape($homePage['hero_subtitle']) ?>"
                               placeholder="Kurze Ergänzung zum Haupttitel">
                    </div>

                    <div class="form-group" data-upload-section>
                        <label>Hintergrundbild (optional)</label>
                        <?php if (!empty($homePage['hero_image'])): ?>
                        <div style="margin-bottom: 0.75rem">
                            <img src="<?= escape($homePage['hero_image']) ?>"
                                 style="height: 100px; object-fit: cover; border-radius: 4px">
                        </div>
                        <?php endif; ?>
                        <div class="upload-zone"
                             data-upload-type="image"
                             data-upload-page="home"
                             data-upload-field="hero_image"
                             style="padding: 1.5rem">
                            <input type="file" accept="image/*">
                            <span style="font-size: 1.5rem">🖼️</span>
                            <p class="upload-zone__text" style="font-size: 0.85rem">
                                Bild für den Hintergrund hochladen<br>
                                <span style="font-size: 0.75rem; color: var(--admin-muted)">Empfohlen: breites Bild (1920×1080px)</span>
                            </p>
                        </div>
                        <input type="hidden" name="hero_image" id="field_hero_image"
                               value="<?= escape($homePage['hero_image'] ?? '') ?>">
                    </div>

                    <hr style="border-color: var(--admin-border); margin: 1.5rem 0">

                    <!-- Kurz-Vorstellung -->
                    <h4 style="color: var(--admin-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem">
                        Kurze Vorstellung (unter dem Hero)
                    </h4>

                    <div class="form-group">
                        <label for="about_text">Kurz-Text</label>
                        <textarea id="about_text" name="about_text" style="height: 100px"
                                  placeholder="Wer bist du? Ein, zwei Sätze."><?= escape($homePage['about_text']) ?></textarea>
                    </div>

                    <hr style="border-color: var(--admin-border); margin: 1.5rem 0">

                    <!-- Galerie auf Startseite -->
                    <h4 style="color: var(--admin-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 1rem">
                        Galerie auf der Startseite
                    </h4>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="gallery_title">Galerie-Überschrift</label>
                            <input type="text" id="gallery_title" name="gallery_title"
                                   value="<?= escape($homePage['gallery_title']) ?>"
                                   placeholder="Ausgewählte Werke">
                        </div>
                        <div class="form-group">
                            <label>Galerie anzeigen?</label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.6rem; cursor: pointer">
                                <input type="checkbox" name="show_gallery" value="1"
                                       <?= !empty($homePage['show_gallery']) ? 'checked' : '' ?>>
                                <span style="font-size: 0.9rem">Ja, Galerie-Vorschau anzeigen</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn--primary">💾 Startseite speichern</button>
                </form>
            </div>
        </div>


        <!-- ============================================================
             TAB 2: ÜBER MICH
             ============================================================ -->
        <div class="editor-panel" id="tab-about">
            <div class="card">
                <div class="card__header">
                    <h3 class="card__title">👤 Über mich</h3>
                    <a href="/about.php" target="_blank" class="btn btn--secondary btn--sm">Vorschau</a>
                </div>

                <form data-save-form="/admin/save.php">
                    <input type="hidden" name="action" value="page">
                    <input type="hidden" name="page" value="about">

                    <div class="form-group">
                        <label for="about_page_title">Seitentitel</label>
                        <input type="text" id="about_page_title" name="title"
                               value="<?= escape($aboutPage['title']) ?>">
                    </div>

                    <!-- Foto hochladen -->
                    <div class="form-group" data-upload-section>
                        <label>Dein Foto (optional)</label>
                        <?php if (!empty($aboutPage['image'])): ?>
                        <div style="margin-bottom: 0.75rem">
                            <img src="<?= escape($aboutPage['image']) ?>"
                                 style="height: 120px; object-fit: cover; border-radius: 4px">
                        </div>
                        <?php endif; ?>
                        <div class="upload-zone"
                             data-upload-type="image"
                             data-upload-page="about"
                             data-upload-field="image"
                             style="padding: 1.5rem">
                            <input type="file" accept="image/*">
                            <span style="font-size: 1.5rem">📷</span>
                            <p class="upload-zone__text" style="font-size: 0.85rem">
                                Porträtfoto hochladen
                            </p>
                        </div>
                        <input type="hidden" name="image" id="field_image"
                               value="<?= escape($aboutPage['image'] ?? '') ?>">
                    </div>

                    <!-- Text (Rich Editor) -->
                    <div class="form-group">
                        <label>Über-mich-Text</label>
                        <!-- Toolbar für Rich-Text -->
                        <div class="editor-toolbar">
                            <button type="button" class="toolbar-btn" data-cmd="bold" title="Fett"><strong>B</strong></button>
                            <button type="button" class="toolbar-btn" data-cmd="italic" title="Kursiv"><em>I</em></button>
                            <button type="button" class="toolbar-btn" data-cmd="underline" title="Unterstrichen"><u>U</u></button>
                            <span class="toolbar-divider"></span>
                            <button type="button" class="toolbar-btn" data-cmd="insertUnorderedList" title="Liste">≡</button>
                            <button type="button" class="toolbar-btn" data-cmd="formatBlock" data-value="p" title="Absatz">¶</button>
                        </div>
                        <!-- Editierbarer Bereich (contenteditable) -->
                        <div class="rich-editor" id="about_text_editor"
                             data-rich-for="about_text_hidden">
                            <?= $aboutPage['text'] ?>
                        </div>
                        <!-- Verstecktes Feld für den HTML-Inhalt -->
                        <textarea name="text" id="about_text_hidden" style="display:none"><?= $aboutPage['text'] ?></textarea>
                    </div>

                    <!-- CV-Einträge -->
                    <div class="form-group">
                        <label>Vita / CV (optional)</label>
                        <p class="form-help" style="margin-bottom: 1rem">
                            Gib jeden Eintrag als JSON-Array ein. Beispiel ist bereits vorausgefüllt.
                            Format: [{"year":"2024","text":"Ausstellung..."}]
                        </p>
                        <textarea name="cv" style="height: 150px; font-family: monospace; font-size: 0.82rem"><?= escape(json_encode($aboutPage['cv'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></textarea>
                    </div>

                    <button type="submit" class="btn btn--primary">💾 Über mich speichern</button>
                </form>
            </div>
        </div>


        <!-- ============================================================
             TAB 3: GALERIE-SEITE
             ============================================================ -->
        <div class="editor-panel" id="tab-gallery">
            <div class="card">
                <div class="card__header">
                    <h3 class="card__title">🖼️ Galerie-Seite</h3>
                    <a href="/gallery.php" target="_blank" class="btn btn--secondary btn--sm">Vorschau</a>
                </div>
                <p style="color: var(--admin-muted); font-size: 0.85rem; margin-bottom: 1.5rem">
                    Zum Verwalten der Bilder, gehe zur
                    <a href="/admin/gallery.php">Galerie-Verwaltung</a>.
                    Hier kannst du nur den Titel und die Beschreibung der Galerie-Seite anpassen.
                </p>

                <form data-save-form="/admin/save.php">
                    <input type="hidden" name="action" value="page">
                    <input type="hidden" name="page" value="gallery">

                    <div class="form-group">
                        <label for="gallery_page_title">Seitentitel</label>
                        <input type="text" id="gallery_page_title" name="title"
                               value="<?= escape($galleryPage['title']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="gallery_description">Beschreibungstext</label>
                        <textarea id="gallery_description" name="description"
                                  placeholder="Kurze Beschreibung deiner Galerie..."><?= escape($galleryPage['description'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn--primary">💾 Galerie-Seite speichern</button>
                </form>
            </div>
        </div>


        <!-- ============================================================
             TAB 4: KONTAKT
             ============================================================ -->
        <div class="editor-panel" id="tab-contact">
            <div class="card">
                <div class="card__header">
                    <h3 class="card__title">✉️ Kontakt-Seite</h3>
                    <a href="/contact.php" target="_blank" class="btn btn--secondary btn--sm">Vorschau</a>
                </div>

                <form data-save-form="/admin/save.php">
                    <input type="hidden" name="action" value="page">
                    <input type="hidden" name="page" value="contact">

                    <div class="form-group">
                        <label for="contact_title">Seitentitel</label>
                        <input type="text" id="contact_title" name="title"
                               value="<?= escape($contactPage['title']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="contact_text">Einleitungstext</label>
                        <textarea id="contact_text" name="text"
                                  placeholder="Kurze Einladung zum Kontaktieren..."><?= escape($contactPage['text']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Kontaktformular anzeigen?</label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.6rem; cursor: pointer">
                            <input type="checkbox" name="show_form" value="1"
                                   <?= !empty($contactPage['show_form']) ? 'checked' : '' ?>>
                            <span style="font-size: 0.9rem">Ja, Kontaktformular anzeigen</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn--primary">💾 Kontakt-Seite speichern</button>
                </form>
            </div>
        </div>

    </main>
</div>

<script src="/assets/js/admin.js"></script>
</body>
</html>
