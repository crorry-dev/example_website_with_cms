<?php
/**
 * UPLOAD-HANDLER - admin/upload.php
 * =====================================
 * Verarbeitet Datei-Uploads (Bilder und Schriftarten).
 * Wird per AJAX von admin.js aufgerufen.
 *
 * Gibt immer JSON zurück:
 * - Erfolg: {"success": true, "path": "/assets/uploads/images/bild.jpg"}
 * - Fehler:  {"success": false, "error": "Fehlermeldung"}
 *
 * Sicherheitsprüfungen:
 * 1. Nur eingeloggte Admins dürfen hochladen
 * 2. Nur erlaubte Dateitypen
 * 3. Maximale Dateigröße
 * 4. Sicherer Dateiname (keine gefährlichen Zeichen)
 */

define('CMS_ROOT', dirname(__DIR__));
require_once CMS_ROOT . '/config/config.php';
require_once CMS_ROOT . '/includes/functions.php';
require_once CMS_ROOT . '/includes/auth.php';

// Immer JSON antworten
header('Content-Type: application/json');

// Nur eingeloggte Admins!
if (!is_logged_in()) {
    http_response_code(403); // 403 = Verboten
    echo json_encode(['success' => false, 'error' => 'Nicht eingeloggt']);
    exit;
}

// Nur POST-Requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // 405 = Methode nicht erlaubt
    echo json_encode(['success' => false, 'error' => 'Nur POST erlaubt']);
    exit;
}

// Datei vorhanden?
if (empty($_FILES['file'])) {
    echo json_encode(['success' => false, 'error' => 'Keine Datei empfangen']);
    exit;
}

$type    = $_POST['type'] ?? 'image';   // 'image' oder 'font'
$page    = $_POST['page'] ?? '';        // Welche Seite (für Seitenbilder)
$field   = $_POST['field'] ?? '';       // Welches Feld (für Seitenbilder)
$toGallery = !empty($_POST['gallery']); // Zur Galerie hinzufügen?

// Upload verarbeiten
$result = handle_upload($_FILES['file'], $type);

if (!$result['success']) {
    echo json_encode($result);
    exit;
}

$filePath = $result['path'];

// ——————————————————————————————————————
// Wenn Bild zu einer Seite gehört (z.B. Hero-Bild, About-Foto)
// ——————————————————————————————————————
if (!empty($page) && !empty($field) && $type === 'image') {
    $pageData = get_page($page);
    $pageData[$field] = $filePath;
    save_page($page, $pageData);
}

// ——————————————————————————————————————
// Wenn Bild zur Galerie hinzugefügt werden soll
// ——————————————————————————————————————
if ($toGallery && $type === 'image') {
    $gallery = get_gallery();

    // Dateiname als Starttitel verwenden
    $rawName = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
    // Unterstriche und Bindestriche durch Leerzeichen ersetzen
    $title = str_replace(['_', '-'], ' ', $rawName);
    $title = ucfirst($title);

    $gallery[] = [
        'id'          => generate_id(),
        'title'       => $title,
        'medium'      => '',
        'description' => '',
        'image'       => $filePath,
        'uploaded'    => date('Y-m-d H:i:s'),
    ];

    save_gallery($gallery);
}

// ——————————————————————————————————————
// Wenn eigene Schriftart hochgeladen wurde
// ——————————————————————————————————————
if ($type === 'font') {
    $fontName = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
    // Bindestriche und Unterstriche durch Leerzeichen für lesbaren Namen
    $fontName = str_replace(['-', '_'], ' ', $fontName);
    $fontName = ucwords($fontName);

    // Schriftart in den Einstellungen speichern
    $settings = get_settings();
    $settings['custom_font']     = $fontName;
    $settings['custom_font_url'] = $filePath;
    save_settings($settings);
}

echo json_encode(['success' => true, 'path' => $filePath]);
