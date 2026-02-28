/**
 * HAUPT-JAVASCRIPT (Main JavaScript)
 * =====================================
 * Diese Datei steuert alle interaktiven Effekte der Website:
 * - Lade-Animation (Loader)
 * - Header-Effekte beim Scrollen
 * - Mobile Navigation
 * - Scroll-Animationen (Reveal on Scroll)
 * - Parallax-Effekt im Hero-Bereich
 * - Galerie-Lightbox
 * - Kontaktformular
 *
 * Was ist JavaScript (JS)?
 * → JS macht Webseiten interaktiv und lebendig.
 * → Während HTML die Struktur und CSS das Aussehen bestimmt,
 *   regelt JS das Verhalten (was passiert wenn du klickst, scrollst, etc.)
 *
 * "use strict" am Anfang: Moderner JS-Modus, der häufige Fehler verhindert.
 */

'use strict';

/**
 * INITIALISIERUNG
 * ================
 * DOMContentLoaded = Startet erst wenn die HTML-Seite vollständig geladen ist.
 * Das ist wichtig, damit wir auf alle Elemente zugreifen können!
 */
document.addEventListener('DOMContentLoaded', function () {

    // Alle Initialisierungsfunktionen aufrufen
    initLoader();
    initHeader();
    initMobileNav();
    initScrollReveal();
    initParallax();
    initLightbox();
    initContactForm();

});


// ====================================================================
// LADE-ANIMATION (Loading Animation)
// ====================================================================

/**
 * Versteckt den Loader nach dem Laden der Seite.
 * Der Loader ist ein kleiner Übergang beim Seitenaufruf.
 */
function initLoader() {
    const loader = document.getElementById('loader');
    if (!loader) return;

    // Nach 600ms Loader ausblenden
    // setTimeout: Führe Code nach einer Verzögerung aus (in Millisekunden)
    setTimeout(function () {
        loader.classList.add('is-hidden');

        // Nach weiteren 600ms (Fade-Out-Dauer) komplett entfernen
        setTimeout(function () {
            loader.remove();
        }, 600);
    }, 600);
}


// ====================================================================
// HEADER-EFFEKTE (Header Effects)
// ====================================================================

/**
 * Fügt beim Scrollen einen Hintergrund zum Header hinzu.
 * IntersectionObserver wäre performanter, aber für diesen Effekt
 * nutzen wir scroll-Event direkt.
 */
function initHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;

    // 'scroll' Event: wird aufgerufen wenn der Benutzer scrollt
    window.addEventListener('scroll', function () {
        // scrollY = wie viele Pixel wurde nach unten gescrollt
        if (window.scrollY > 50) {
            header.classList.add('is-scrolled');
        } else {
            header.classList.remove('is-scrolled');
        }
    }, { passive: true }); // passive: true = performanter (keine Scroll-Unterbrechung)
}


// ====================================================================
// MOBILE NAVIGATION
// ====================================================================

/**
 * Hamburger-Menü für Mobile-Geräte.
 * Öffnet/Schließt die Navigation als Overlay.
 */
function initMobileNav() {
    const toggle = document.getElementById('navToggle');
    const nav    = document.getElementById('siteNav');
    if (!toggle || !nav) return;

    // Klick auf den Hamburger-Button
    toggle.addEventListener('click', function () {
        // classList.toggle: Klasse an/aus – wie ein Lichtschalter
        const isOpen = toggle.classList.toggle('is-open');
        nav.classList.toggle('is-open', isOpen);

        // ARIA-Attribute für Barrierefreiheit aktualisieren
        toggle.setAttribute('aria-expanded', isOpen.toString());

        // Scrollen verhindern wenn Menü offen ist
        document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Menü schließen wenn auf einen Link geklickt wird
    nav.querySelectorAll('.site-nav__link').forEach(function (link) {
        link.addEventListener('click', function () {
            toggle.classList.remove('is-open');
            nav.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        });
    });

    // Menü schließen wenn Escape gedrückt wird
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && nav.classList.contains('is-open')) {
            toggle.classList.remove('is-open');
            nav.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    });
}


// ====================================================================
// SCROLL-ANIMATIONEN (Reveal on Scroll)
// ====================================================================

/**
 * Elemente erscheinen wenn sie in den sichtbaren Bereich scrollen.
 *
 * IntersectionObserver: Eine moderne Browser-API die "beobachtet"
 * ob ein Element sichtbar ist. Viel effizienter als scroll-Events!
 */
function initScrollReveal() {
    // Alle Elemente mit data-reveal Attribut finden
    const elements = document.querySelectorAll('[data-reveal]');
    if (!elements.length) return;

    // IntersectionObserver erstellen
    // Wird aufgerufen wenn ein Element in/aus dem sichtbaren Bereich kommt
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                // Element ist sichtbar → sichtbar machen
                entry.target.classList.add('is-visible');

                // Nach dem Einblenden nicht mehr beobachten (Performance)
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,    // Auslösen wenn 10% des Elements sichtbar ist
        rootMargin: '0px 0px -50px 0px'  // Etwas verzögert (50px vom unteren Rand)
    });

    // Jedes Element beobachten
    elements.forEach(function (el) {
        observer.observe(el);
    });
}


