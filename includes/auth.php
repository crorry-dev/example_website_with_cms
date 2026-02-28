<?php
/**
 * AUTHENTIFIZIERUNG (Authentication)
 * =====================================
 * Diese Datei kümmert sich darum, wer ins Admin-Bereich darf.
 *
 * "Authentifizierung" = Überprüfen ob jemand wirklich der ist, der er vorgibt zu sein.
 * Das passiert hier über Benutzername + Passwort.
 *
 * Wie funktioniert das?
 * 1. Benutzer gibt Passwort ein
 * 2. PHP vergleicht es mit dem gespeicherten (verschlüsselten) Passwort
 * 3. Bei Erfolg: Session wird gesetzt ("eingeloggt")
 * 4. Bei jedem Admin-Aufruf: Session wird geprüft
 */

if (!defined('CMS_ROOT')) {
    define('CMS_ROOT', dirname(__DIR__));
    require_once CMS_ROOT . '/config/config.php';
}
require_once CMS_ROOT . '/includes/functions.php';

/**
 * Startet die PHP-Session falls noch nicht gestartet.
 * Eine Session merkt sich Informationen zwischen Seitenaufrufen.
 */
function start_session(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Prüft ob der Admin eingeloggt ist.
 * Gibt true zurück wenn eingeloggt, sonst false.
 */
function is_logged_in(): bool {
    start_session();
    return isset($_SESSION['cms_admin']) && $_SESSION['cms_admin'] === true;
}

/**
 * Leitet zum Login weiter falls nicht eingeloggt.
 * Diese Funktion wird am Anfang jeder Admin-Seite aufgerufen.
 *
 * "require_login()" schützt Admin-Seiten vor unerlaubtem Zugriff.
 */
function require_login(): void {
    if (!is_logged_in()) {
        // Merken welche Seite aufgerufen wurde (für Weiterleitung nach Login)
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: /admin/index.php');
        exit; // WICHTIG: exit nach header() damit kein Code mehr ausgeführt wird
    }
}

/**
 * Versucht den Admin einzuloggen.
 *
 * @param string $username  Eingegebener Benutzername
 * @param string $password  Eingegebenes Passwort (unverschlüsselt)
 * @return bool             true bei Erfolg
 */
function login(string $username, string $password): bool {
    start_session();

    $settings = get_settings();

    // Benutzername prüfen (case-sensitive)
    if ($username !== ADMIN_USER) {
        return false;
    }

    // Passwort prüfen: password_verify vergleicht Passwort mit verschlüsseltem Hash
    // Niemals Passwörter im Klartext speichern!
    if (password_verify($password, $settings['admin_password'])) {
        $_SESSION['cms_admin'] = true;

        // Session-ID erneuern (verhindert Session-Fixation-Angriffe)
        session_regenerate_id(true);
        return true;
    }

    return false;
}

/**
 * Loggt den Admin aus.
 */
function logout(): void {
    start_session();

    // Session-Daten löschen
    $_SESSION = [];

    // Session-Cookie löschen
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }

    // Session zerstören
    session_destroy();
}

/**
 * Ändert das Admin-Passwort.
 *
 * @param string $newPassword  Neues Passwort (mindestens 6 Zeichen)
 * @return bool
 */
function change_password(string $newPassword): bool {
    if (strlen($newPassword) < 6) {
        return false;
    }

    $settings = get_settings();
    // Passwort mit PHP's sicherem Hash-Algorithmus verschlüsseln
    $settings['admin_password'] = password_hash($newPassword, PASSWORD_DEFAULT);
    return save_settings($settings);
}
