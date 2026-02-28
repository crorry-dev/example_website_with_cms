<?php
/**
 * KONFIGURATIONSDATEI (Configuration File)
 * ==========================================
 * Diese Datei enthält alle globalen Einstellungen des CMS.
 * "Konfiguration" bedeutet: hier werden grundlegende Regeln für das ganze System festgelegt.
 *
 * Warum eine separate Konfigurationsdatei?
 * → Damit alle Einstellungen an einem Ort sind und leicht geändert werden können,
 *   ohne den Rest des Codes anfassen zu müssen.
 */

// Verhindere direkten Aufruf dieser Datei über den Browser
// (Diese Datei soll nur von anderen PHP-Dateien eingebunden werden)
if (!defined('CMS_ROOT')) {
    define('CMS_ROOT', dirname(__DIR__)); // Pfad zum Hauptverzeichnis
}

// -------------------------------------------------------------------
// PFADE (Paths)
// Hier werden die wichtigsten Ordnerpfade als Konstanten definiert.
// Eine "Konstante" (define) ist ein Wert, der sich nie ändert.
// -------------------------------------------------------------------
define('CONTENT_DIR',  CMS_ROOT . '/content');          // Wo die Inhalte gespeichert werden
define('UPLOADS_DIR',  CMS_ROOT . '/assets/uploads');   // Wo hochgeladene Dateien landen
define('PAGES_DIR',    CONTENT_DIR . '/pages');         // Unterordner für Seiteninhalt

// -------------------------------------------------------------------
// SICHERHEIT (Security)
// Der Session-Name wird geändert damit das CMS schwerer zu erraten ist.
// Eine "Session" merkt sich, ob jemand eingeloggt ist.
// -------------------------------------------------------------------
define('SESSION_NAME', 'cms_session');
define('ADMIN_USER',   'admin');   // Standard-Benutzername

// -------------------------------------------------------------------
// ERLAUBTE DATEITYPEN (Allowed File Types)
// Aus Sicherheitsgründen dürfen nur bestimmte Dateitypen hochgeladen werden.
// -------------------------------------------------------------------
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml']);
define('ALLOWED_FONT_TYPES',  ['font/ttf', 'font/otf', 'font/woff', 'font/woff2',
                                'application/font-woff', 'application/font-woff2',
                                'application/octet-stream']); // Schriftarten

define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10 MB maximale Dateigröße

// -------------------------------------------------------------------
// PHP EINSTELLUNGEN (PHP Settings)
// -------------------------------------------------------------------
session_name(SESSION_NAME);

// Fehleranzeige: Automatisch basierend auf Umgebung (ENVIRONMENT-Konstante).
// Setze ENVIRONMENT='production' in deiner Serverkonfiguration, um Fehler
// in der Produktion auszublenden. Standardmäßig ist Entwicklungsmodus aktiv.
$isProduction = (getenv('ENVIRONMENT') === 'production');
ini_set('display_errors', $isProduction ? 0 : 1);
ini_set('log_errors', 1);
error_reporting($isProduction ? 0 : E_ALL);

// Zeitzone setzen (wichtig für Datum/Uhrzeit)
date_default_timezone_set('Europe/Berlin');
