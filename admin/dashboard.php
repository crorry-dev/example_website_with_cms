<?php
/**
 * ADMIN DASHBOARD - admin/dashboard.php
 * ========================================
 * Die Übersichtsseite des Admin-Bereichs.
 * Zeigt einen schnellen Überblick: Galerie-Bilder, Links zu den Bereichen.
 */

define('CMS_ROOT', dirname(__DIR__));
require_once CMS_ROOT . '/config/config.php';
require_once CMS_ROOT . '/includes/functions.php';
require_once CMS_ROOT . '/includes/auth.php';

// Login prüfen – wer nicht eingeloggt ist, wird zum Login weitergeleitet
require_login();

$settings = get_settings();
$gallery  = get_gallery();

// Datum und Zeit
$now = new DateTime('now', new DateTimeZone('Europe/Berlin'));
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – CMS Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<div class="admin-layout">

    <!-- SIDEBAR (Seitenleiste) -->
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <!-- HAUPTINHALT -->
    <main class="admin-main">

        <!-- Topbar -->
        <div class="admin-topbar">
            <h2 class="admin-topbar__title">Dashboard</h2>
            <div class="admin-topbar__actions">
                <span style="font-size: 0.8rem; color: var(--admin-muted)">
                    <?= $now->format('d.m.Y, H:i') ?> Uhr
                </span>
                <a href="/" target="_blank" class="btn btn--secondary btn--sm">
                    🌐 Website ansehen
                </a>
                <a href="/admin/logout.php" class="btn btn--secondary btn--sm">
                    Abmelden
                </a>
            </div>
        </div>

        <!-- Willkommens-Nachricht -->
        <div class="alert alert--info" style="margin-bottom: 2rem">
            👋 Willkommen zurück! Du bearbeitest die Website <strong><?= escape($settings['site_name']) ?></strong>.
        </div>

        <!-- STATISTIK-KARTEN -->
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-card__icon">🖼️</span>
                <span class="stat-card__number"><?= count($gallery) ?></span>
                <span class="stat-card__label">Galerie-Bilder</span>
            </div>
            <div class="stat-card">
                <span class="stat-card__icon">📄</span>
                <span class="stat-card__number">4</span>
                <span class="stat-card__label">Seiten</span>
            </div>
            <div class="stat-card">
                <span class="stat-card__icon">🎨</span>
                <span class="stat-card__number"><?= escape(substr($settings['accent_color'], 0, 7)) ?></span>
                <span class="stat-card__label">Akzentfarbe</span>
            </div>
        </div>

        <!-- SCHNELLZUGRIFF -->
        <div class="card">
            <div class="card__header">
                <h3 class="card__title">Schnellzugriff</h3>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem">

                <!-- Kachel: Seiten bearbeiten -->
                <a href="/admin/pages.php" style="
                    display: block; padding: 1.5rem;
                    background: rgba(255,255,255,0.04);
                    border: 1px solid var(--admin-border);
                    border-radius: 6px; text-decoration: none;
                    color: white; transition: all 0.2s;
                " onmouseover="this.style.borderColor='var(--admin-accent)'"
                   onmouseout="this.style.borderColor='var(--admin-border)'">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem">📝</div>
                    <div style="font-weight: 600">Seiten bearbeiten</div>
                    <div style="font-size: 0.82rem; color: var(--admin-muted); margin-top: 0.25rem">
                        Start, Galerie, Über mich, Kontakt
                    </div>
                </a>

                <!-- Kachel: Galerie -->
                <a href="/admin/gallery.php" style="
                    display: block; padding: 1.5rem;
                    background: rgba(255,255,255,0.04);
                    border: 1px solid var(--admin-border);
                    border-radius: 6px; text-decoration: none;
                    color: white; transition: all 0.2s;
                " onmouseover="this.style.borderColor='var(--admin-accent)'"
                   onmouseout="this.style.borderColor='var(--admin-border)'">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem">🖼️</div>
                    <div style="font-weight: 600">Galerie verwalten</div>
                    <div style="font-size: 0.82rem; color: var(--admin-muted); margin-top: 0.25rem">
                        Bilder hochladen & sortieren
                    </div>
                </a>

                <!-- Kachel: Einstellungen -->
                <a href="/admin/settings.php" style="
                    display: block; padding: 1.5rem;
                    background: rgba(255,255,255,0.04);
                    border: 1px solid var(--admin-border);
                    border-radius: 6px; text-decoration: none;
                    color: white; transition: all 0.2s;
                " onmouseover="this.style.borderColor='var(--admin-accent)'"
                   onmouseout="this.style.borderColor='var(--admin-border)'">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem">⚙️</div>
                    <div style="font-weight: 600">Einstellungen</div>
                    <div style="font-size: 0.82rem; color: var(--admin-muted); margin-top: 0.25rem">
                        Farben, Schriften, Social Media
                    </div>
                </a>

            </div>
        </div>

        <!-- ERSTE SCHRITTE / HILFE -->
        <div class="card">
            <div class="card__header">
                <h3 class="card__title">🚀 Erste Schritte</h3>
            </div>
            <div style="font-size: 0.9rem; line-height: 1.8; color: var(--admin-muted)">
                <ol style="padding-left: 1.5rem; list-style: decimal">
                    <li style="margin-bottom: 0.5rem">
                        <a href="/admin/settings.php">Einstellungen</a> öffnen und
                        Seitenname, E-Mail und Farben anpassen
                    </li>
                    <li style="margin-bottom: 0.5rem">
                        <strong style="color: white">Passwort ändern!</strong>
                        Das Standard-Passwort ist nicht sicher.
                    </li>
                    <li style="margin-bottom: 0.5rem">
                        <a href="/admin/gallery.php">Galerie</a> öffnen und
                        deine ersten Kunstwerke hochladen
                    </li>
                    <li style="margin-bottom: 0.5rem">
                        <a href="/admin/pages.php">Seiten bearbeiten</a> –
                        Texte und Bilder für deine Seiten anpassen
                    </li>
                    <li>
                        <a href="/" target="_blank">Website ansehen</a> und
                        das Ergebnis bewundern! 🎉
                    </li>
                </ol>
            </div>
        </div>

    </main>
</div>

<script src="/assets/js/admin.js"></script>
</body>
</html>
