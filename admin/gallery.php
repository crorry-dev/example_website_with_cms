<?php
/**
 * GALERIE VERWALTUNG - admin/gallery.php
 * ========================================
 * Hier können Bilder hochgeladen, bearbeitet und gelöscht werden.
 * Unterstützt:
 * - Drag & Drop Upload
 * - Drag & Drop Sortierung
 * - Bild-Titel und Beschreibung bearbeiten
 * - Bilder löschen
 *
 * Die Galerie-Daten werden in content/gallery.json gespeichert.
 */

define('CMS_ROOT', dirname(__DIR__));
require_once CMS_ROOT . '/config/config.php';
require_once CMS_ROOT . '/includes/functions.php';
require_once CMS_ROOT . '/includes/auth.php';

require_login();

// POST-Requests verarbeiten (AJAX von admin.js)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $action = $_POST['action'] ?? '';

    // Galerie neu sortieren
    if ($action === 'reorder') {
        $ids     = json_decode($_POST['ids'] ?? '[]', true);
        $gallery = get_gallery();

        // Galerie nach neuer Reihenfolge sortieren
        $indexed = [];
        foreach ($gallery as $item) {
            $indexed[$item['id']] = $item;
        }

        $sorted = [];
        foreach ($ids as $id) {
            if (isset($indexed[$id])) {
                $sorted[] = $indexed[$id];
            }
        }

        echo json_encode(['success' => save_gallery($sorted)]);
        exit;
    }

    // Bild löschen
    if ($action === 'delete') {
        $id      = $_POST['id'] ?? '';
        $gallery = get_gallery();

        $toDelete = null;
        $newGallery = [];
        foreach ($gallery as $item) {
            if ($item['id'] === $id) {
                $toDelete = $item;
            } else {
                $newGallery[] = $item;
            }
        }

        // Datei vom Server löschen (wenn es kein externer Link ist)
        if ($toDelete && !empty($toDelete['image']) && str_starts_with($toDelete['image'], '/assets/uploads/')) {
            $filePath = CMS_ROOT . $toDelete['image'];
            if (file_exists($filePath)) {
                unlink($filePath); // PHP-Funktion zum Löschen einer Datei
            }
        }

        echo json_encode(['success' => save_gallery($newGallery)]);
        exit;
    }

    // Bild-Metadaten aktualisieren (Titel, Medium, Beschreibung)
    if ($action === 'update') {
        $id      = $_POST['id'] ?? '';
        $gallery = get_gallery();

        foreach ($gallery as &$item) {
            if ($item['id'] === $id) {
                $item['title']       = trim($_POST['title'] ?? '');
                $item['medium']      = trim($_POST['medium'] ?? '');
                $item['description'] = trim($_POST['description'] ?? '');
                break;
            }
        }
        unset($item); // Referenz aufheben (wichtig nach foreach mit &)

        echo json_encode(['success' => save_gallery($gallery)]);
        exit;
    }

    echo json_encode(['success' => false, 'error' => 'Unbekannte Aktion']);
    exit;
}

