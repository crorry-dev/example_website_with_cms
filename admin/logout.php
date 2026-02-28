<?php
/**
 * LOGOUT - admin/logout.php
 * ===========================
 * Loggt den Admin aus und leitet zur Login-Seite weiter.
 */

define('CMS_ROOT', dirname(__DIR__));
require_once CMS_ROOT . '/config/config.php';
require_once CMS_ROOT . '/includes/functions.php';
require_once CMS_ROOT . '/includes/auth.php';

logout();

// Zurück zur Login-Seite
header('Location: /admin/index.php');
exit;
