<?php
/**
 * ADMIN SIDEBAR (Seitenleiste)
 * ==============================
 * Wird auf allen Admin-Seiten eingebunden.
 * Enthält das Logo und die Navigationslinks.
 */

// Aktuelle Seite ermitteln für aktiven Menüpunkt
$currentAdminPage = basename($_SERVER['SCRIPT_NAME'], '.php');
?>
<aside class="admin-sidebar" id="adminSidebar">

    <!-- BRAND/LOGO -->
    <div class="admin-brand">
        <a href="/admin/dashboard.php" style="text-decoration: none">
            <span class="admin-brand__name">
                <?= escape($settings['site_name'] ?? 'CMS Admin') ?>
            </span>
            <span class="admin-brand__sub">Content Manager</span>
        </a>
    </div>

    <!-- NAVIGATION -->
    <nav aria-label="Admin Navigation">

        <!-- Hauptbereich -->
        <p class="admin-nav__section-title">Übersicht</p>
        <ul>
            <li class="admin-nav__item <?= $currentAdminPage === 'dashboard' ? 'is-active' : '' ?>">
                <a href="/admin/dashboard.php">
                    <span class="admin-nav__icon">🏠</span>
                    Dashboard
                </a>
            </li>
        </ul>

        <!-- Inhalt -->
        <p class="admin-nav__section-title">Inhalt</p>
        <ul>
            <li class="admin-nav__item <?= $currentAdminPage === 'pages' ? 'is-active' : '' ?>">
                <a href="/admin/pages.php">
                    <span class="admin-nav__icon">📝</span>
                    Seiten bearbeiten
                </a>
            </li>
            <li class="admin-nav__item <?= $currentAdminPage === 'gallery' ? 'is-active' : '' ?>">
                <a href="/admin/gallery.php">
                    <span class="admin-nav__icon">🖼️</span>
                    Galerie
                </a>
            </li>
        </ul>

        <!-- Konfiguration -->
        <p class="admin-nav__section-title">Konfiguration</p>
        <ul>
            <li class="admin-nav__item <?= $currentAdminPage === 'settings' ? 'is-active' : '' ?>">
                <a href="/admin/settings.php">
                    <span class="admin-nav__icon">⚙️</span>
                    Einstellungen
                </a>
            </li>
        </ul>

        <!-- Aktionen -->
        <p class="admin-nav__section-title">Aktionen</p>
        <ul>
            <li class="admin-nav__item">
                <a href="/" target="_blank">
                    <span class="admin-nav__icon">🌐</span>
                    Website ansehen
                </a>
            </li>
            <li class="admin-nav__item">
                <a href="/admin/logout.php">
                    <span class="admin-nav__icon">🚪</span>
                    Abmelden
                </a>
            </li>
        </ul>

    </nav>

    <!-- Version Info unten -->
    <div style="position: absolute; bottom: 1rem; left: 1.5rem; font-size: 0.72rem; color: var(--admin-muted)">
        CMS v1.0 · Kunst & Design
    </div>

</aside>
