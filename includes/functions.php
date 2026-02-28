<?php
/**
 * HILFSFUNKTIONEN (Helper Functions)
 * ====================================
 * Hier sind alle wichtigen Funktionen, die überall im CMS gebraucht werden.
 *
 * Was ist eine Funktion? → Ein wiederverwendbarer Code-Block, dem du einen Namen gibst.
 * Statt denselben Code 10x zu schreiben, rufst du einfach die Funktion auf.
 *
 * Beispiel: json_read('settings') liest die Datei content/settings.json
 */

// Sicherstellen, dass die Konfiguration geladen ist
if (!defined('CMS_ROOT')) {
    define('CMS_ROOT', dirname(__DIR__));
    require_once CMS_ROOT . '/config/config.php';
}

// ===================================================================
// JSON-FUNKTIONEN (JSON Functions)
// JSON ist ein einfaches Format zum Speichern von Daten in Textdateien.
// Wir nutzen JSON statt einer Datenbank – einfacher zum Hosten!
// ===================================================================

/**
 * Liest eine JSON-Datei und gibt die Daten als PHP-Array zurück.
 *
 * @param string $file  Dateiname ohne .json (z.B. 'settings')
 * @param string $dir   Verzeichnis (Standard: CONTENT_DIR)
 * @return array        Die gelesenen Daten
 */
function json_read(string $file, string $dir = CONTENT_DIR): array {
    $path = $dir . '/' . $file . '.json';

    // Prüfen ob die Datei existiert
    if (!file_exists($path)) {
        return []; // Leeres Array wenn Datei nicht gefunden
    }

    // Datei lesen und JSON in PHP-Array umwandeln
    $content = file_get_contents($path);
    $data    = json_decode($content, true); // true = als Array, nicht Objekt

    // Falls JSON ungültig ist, leeres Array zurückgeben
    return is_array($data) ? $data : [];
}

/**
 * Speichert ein PHP-Array als JSON-Datei.
 *
 * @param string $file  Dateiname ohne .json
 * @param array  $data  Die zu speichernden Daten
 * @param string $dir   Verzeichnis (Standard: CONTENT_DIR)
 * @return bool         true bei Erfolg, false bei Fehler
 */
function json_write(string $file, array $data, string $dir = CONTENT_DIR): bool {
    $path = $dir . '/' . $file . '.json';

    // JSON_PRETTY_PRINT = schön formatiert (lesbar für Menschen)
    // JSON_UNESCAPED_UNICODE = Umlaute (ä,ö,ü) korrekt speichern
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    // In Datei speichern, LOCK_EX = Datei sperren während des Schreibens
    return file_put_contents($path, $json, LOCK_EX) !== false;
}

// ===================================================================
// EINSTELLUNGEN (Settings)
// ===================================================================

/**
 * Liest alle Website-Einstellungen.
 * Gibt Standard-Einstellungen zurück, falls keine Datei existiert.
 */
function get_settings(): array {
    $settings = json_read('settings');

    // Standard-Einstellungen (werden verwendet, wenn noch nichts konfiguriert wurde)
    $defaults = [
        'site_name'       => 'Meine Kunstseite',
        'site_tagline'    => 'Kunst. Design. Inspiration.',
        'site_email'      => '',
        'accent_color'    => '#c4a882',
        'bg_color'        => '#f5f0eb',
        'text_color'      => '#1a1a1a',
        'font_heading'    => 'Playfair Display',
        'font_body'       => 'Lato',
        'custom_font'     => '',       // Name der hochgeladenen Schriftart
        'custom_font_url' => '',       // Pfad zur hochgeladenen Schriftart
        'admin_password'  => password_hash('admin123', PASSWORD_DEFAULT),
        'footer_text'     => '© 2024 Meine Kunstseite',
        'social_instagram'=> '',
        'social_facebook' => '',
        'social_twitter'  => '',
    ];

    // Standard-Werte mit gespeicherten Werten zusammenführen
    // array_merge: Falls ein Wert in $settings fehlt, wird der Standard genommen
    return array_merge($defaults, $settings);
}

/**
 * Speichert die Website-Einstellungen.
 */
function save_settings(array $data): bool {
    return json_write('settings', $data);
}

// ===================================================================
// SEITENVERWALTUNG (Page Management)
// ===================================================================

/**
 * Liest den Inhalt einer bestimmten Seite.
 *
 * @param string $page  Seitenname (z.B. 'home', 'about', 'gallery')
 * @return array
 */