$settings = get_settings();
$gallery  = get_gallery();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie – CMS Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <main class="admin-main">

        <div class="admin-topbar">
            <h2 class="admin-topbar__title">Galerie</h2>
            <div class="admin-topbar__actions">
                <a href="/gallery.php" target="_blank" class="btn btn--secondary btn--sm">🌐 Galerie ansehen</a>
            </div>
        </div>

        <!-- INFO -->
        <div class="alert alert--info" style="margin-bottom: 1.5rem">
            💡 <strong>Tipp:</strong> Du kannst Bilder per Drag & Drop in die gewünschte Reihenfolge ziehen.
            Klicke auf ein Bild um Titel und Beschreibung zu bearbeiten.
        </div>

        <!-- ============================================================
             UPLOAD-BEREICH
             ============================================================ -->
        <div class="card" data-upload-section>
            <div class="card__header">
                <h3 class="card__title">📤 Neues Bild hochladen</h3>
            </div>

            <div class="upload-zone" data-upload-type="image" id="mainUploadZone">
                <input type="file" accept="image/*" multiple>
                <span class="upload-zone__icon">🖼️</span>
                <p class="upload-zone__text">
                    Bilder hier ablegen oder klicken<br>
                    <span style="font-size: 0.78rem; color: var(--admin-muted)">
                        JPG, PNG, GIF, WebP, SVG – max. 10 MB
                    </span>
                </p>
            </div>
        </div>

        <!-- ============================================================
             GALERIE-GRID
             ============================================================ -->
        <div class="card">
            <div class="card__header">
                <h3 class="card__title">
                    🖼️ Deine Werke
                    <span style="font-size: 0.8rem; color: var(--admin-muted); font-weight: normal; margin-left: 0.5rem">
                        (<?= count($gallery) ?> Bilder)
                    </span>
                </h3>
            </div>

            <?php if (empty($gallery)): ?>
            <div style="text-align: center; padding: 3rem; color: var(--admin-muted)">
                <p style="font-size: 2rem; margin-bottom: 1rem">🖼️</p>
                <p>Noch keine Bilder hochgeladen.</p>
                <p style="margin-top: 0.5rem; font-size: 0.85rem">
                    Lade oben dein erstes Bild hoch!
                </p>
            </div>

            <?php else: ?>
            <!-- Das draggable-Attribut macht Items per Maus verschiebbar -->
            <div class="admin-gallery-grid" id="adminGalleryGrid">
                <?php foreach ($gallery as $item): ?>
                <div class="admin-gallery-item"
                     draggable="true"
                     data-id="<?= escape($item['id']) ?>">

                    <!-- Bild-Vorschau -->
                    <?php if (!empty($item['image'])): ?>
                    <img class="admin-gallery-item__img"
                         src="<?= escape($item['image']) ?>"
                         alt="<?= escape($item['title'] ?? '') ?>"
                         loading="lazy">
                    <?php else: ?>
                    <div class="admin-gallery-item__img" style="
                        background: linear-gradient(135deg, #2a2a4a, #0f3460);
                        display: flex; align-items: center; justify-content: center;
                        font-size: 2rem;
                    ">🎨</div>
                    <?php endif; ?>

                    <!-- Bild-Informationen -->
                    <div class="admin-gallery-item__info">
                        <div class="admin-gallery-item__title">
                            <?= escape($item['title'] ?? 'Ohne Titel') ?>
                        </div>
                        <div class="admin-gallery-item__meta">
                            <?= escape($item['medium'] ?? '') ?>
                        </div>
                    </div>

                    <!-- Aktions-Buttons (erscheinen beim Hover) -->
                    <div class="admin-gallery-item__actions">
                        <!-- Bearbeiten-Button -->
                        <button class="btn btn--secondary btn--sm"
                                onclick="editGalleryItem('<?= escape($item['id']) ?>', '<?= escape(addslashes($item['title'] ?? '')) ?>', '<?= escape(addslashes($item['medium'] ?? '')) ?>', '<?= escape(addslashes($item['description'] ?? '')) ?>')"
                                title="Bearbeiten">
                            ✏️
                        </button>
                        <!-- Löschen-Button -->
                        <button class="btn btn--danger btn--sm"
                                data-delete-gallery="<?= escape($item['id']) ?>"
                                title="Löschen">
                            🗑️
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

    </main>
</div>

<!-- ============================================================
     BEARBEITEN-MODAL
     Ein modales Fenster (Overlay) zum Bearbeiten von Bild-Infos.
     ============================================================ -->
<div id="editModal" style="
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.8); z-index: 1000;
    align-items: center; justify-content: center;
