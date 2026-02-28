<?php
/**
 * SPEICHER-HANDLER - admin/save.php
 * =====================================
 * Verarbeitet alle Speicher-Anfragen aus dem Admin-Bereich.
 * Wird per AJAX von admin.js aufgerufen.
 *
 * Mögliche Aktionen (action Parameter):
 * - 'settings'        → Website-Einstellungen speichern
 * - 'page'            → Seiten-Inhalt speichern
 * - 'change_password' → Passwort ändern
 */

define('CMS_ROOT', dirname(__DIR__));
require_once CMS_ROOT . '/config/config.php';
require_once CMS_ROOT . '/includes/functions.php';
require_once CMS_ROOT . '/includes/auth.php';

// Immer JSON zurückgeben
header('Content-Type: application/json');

// Authentifizierung
if (!is_logged_in()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Nicht eingeloggt']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Nur POST erlaubt']);
    exit;
}

$action = $_POST['action'] ?? '';

// ================================================================
// EINSTELLUNGEN SPEICHERN
// ================================================================
if ($action === 'settings') {
    $settings = get_settings(); // Aktuelle Einstellungen laden

    // Erlaubte Felder (Whitelist) – nur diese werden gespeichert
    // Warum Whitelist? Sicherheit: Verhindert dass unbekannte Felder gespeichert werden
    $allowedFields = [
        'site_name', 'site_tagline', 'site_email', 'footer_text',
        'accent_color', 'bg_color', 'text_color',
        'font_heading', 'font_body',
        'social_instagram', 'social_facebook', 'social_twitter',
    ];

    foreach ($allowedFields as $field) {
        if (isset($_POST[$field])) {
            $value = trim($_POST[$field]);

            // Farben validieren: Muss mit # anfangen und 6 Hex-Zeichen haben
            if (in_array($field, ['accent_color', 'bg_color', 'text_color'])) {
                if (!preg_match('/^#[0-9A-Fa-f]{3,6}$/', $value)) {
                    continue; // Ungültige Farbe überspringen
                }
            }

            $settings[$field] = $value;
        }
    }

    echo json_encode(['success' => save_settings($settings)]);
    exit;
}

// ================================================================
// SEITEN-INHALT SPEICHERN
// ================================================================
if ($action === 'page') {
    $page = $_POST['page'] ?? '';

    // Erlaubte Seiten-Namen
    $allowedPages = ['home', 'about', 'gallery', 'contact'];
    if (!in_array($page, $allowedPages)) {
        echo json_encode(['success' => false, 'error' => 'Ungültige Seite']);
        exit;
    }

    $pageData = get_page($page);

    // Je nach Seite unterschiedliche Felder erlauben
    switch ($page) {
        case 'home':
            $fields = ['hero_title', 'hero_subtitle', 'hero_image', 'about_text', 'gallery_title'];
            foreach ($fields as $f) {
                if (isset($_POST[$f])) {
                    $pageData[$f] = trim($_POST[$f]);
                }
            }
            $pageData['show_gallery'] = !empty($_POST['show_gallery']);
            break;

        case 'about':
            if (isset($_POST['title']))  $pageData['title'] = trim($_POST['title']);
            if (isset($_POST['image']))  $pageData['image'] = trim($_POST['image']);

            // HTML-Text: nur safe HTML erlauben
            // (Der Text kommt aus dem Rich-Editor und kann HTML enthalten)
            if (isset($_POST['text'])) {
                $pageData['text'] = strip_tags($_POST['text'], '<p><br><strong><em><ul><li><h2><h3>');
            }

            // CV als JSON-Array verarbeiten
            if (isset($_POST['cv'])) {
                $cvJson = trim($_POST['cv']);
                $cvData = json_decode($cvJson, true);
                if (is_array($cvData)) {
                    // Jeden Eintrag bereinigen
                    $pageData['cv'] = array_map(function($entry) {
                        return [
                            'year' => strip_tags($entry['year'] ?? ''),
                            'text' => strip_tags($entry['text'] ?? ''),
                        ];
                    }, $cvData);
                }
            }
            break;

        case 'gallery':
            if (isset($_POST['title']))       $pageData['title'] = trim($_POST['title']);
            if (isset($_POST['description'])) $pageData['description'] = trim($_POST['description']);
            break;

        case 'contact':
            if (isset($_POST['title'])) $pageData['title'] = trim($_POST['title']);
            if (isset($_POST['text']))  $pageData['text']  = trim($_POST['text']);
            $pageData['show_form'] = !empty($_POST['show_form']);
            break;
    }

    echo json_encode(['success' => save_page($page, $pageData)]);
    exit;
}

// ================================================================
// PASSWORT ÄNDERN
// ================================================================
if ($action === 'change_password') {
    $newPassword = $_POST['new_password'] ?? '';

    if (strlen($newPassword) < 6) {
        echo json_encode(['success' => false, 'error' => 'Passwort zu kurz (min. 6 Zeichen)']);
        exit;
    }

    echo json_encode(['success' => change_password($newPassword)]);
    exit;
}

// Unbekannte Aktion
echo json_encode(['success' => false, 'error' => 'Unbekannte Aktion: ' . escape($action)]);