function get_page(string $page): array {
    $data = json_read($page, PAGES_DIR);

    // Standard-Inhalte je nach Seite
    $defaults = [
        'home'    => [
            'hero_title'    => 'Kunst beginnt dort, wo die Sprache endet.',
            'hero_subtitle' => 'Willkommen in meiner Welt der Kreativität.',
            'hero_image'    => '',
            'about_text'    => 'Hier kannst du kurz etwas über dich schreiben.',
            'show_gallery'  => true,
            'gallery_title' => 'Ausgewählte Werke',
        ],
        'about'   => [
            'title'        => 'Über mich',
            'text'         => 'Hier erzählst du von dir, deiner Kunst und deiner Vision.',
            'image'        => '',
            'cv'           => [],
        ],
        'gallery' => [
            'title'       => 'Galerie',
            'description' => 'Eine Auswahl meiner Werke.',
        ],
        'contact' => [
            'title'       => 'Kontakt',
            'text'        => 'Ich freue mich über deine Nachricht.',
            'show_form'   => true,
        ],
    ];

    $pageDefaults = $defaults[$page] ?? [];
    return array_merge($pageDefaults, $data);
}

/**
 * Speichert den Inhalt einer Seite.
 */
function save_page(string $page, array $data): bool {
    return json_write($page, $data, PAGES_DIR);
}

// ===================================================================
// GALERIE (Gallery)
// ===================================================================

/**
 * Liest alle Galeriebilder.
 */
function get_gallery(): array {
    $data = json_read('gallery');
    return $data['items'] ?? [];
}

/**
 * Speichert die Galerie.
 */
function save_gallery(array $items): bool {
    return json_write('gallery', ['items' => $items]);
}

// ===================================================================
// SICHERHEIT (Security)
// ===================================================================

/**
 * Bereinigt Benutzereingaben um XSS-Angriffe zu verhindern.
 * XSS = Cross-Site Scripting (böser JavaScript-Code in Formularen)
 *
 * IMMER verwenden bevor Benutzereingaben angezeigt werden!
 */
function escape(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * Bereinigt einen Dateinamen (entfernt gefährliche Zeichen).
 */
function sanitize_filename(string $filename): string {
    // Nur Buchstaben, Zahlen, Bindestriche, Unterstriche und Punkt erlauben
    $filename = preg_replace('/[^a-zA-Z0-9\-\_\.]/', '_', $filename);
    return $filename;
}

/**
 * Generiert eine eindeutige ID (für Galerie-Elemente etc.)
 */
function generate_id(): string {
    return uniqid('', true);
}

// ===================================================================
// DATEI-UPLOAD (File Upload)
// ===================================================================

/**
 * Verarbeitet einen Datei-Upload.
 *
 * @param array  $file     Das $_FILES['input_name'] Array
 * @param string $type     'image' oder 'font'
 * @return array           ['success' => bool, 'path' => string, 'error' => string]
 */
function handle_upload(array $file, string $type = 'image'): array {
    // Kein Fehler beim Upload?
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload-Fehler: Code ' . $file['error']];
    }

    // Dateigröße prüfen
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return ['success' => false, 'error' => 'Datei zu groß (max. 10 MB)'];
    }

    // Dateityp prüfen
    $mimeType = mime_content_type($file['tmp_name']);

    if ($type === 'image' && !in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
        return ['success' => false, 'error' => 'Nur Bilder erlaubt (JPG, PNG, GIF, WebP, SVG)'];
    }

    if ($type === 'font' && !in_array($mimeType, ALLOWED_FONT_TYPES)) {
        return ['success' => false, 'error' => 'Nur Schriftarten erlaubt (TTF, OTF, WOFF, WOFF2)'];
    }

    // Zielordner bestimmen
    $uploadDir = UPLOADS_DIR . '/' . ($type === 'font' ? 'fonts' : 'images') . '/';

    // Sicheren Dateinamen erstellen
    $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = sanitize_filename(pathinfo($file['name'], PATHINFO_FILENAME));
    $filename = $safeName . '_' . time() . '.' . $ext;
    $destPath = $uploadDir . $filename;

    // Datei in Upload-Ordner verschieben
    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        return ['success' => false, 'error' => 'Fehler beim Speichern der Datei'];
    }

    // Relativen Web-Pfad zurückgeben
    $webPath = '/assets/uploads/' . ($type === 'font' ? 'fonts' : 'images') . '/' . $filename;
    return ['success' => true, 'path' => $webPath, 'filename' => $filename];
}

// ===================================================================
// NAVIGATION (Navigation)
// ===================================================================

/**
 * Gibt die aktuelle Seite zurück (für aktiven Menüpunkt).
 */
function current_page(): string {
    $script = basename($_SERVER['SCRIPT_NAME'], '.php');
    return $script === 'index' ? 'home' : $script;
}