// ====================================================================
// PARALLAX-EFFEKT
// ====================================================================

/**
 * Lässt das Hero-Hintergrundbild beim Scrollen langsamer scrollen.
 * Das erzeugt einen Tiefeneffekt!
 *
 * requestAnimationFrame: Optimiert Animationen (läuft synchron mit dem Browser-Refresh)
 */
function initParallax() {
    const heroEl = document.querySelector('.hero');
    const heroBg = document.querySelector('.hero__bg');
    if (!heroEl || !heroBg) return;

    // Kein Parallax auf kleinen Bildschirmen (zu langsam)
    if (window.innerWidth < 768) return;

    window.addEventListener('scroll', function () {
        // requestAnimationFrame: Wartet auf nächsten Browser-Frame
        requestAnimationFrame(function () {
            const scrolled = window.scrollY;
            // Hintergrundbild nur halb so schnell scrollen → Tiefeneffekt
            heroBg.style.transform = 'translateY(' + (scrolled * 0.4) + 'px)';
        });
    }, { passive: true });
}


// ====================================================================
// LIGHTBOX (Bild-Großansicht)
// ====================================================================

/**
 * Öffnet ein Bild in einer Großansicht wenn man darauf klickt.
 */
function initLightbox() {
    // Lightbox-Element erstellen (wird dynamisch zum Body hinzugefügt)
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.setAttribute('role', 'dialog');
    lightbox.setAttribute('aria-modal', 'true');
    lightbox.setAttribute('aria-label', 'Bildansicht');
    lightbox.innerHTML = `
        <button class="lightbox__close" aria-label="Schließen">✕</button>
        <img class="lightbox__img" src="" alt="">
        <div class="lightbox__caption"></div>
    `;
    document.body.appendChild(lightbox);

    const lbImg     = lightbox.querySelector('.lightbox__img');
    const lbCaption = lightbox.querySelector('.lightbox__caption');
    const lbClose   = lightbox.querySelector('.lightbox__close');

    /**
     * Lightbox öffnen
     * @param {string} src     Bildpfad
     * @param {string} caption Bildbeschriftung
     */
    function openLightbox(src, caption) {
        lbImg.src = src;
        lbImg.alt = caption || '';
        lbCaption.textContent = caption || '';
        lightbox.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        lbClose.focus();
    }

    /**
     * Lightbox schließen
     */
    function closeLightbox() {
        lightbox.classList.remove('is-open');
        document.body.style.overflow = '';
        lbImg.src = '';
    }

    // Auf alle Galerie-Items klicken
    document.querySelectorAll('.gallery-item').forEach(function (item) {
        item.addEventListener('click', function () {
            const img     = item.querySelector('.gallery-item__img');
            const title   = item.querySelector('.gallery-item__title');
            const caption = title ? title.textContent : '';

            if (img) {
                openLightbox(img.src, caption);
            }
        });
    });

    // Schließen durch Klick auf Hintergrund oder Schließen-Button
    lbClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });

    // Schließen mit Escape-Taste
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeLightbox();
    });
}


// ====================================================================
// KONTAKTFORMULAR (Contact Form)
// ====================================================================

/**
 * Sendet das Kontaktformular per AJAX (ohne Seitenneuladen).
 * AJAX = Asynchronous JavaScript And XML
 * (Moderne Variante: fetch() API mit JSON statt XML)
 */
function initContactForm() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', async function (e) {
        // Standard-Submit verhindern (würde Seite neu laden)
        e.preventDefault();

        const btn = form.querySelector('[type="submit"]');
        const msgEl = document.getElementById('form-message');

        // Button deaktivieren während Senden
        btn.disabled = true;
        btn.textContent = 'Wird gesendet…';

        // FormData: Sammelt alle Felder des Formulars
        const formData = new FormData(form);

        try {
            // fetch() = moderner Weg um HTTP-Anfragen zu senden
            const response = await fetch('/contact.php', {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            });

            const result = await response.json(); // Antwort als JSON lesen

            if (result.success) {
                showFormMessage(msgEl, 'Vielen Dank! Deine Nachricht wurde gesendet.', 'success');
                form.reset(); // Formular leeren
            } else {
                showFormMessage(msgEl, result.error || 'Fehler beim Senden.', 'error');
            }
        } catch (err) {
            showFormMessage(msgEl, 'Verbindungsfehler. Bitte versuche es später.', 'error');
        }

        btn.disabled = false;
        btn.textContent = 'Nachricht senden';
    });
}

/**
 * Zeigt eine Formular-Meldung an.
 */
function showFormMessage(el, text, type) {
    if (!el) return;
    el.textContent = text;
    el.className = 'form-message form-message--' + type;
    el.style.display = 'block';

    // Nach 5 Sekunden ausblenden
    setTimeout(function () {
        el.style.display = 'none';
    }, 5000);
}
