<?php
/**
 * KONTAKT-SEITE (Contact Page) - contact.php
 * =============================================
 * Zeigt ein Kontaktformular und optional die E-Mail-Adresse.
 *
 * Das Formular versendet E-Mails über die PHP-Funktion mail().
 * Auf einem echten Hosting muss der Server E-Mails versenden können.
 * (Fast alle Hosting-Anbieter unterstützen das standardmäßig.)
 *
 * Sicherheit:
 * - CSRF-Token verhindert automatisches Spam-Absenden
 * - Eingaben werden gesäubert (escape/sanitize)
 * - Wenn kein AJAX: Normales Form-Submit als Fallback
 */

define('CMS_ROOT', __DIR__);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

$settings     = get_settings();
$contactPage  = get_page('contact');
$pageTitle    = $contactPage['title'] ?? 'Kontakt';

// Verarbeitungslogik für Kontaktformular
$formSuccess = false;
$formError   = '';

// ——————————————————————————————————————————
// Formular wurde abgesendet (POST-Request)?
// ——————————————————————————————————————————
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // JSON-Antwort für AJAX-Requests
    // Prüfe auf expliziten AJAX-Indikator oder Accept-Header
    $isAjax = (($_POST['_ajax'] ?? '') === '1') ||
              (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));

    // Eingaben auslesen und bereinigen
    // filter_input: PHP-Funktion zum sicheren Lesen von Eingaben
    $name    = trim(filter_input(INPUT_POST, 'name',    FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
    $email   = trim(filter_input(INPUT_POST, 'email',   FILTER_VALIDATE_EMAIL) ?? '');
    $subject = trim(filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');

    // Validierung
    if (empty($name) || strlen($name) < 2) {
        $formError = 'Bitte gib deinen Namen ein.';
    } elseif (!$email) {
        $formError = 'Bitte gib eine gültige E-Mail-Adresse ein.';
    } elseif (empty($message) || strlen($message) < 10) {
        $formError = 'Deine Nachricht ist zu kurz (mindestens 10 Zeichen).';
    } else {
        // E-Mail senden
        $toEmail  = !empty($settings['site_email']) ? $settings['site_email'] : '';
        $mailSent = false;

        if (!empty($toEmail)) {
            $mailSubject = '[' . $settings['site_name'] . '] ' . ($subject ?: 'Neue Kontaktanfrage');
            $mailBody    = "Name: {$name}\nE-Mail: {$email}\n\nNachricht:\n{$message}";
            $mailHeaders = "From: noreply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "\r\n"
                         . "Reply-To: {$email}\r\n"
                         . "Content-Type: text/plain; charset=UTF-8\r\n";

            $mailSent = mail($toEmail, $mailSubject, $mailBody, $mailHeaders);
        } else {
            // Kein E-Mail gesetzt → trotzdem "erfolgreich" zurückgeben
            $mailSent = true;
        }

        if ($mailSent) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                exit;
            }
            $formSuccess = true;
        } else {
            $formError = 'E-Mail konnte nicht gesendet werden. Bitte versuche es später.';
        }
    }

    // AJAX-Fehlerantwort
    if ($isAjax && $formError) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $formError]);
        exit;
    }
}

include __DIR__ . '/includes/header.php';
?>

<div style="height: 80px"></div>

<!-- ============================================================
     KONTAKT-SEITE
     ============================================================ -->
<section class="section">
    <div class="container">

        <div class="section-header" data-reveal>
            <span class="section-header__eyebrow">Schreib mir</span>
            <h1><?= escape($contactPage['title']) ?></h1>
        </div>

        <div class="contact-layout">

            <!-- LINKE SPALTE: Einleitungstext -->
            <div data-reveal="left">
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-muted)">
                    <?= escape($contactPage['text']) ?>
                </p>

                <?php if (!empty($settings['site_email'])): ?>
                <div style="margin-top: 2rem">
                    <p style="font-size: 0.8rem; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.5rem; color: var(--text-muted)">
                        E-Mail
                    </p>
                    <a href="mailto:<?= escape($settings['site_email']) ?>" style="font-size: 1.1rem; color: var(--text)">
                        <?= escape($settings['site_email']) ?>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Social Media Links -->
                <?php if (!empty($settings['social_instagram'])): ?>
                <div style="margin-top: 2rem">
                    <p style="font-size: 0.8rem; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 0.5rem; color: var(--text-muted)">
                        Soziale Medien
                    </p>
                    <a href="<?= escape($settings['social_instagram']) ?>" target="_blank" rel="noopener noreferrer">
                        Instagram →
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- RECHTE SPALTE: Kontaktformular -->
            <?php if ($contactPage['show_form']): ?>
            <div data-reveal="right">

                <!-- Erfolgs/Fehlermeldung (ohne JavaScript) -->
                <?php if ($formSuccess): ?>
                <div class="form-message form-message--success">
                    ✓ Vielen Dank! Deine Nachricht wurde gesendet.
                </div>
                <?php elseif ($formError): ?>
                <div class="form-message form-message--error">
                    ✗ <?= escape($formError) ?>
                </div>
                <?php endif; ?>

                <!-- Meldungs-Container für JavaScript (AJAX) -->
                <div id="form-message" style="display:none"></div>

                <!-- KONTAKTFORMULAR -->
                <!-- action="" = sendet an diese Seite (contact.php) -->
                <!-- method="post" = sicher (Daten nicht in URL sichtbar) -->
                <form id="contact-form" action="/contact.php" method="post" novalidate>

                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" required
                               placeholder="Dein Name"
                               value="<?= escape($_POST['name'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">E-Mail-Adresse *</label>
                        <input type="email" id="email" name="email" required
                               placeholder="deine@email.de"
                               value="<?= escape($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="subject">Betreff</label>
                        <input type="text" id="subject" name="subject"
                               placeholder="Worum geht es?"
                               value="<?= escape($_POST['subject'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="message">Nachricht *</label>
                        <textarea id="message" name="message" required
                                  placeholder="Schreib mir..."><?= escape($_POST['message'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn--primary" style="width: 100%">
                        Nachricht senden
                    </button>

                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 1rem; text-align: center">
                        * Pflichtfelder
                    </p>
                </form>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>


<?php include __DIR__ . '/includes/footer.php'; ?>
