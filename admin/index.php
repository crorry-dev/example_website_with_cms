<?php
/**
 * ADMIN LOGIN - admin/index.php
 * ================================
 * Die Login-Seite für den Administrationsbereich.
 *
 * Standard-Zugangsdaten:
 * - Benutzername: admin
 * - Passwort: admin123
 *
 * ⚠️ WICHTIG: Ändere das Passwort nach dem ersten Login!
 *    Gehe zu Einstellungen → Passwort ändern
 */

define('CMS_ROOT', dirname(__DIR__));
require_once CMS_ROOT . '/config/config.php';
require_once CMS_ROOT . '/includes/functions.php';
require_once CMS_ROOT . '/includes/auth.php';

start_session();

// Wenn bereits eingeloggt: zum Dashboard weiterleiten
if (is_logged_in()) {
    header('Location: /admin/dashboard.php');
    exit;
}

$error = '';

// Login-Formular wurde abgesendet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Rate-Limiting: Maximale Login-Versuche pro IP-Adresse
    // Verhindert Brute-Force-Angriffe durch viele schnelle Versuche
    $ip          = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $rateLimitFile = sys_get_temp_dir() . '/cms_login_' . md5($ip) . '.json';
    $now         = time();
    $maxAttempts = 5;
    $lockoutTime = 300; // 5 Minuten Sperre nach zu vielen Fehlversuchen

    // Aktuelle Versuche laden
    $attempts = [];
    if (file_exists($rateLimitFile)) {
        $data     = json_decode(file_get_contents($rateLimitFile), true);
        $attempts = is_array($data) ? $data : [];
    }

    // Versuche der letzten 5 Minuten filtern
    $recentAttempts = array_filter($attempts, fn($t) => ($now - $t) < $lockoutTime);

    if (count($recentAttempts) >= $maxAttempts) {
        $error = 'Zu viele Fehlversuche. Bitte warte 5 Minuten.';
    } elseif (login($username, $password)) {
        // Erfolg: Rate-Limit-Datei löschen und weiterleiten
        if (file_exists($rateLimitFile)) unlink($rateLimitFile);
        $redirect = $_SESSION['redirect_after_login'] ?? '/admin/dashboard.php';
        unset($_SESSION['redirect_after_login']);
        header('Location: ' . $redirect);
        exit;
    } else {
        $error = 'Benutzername oder Passwort falsch.';
        // Fehlversuch registrieren
        $recentAttempts[] = $now;
        file_put_contents($rateLimitFile, json_encode(array_values($recentAttempts)));
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <!-- Suchmaschinen sollen Login-Seite nicht indexieren -->
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<div class="login-page">
    <div class="login-box">

        <!-- Logo/Titel -->
        <h1 class="login-box__title">CMS Admin</h1>
        <p class="login-box__sub">Melde dich an um deine Website zu bearbeiten</p>

        <!-- Fehlermeldung -->
        <?php if ($error): ?>
        <div class="alert alert--error" style="margin-bottom: 1.5rem">
            ✗ <?= escape($error) ?>
        </div>
        <?php endif; ?>

        <!-- LOGIN-FORMULAR -->
        <form method="post" action="/admin/index.php">

            <div class="form-group">
                <label for="username">Benutzername</label>
                <input type="text"
                       id="username"
                       name="username"
                       value="<?= escape($_POST['username'] ?? '') ?>"
                       autocomplete="username"
                       autofocus
                       required
                       placeholder="admin">
            </div>

            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password"
                       id="password"
                       name="password"
                       autocomplete="current-password"
                       required
                       placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn--primary btn--block btn--lg" style="margin-top: 0.5rem">
                Anmelden
            </button>

        </form>

        <!-- Info-Box -->
        <div style="margin-top: 2rem; padding: 1rem; background: rgba(255,255,255,0.04); border-radius: 6px; font-size: 0.8rem; color: var(--admin-muted); line-height: 1.6">
            <strong style="color: rgba(255,255,255,0.6)">Standard-Zugangsdaten:</strong><br>
            Benutzer: <code>admin</code><br>
            Passwort: <code>admin123</code>
        </div>

        <!-- Link zurück zur Website -->
        <div style="text-align: center; margin-top: 1.5rem">
            <a href="/" style="font-size: 0.8rem; color: var(--admin-muted)">← Zurück zur Website</a>
        </div>

    </div>
</div>

</body>
</html>