">
    <div style="
        background: var(--admin-sidebar);
        border: 1px solid var(--admin-border);
        border-radius: 8px; padding: 2rem;
        width: 100%; max-width: 480px;
    ">
        <h3 style="color: white; margin-bottom: 1.5rem">Bild bearbeiten</h3>

        <input type="hidden" id="editItemId">

        <div class="form-group">
            <label for="editTitle">Titel</label>
            <input type="text" id="editTitle" placeholder="z.B. Ohne Titel I">
        </div>

        <div class="form-group">
            <label for="editMedium">Technik / Medium</label>
            <input type="text" id="editMedium" placeholder="z.B. Acryl auf Leinwand, 2026">
        </div>

        <div class="form-group">
            <label for="editDescription">Beschreibung (optional)</label>
            <textarea id="editDescription" style="height: 80px"
                      placeholder="Kurze Beschreibung des Werks..."></textarea>
        </div>

        <div style="display: flex; gap: 0.75rem; justify-content: flex-end">
            <button onclick="closeEditModal()" class="btn btn--secondary">Abbrechen</button>
            <button onclick="saveEditItem()" class="btn btn--primary">💾 Speichern</button>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>
<script>
// ===================================================================
// GALERIE-EDITOR FUNKTIONEN
// Diese Funktionen werden direkt auf dieser Seite gebraucht.
// ===================================================================

/**
 * Öffnet das Bearbeitungs-Modal für ein Galerie-Bild.
 */
function editGalleryItem(id, title, medium, description) {
    document.getElementById('editItemId').value     = id;
    document.getElementById('editTitle').value      = title;
    document.getElementById('editMedium').value     = medium;
    document.getElementById('editDescription').value = description;

    const modal = document.getElementById('editModal');
    modal.style.display = 'flex';
}

/**
 * Schließt das Modal.
 */
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

/**
 * Speichert die Bild-Metadaten.
 */
async function saveEditItem() {
    const id          = document.getElementById('editItemId').value;
    const title       = document.getElementById('editTitle').value;
    const medium      = document.getElementById('editMedium').value;
    const description = document.getElementById('editDescription').value;

    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('id', id);
    formData.append('title', title);
    formData.append('medium', medium);
    formData.append('description', description);

    const resp = await fetch('/admin/gallery.php', { method: 'POST', body: formData });
    const result = await resp.json();

    if (result.success) {
        // Modal schließen und Seite neu laden um Änderungen zu sehen
        closeEditModal();
        location.reload();
    }
}

// Modal schließen wenn außerhalb geklickt
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});

// Upload-Handler für Galerie-Bilder anpassen
// (nach dem Upload soll das Bild direkt in der Galerie erscheinen)
document.addEventListener('DOMContentLoaded', function() {
    const zone  = document.getElementById('mainUploadZone');
    const input = zone?.querySelector('input[type="file"]');
    if (!input) return;

    zone.addEventListener('click', () => input.click());

    zone.addEventListener('dragover', e => {
        e.preventDefault();
        zone.classList.add('is-dragover');
    });
    zone.addEventListener('dragleave', () => zone.classList.remove('is-dragover'));

    zone.addEventListener('drop', e => {
        e.preventDefault();
        zone.classList.remove('is-dragover');
        const files = e.dataTransfer.files;
        if (files.length) uploadGalleryImages(files);
    });

    input.addEventListener('change', () => {
        if (input.files.length) uploadGalleryImages(input.files);
    });
});

/**
 * Lädt mehrere Galerie-Bilder hoch.
 */
async function uploadGalleryImages(files) {
    for (const file of files) {
        const fd = new FormData();
        fd.append('file', file);
        fd.append('type', 'image');
        fd.append('gallery', '1'); // Signal: Bild zur Galerie hinzufügen

        try {
            const resp = await fetch('/admin/upload.php', { method: 'POST', body: fd });
            const result = await resp.json();
            if (!result.success) {
                alert('Fehler: ' + (result.error || 'Upload fehlgeschlagen'));
            }
        } catch(e) {
            console.error('Upload error:', e);
        }
    }
    // Seite neu laden um alle hochgeladenen Bilder zu sehen
    location.reload();
}
</script>

</body>
</html>
