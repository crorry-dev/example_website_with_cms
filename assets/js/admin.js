/**
 * ADMIN-JAVASCRIPT
 * ==================
 * Steuert die Interaktionen im Admin-Bereich:
 * - Formulare speichern (AJAX)
 * - Bilder hochladen mit Drag & Drop
 * - Galerie-Sortierung
 * - Toast-Meldungen
 * - Tabs im Editor
 * - Rich-Text-Editor
 */

'use strict';

// DOM bereit warten
document.addEventListener('DOMContentLoaded', function () {
    initToasts();
    initTabs();
    initSaveForms();
    initUploadZone();
    initGallerySort();
    initGalleryDelete();
    initColorPreviews();
    initRichEditor();
    initPasswordChange();
});


// ====================================================================
// TOAST-MELDUNGEN (Kurze Erfolgsmeldungen)
// ====================================================================

/**
 * Zeigt eine Toast-Meldung für kurze Zeit an.
 * @param {string} message  Text der Meldung
 * @param {string} type     'success' oder 'error'
 */
function showToast(message, type = 'success') {
    // Vorhandene Toasts entfernen
    document.querySelectorAll('.toast').forEach(t => t.remove());

    const toast = document.createElement('div');
    toast.className = `toast ${type === 'error' ? 'toast--error' : ''}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    // Kurze Verzögerung damit CSS-Transition greift
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            toast.classList.add('is-visible');
        });
    });

    // Nach 3 Sekunden ausblenden
    setTimeout(() => {
        toast.classList.remove('is-visible');
        setTimeout(() => toast.remove(), 400);
    }, 3000);
}


// ====================================================================
// TABS (Registerkarten in Formularen)
// ====================================================================

function initTabs() {
    document.querySelectorAll('.editor-tabs').forEach(tabGroup => {
        const tabs   = tabGroup.querySelectorAll('.editor-tab');
        const panels = document.querySelectorAll('.editor-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Alle deaktivieren
                tabs.forEach(t => t.classList.remove('is-active'));
                panels.forEach(p => p.classList.remove('is-active'));

                // Angeklickten Tab aktivieren
                tab.classList.add('is-active');
                const target = document.getElementById(tab.dataset.panel);
                if (target) target.classList.add('is-active');
            });
        });
    });
}


// ====================================================================
// FORMULARE SPEICHERN (Save Forms via AJAX)
// ====================================================================

function initSaveForms() {
    document.querySelectorAll('[data-save-form]').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn        = form.querySelector('[type="submit"]');
            const originalText = btn.textContent;
            btn.disabled   = true;
            btn.textContent = 'Speichern…';

            // Rich-Editor-Inhalt in verstecktes Textfeld schreiben
            form.querySelectorAll('[data-rich-for]').forEach(editor => {
                const target = form.querySelector('#' + editor.dataset.richFor);
                if (target) target.value = editor.innerHTML;
            });

            const formData = new FormData(form);
            const endpoint = form.dataset.saveForm || '/admin/save.php';

            try {
                const resp   = await fetch(endpoint, { method: 'POST', body: formData });
                const result = await resp.json();

                if (result.success) {
                    showToast('✓ Gespeichert!');
                } else {
                    showToast(result.error || 'Fehler beim Speichern', 'error');
                }
            } catch {
                showToast('Verbindungsfehler', 'error');
            }

            btn.disabled   = false;
            btn.textContent = originalText;
        });
    });
}


// ====================================================================
// DATEI-UPLOAD mit Drag & Drop
// ====================================================================

function initUploadZone() {
    document.querySelectorAll('.upload-zone').forEach(zone => {
        const input    = zone.querySelector('input[type="file"]');
        const preview  = zone.closest('[data-upload-section]')?.querySelector('.upload-preview');

        if (!input) return;

        // Klick auf Zone öffnet Datei-Dialog
        zone.addEventListener('click', () => input.click());

        // Drag-Over Styling
        zone.addEventListener('dragover', e => {
            e.preventDefault();
            zone.classList.add('is-dragover');
        });
        zone.addEventListener('dragleave', () => zone.classList.remove('is-dragover'));

        // Drop-Handler
        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('is-dragover');
            const files = e.dataTransfer.files;
            if (files.length) handleFileUpload(files[0], zone, preview);
        });

        // Input-Change Handler
        input.addEventListener('change', () => {
            if (input.files.length) handleFileUpload(input.files[0], zone, preview);
        });
    });
}

/**
 * Lädt eine Datei auf den Server hoch.
 * @param {File}    file     Die hochzuladende Datei
 * @param {Element} zone     Die Upload-Zone (für Feedback)
 * @param {Element} preview  Vorschau-Container (optional)
 */
async function handleFileUpload(file, zone, preview) {
    const type    = zone.dataset.uploadType || 'image';
    const page    = zone.dataset.uploadPage || '';
    const field   = zone.dataset.uploadField || '';

    zone.querySelector('.upload-zone__text').textContent = 'Wird hochgeladen…';

    const formData = new FormData();
    formData.append('file', file);
    formData.append('type', type);
    formData.append('page', page);
    formData.append('field', field);

    try {
        const resp   = await fetch('/admin/upload.php', { method: 'POST', body: formData });
        const result = await resp.json();

        if (result.success) {
            showToast('✓ Datei hochgeladen!');
            zone.querySelector('.upload-zone__text').textContent = `✓ ${file.name}`;

            // Vorschaubild aktualisieren
            if (preview && type === 'image') {
                preview.src = result.path;
                preview.style.display = 'block';
            }

            // Verstecktes Input-Feld mit Pfad befüllen
            if (field) {
                const hiddenInput = document.getElementById('field_' + field);
                if (hiddenInput) hiddenInput.value = result.path;
            }

            // Seite neu laden nach Font-Upload (damit neue Schrift sichtbar)
            if (type === 'font') {
                setTimeout(() => location.reload(), 1000);
            }
        } else {
            showToast(result.error || 'Upload fehlgeschlagen', 'error');
            zone.querySelector('.upload-zone__text').textContent = 'Datei hierhin ziehen oder klicken';
        }
    } catch {
        showToast('Verbindungsfehler beim Upload', 'error');
        zone.querySelector('.upload-zone__text').textContent = 'Datei hierhin ziehen oder klicken';
    }
}


// ====================================================================
// GALERIE SORTIEREN (Drag & Drop Reihenfolge)
// ====================================================================

function initGallerySort() {
    const grid = document.getElementById('adminGalleryGrid');
    if (!grid) return;

    let dragEl = null;

    grid.addEventListener('dragstart', function (e) {
        dragEl = e.target.closest('.admin-gallery-item');
        if (dragEl) {
            dragEl.classList.add('is-dragging');
            e.dataTransfer.effectAllowed = 'move';
        }
    });

    grid.addEventListener('dragover', function (e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';

        const target = e.target.closest('.admin-gallery-item');
        if (target && target !== dragEl) {
            // Bestimmen ob vor oder nach dem Ziel einfügen
            const rect    = target.getBoundingClientRect();
            const midX    = rect.left + rect.width / 2;
            const insertBefore = e.clientX < midX;

            if (insertBefore) {
                grid.insertBefore(dragEl, target);
            } else {
                grid.insertBefore(dragEl, target.nextSibling);
            }
        }
    });

    grid.addEventListener('dragend', function () {
        if (dragEl) {
            dragEl.classList.remove('is-dragging');
            dragEl = null;
            saveGalleryOrder(grid);
        }
    });
}

/**
 * Speichert die neue Galerie-Reihenfolge auf dem Server.
 */
async function saveGalleryOrder(grid) {
    // Alle Item-IDs in der aktuellen Reihenfolge sammeln
    const ids = Array.from(grid.querySelectorAll('.admin-gallery-item'))
        .map(item => item.dataset.id)
        .filter(Boolean);

    const formData = new FormData();
    formData.append('action', 'reorder');
    formData.append('ids', JSON.stringify(ids));

    try {
        const resp   = await fetch('/admin/gallery.php', { method: 'POST', body: formData });
        const result = await resp.json();
        if (result.success) showToast('✓ Reihenfolge gespeichert');
        else showToast('Fehler beim Sortieren', 'error');
    } catch {
        showToast('Verbindungsfehler', 'error');
    }
}


// ====================================================================
// GALERIE LÖSCHEN
// ====================================================================

function initGalleryDelete() {
    document.addEventListener('click', async function (e) {
        const btn = e.target.closest('[data-delete-gallery]');
        if (!btn) return;

        if (!confirm('Bild wirklich löschen?')) return;

        const id       = btn.dataset.deleteGallery;
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        try {
            const resp   = await fetch('/admin/gallery.php', { method: 'POST', body: formData });
            const result = await resp.json();

            if (result.success) {
                // Item aus DOM entfernen
                const item = btn.closest('.admin-gallery-item');
                item?.remove();
                showToast('✓ Bild gelöscht');
            } else {
                showToast(result.error || 'Fehler beim Löschen', 'error');
            }
        } catch {
            showToast('Verbindungsfehler', 'error');
        }
    });
}


// ====================================================================
// FARB-VORSCHAU (Color Preview)
// ====================================================================

/**
 * Zeigt Live-Vorschau der Farben im Admin.
 */
function initColorPreviews() {
    document.querySelectorAll('input[type="color"]').forEach(input => {
        const preview = document.getElementById('preview_' + input.name);
        if (!preview) return;

        input.addEventListener('input', () => {
            preview.style.background = input.value;
        });
    });
}


// ====================================================================
// RICH-TEXT-EDITOR (Einfacher WYSIWYG-Editor)
// ====================================================================

/**
 * Ein einfacher Rich-Text-Editor mit Formatierungs-Buttons.
 * WYSIWYG = What You See Is What You Get
 * (Du siehst die formatierte Version während du schreibst)
 */
function initRichEditor() {
    document.querySelectorAll('.rich-editor').forEach(editor => {
        editor.setAttribute('contenteditable', 'true');

        // Toolbar-Buttons
        const toolbar = editor.previousElementSibling;
        if (!toolbar || !toolbar.classList.contains('editor-toolbar')) return;

        toolbar.querySelectorAll('[data-cmd]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const cmd   = btn.dataset.cmd;
                const value = btn.dataset.value || null;

                // document.execCommand ist veraltet aber einfach für Einsteiger
                // (Für Produktion würde man eine echte Editor-Bibliothek nutzen)
                document.execCommand(cmd, false, value);
                editor.focus();

                // Aktiv-Status aktualisieren
                updateToolbarState(toolbar);
            });
        });

        editor.addEventListener('keyup', () => updateToolbarState(toolbar));
        editor.addEventListener('mouseup', () => updateToolbarState(toolbar));
    });
}

/**
 * Aktualisiert den Aktiv-Status der Toolbar-Buttons.
 */
function updateToolbarState(toolbar) {
    toolbar.querySelectorAll('[data-cmd]').forEach(btn => {
        const cmd = btn.dataset.cmd;
        const isActive = document.queryCommandState(cmd);
        btn.classList.toggle('is-active', isActive);
    });
}


// ====================================================================
// PASSWORT ÄNDERN
// ====================================================================

function initPasswordChange() {
    const form = document.getElementById('passwordForm');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const newPw    = form.querySelector('#new_password').value;
        const confirmPw = form.querySelector('#confirm_password').value;

        if (newPw !== confirmPw) {
            showToast('Passwörter stimmen nicht überein!', 'error');
            return;
        }
        if (newPw.length < 6) {
            showToast('Passwort muss mindestens 6 Zeichen lang sein!', 'error');
            return;
        }

        const formData = new FormData(form);
        const resp   = await fetch('/admin/save.php', { method: 'POST', body: formData });
        const result = await resp.json();

        if (result.success) {
            showToast('✓ Passwort geändert!');
            form.reset();
        } else {
            showToast(result.error || 'Fehler', 'error');
        }
    });
}
