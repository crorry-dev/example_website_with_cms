# 🎨 Kunst-Website CMS – Für Kunststudentinnen und Kunststudenten

**Ein einfaches, elegantes Content-Management-System für deine Kunst-Webseite.**

Gebaut für: Kunststudierende ohne viele Programmierkenntnisse  
Inspiriert von: [lileweimar.de](https://lileweimar.de)  
Technologien: HTML, CSS, JavaScript, PHP (kein WordPress, keine Datenbank nötig!)

---

## 📚 Inhaltsverzeichnis

1. [Was ist das?](#-was-ist-das)
2. [Was du bekommst](#-was-du-bekommst)
3. [Voraussetzungen](#️-voraussetzungen)
4. [Installation (5 Minuten)](#-installation-5-minuten)
5. [Erste Schritte im Admin-Bereich](#️-erste-schritte-im-admin-bereich)
6. [Seiten anpassen](#-seiten-anpassen)
7. [Design anpassen](#-design-anpassen)
8. [Eigene Schriftarten](#-eigene-schriftarten)
9. [Galerie verwalten](#-galerie-verwalten)
10. [Für Fortgeschrittene](#-für-fortgeschrittene)
11. [Projektstruktur erklärt](#-projektstruktur-erklärt)
12. [Häufige Fragen (FAQ)](#-häufige-fragen-faq)

---

## 🎨 Was ist das?

Dieses Projekt ist eine **fertige Kunst-Website** mit einem integrierten **CMS (Content Management System)**.

**CMS bedeutet:** Du kannst alle Inhalte (Texte, Bilder, Farben) über eine einfache Admin-Oberfläche ändern – ohne Code anfassen zu müssen!

### Warum kein WordPress?

| | Dieses CMS | WordPress |
|---|---|---|
| Datenbank nötig | ❌ Nein | ✅ Ja |
| Schwierigkeit | ⭐ Einfach | ⭐⭐⭐ Mittel |
| Anpassbar | ✅ Sehr | ✅ Sehr |
| Ladezeit | ⚡ Schnell | 🐢 Variiert |
| Code verstehen | ✅ Leicht | ❌ Komplex |

---

## ✨ Was du bekommst

**4 fertige Webseiten:**
- 🏠 **Startseite** – Mit großem Hero-Bild, Intro-Text, Galerie-Vorschau
- 🖼️ **Galerie** – Elegantes Grid-Layout mit Lightbox (Bild-Großansicht)
- 👤 **Über mich** – Dein Foto, Text, CV/Vita
- ✉️ **Kontakt** – Formular das dir E-Mails schickt

**Admin-Bereich zum Verwalten:**
- ⚙️ Einstellungen (Name, Farben, Schriften, Social Media)
- 🖼️ Galerie (Bilder hochladen, sortieren, beschriften)
- 📝 Seiten (alle Texte bearbeiten)
- 🔒 Sicheres Login-System

**Design-Features:**
- 📱 Responsive (funktioniert auf Handy, Tablet, Desktop)
- ✨ Elegante Animationen beim Scrollen
- 🎨 Komplett anpassbare Farben
- 🔤 Google Fonts + eigene Schriftarten hochladbar
- 🖼️ Lightbox für die Galerie

---

## 🖥️ Voraussetzungen

Zum **Hosten** brauchst du:
- ✅ Webhosting mit **PHP 8.0** oder neuer
- ✅ Schreibrechte auf dem Server (für Uploads)
- ✅ (Optional) Apache mit mod_rewrite für .htaccess

Zum **Entwickeln** lokal:
- [XAMPP](https://www.apachefriends.org/) (Windows/Mac/Linux – kostenlos)
- oder [MAMP](https://www.mamp.info/) (Mac)
- oder [Laragon](https://laragon.org/) (Windows)

---

## 🚀 Installation (5 Minuten)

### Option A: Auf echtem Webhosting (empfohlen)

1. **Dateien hochladen** – Alle Dateien via FTP/SFTP auf deinen Server laden
   - Empfohlene FTP-Programme: [FileZilla](https://filezilla-project.org/) (kostenlos)
   - Lade alle Dateien in das `public_html/` oder `www/` Verzeichnis

2. **Schreibrechte setzen** – Diese Ordner müssen schreibbar sein (Rechte: 755 oder 777):
   ```
   content/
   content/pages/
   assets/uploads/
   assets/uploads/images/
   assets/uploads/fonts/
   ```

3. **Website aufrufen** – Gehe zu deiner Domain, z.B. `https://deine-domain.de`

4. **Admin aufrufen** – Gehe zu `https://deine-domain.de/admin/`
   - Benutzername: `admin`
   - Passwort: `admin123`
   - ⚠️ **Passwort sofort ändern!**

### Option B: Lokal mit XAMPP

1. XAMPP installieren und starten (Apache + PHP)
2. Projektordner nach `C:\xampp\htdocs\meine-kunstseite\` kopieren
3. Browser öffnen: `http://localhost/meine-kunstseite/`
4. Admin: `http://localhost/meine-kunstseite/admin/`

---

## 🛠️ Erste Schritte im Admin-Bereich

Nach dem ersten Login siehst du das **Dashboard**. Folge dieser Reihenfolge:

### 1️⃣ Einstellungen anpassen
Gehe zu **⚙️ Einstellungen** und ändere:
- **Seitenname** – Dein Name oder dein Künstlername
- **Tagline** – Dein Motto oder deine künstlerische Ausrichtung
- **E-Mail** – Hierhin kommen Kontaktformular-Nachrichten
- **Akzentfarbe** – Die Hauptfarbe deines Designs
- **Passwort** – Das Standard-Passwort `admin123` ändern!

### 2️⃣ Erste Bilder hochladen
Gehe zu **🖼️ Galerie** und lade deine Kunstwerke hoch.
- Einfach in den Upload-Bereich klicken oder Bilder reinziehen
- Danach kannst du Titel und Beschreibung eingeben

### 3️⃣ Texte anpassen
Gehe zu **📝 Seiten bearbeiten** und passe alle Texte an.

---

## 📝 Seiten anpassen

### Startseite
- **Haupttitel** – Dein großes Motto (z.B. *"Kunst beginnt wo Sprache endet"*)
- **Untertitel** – Kurze Ergänzung
- **Hintergrundbild** – Optional: Ein Bild für den Hero-Bereich
- **Über-mich-Text** – Kurze Vorstellung auf der Startseite

### Über mich
- **Foto** – Dein Porträtbild
- **Text** – Du kannst hier formatieren (fett, kursiv, Listen)
- **Vita** – Dein künstlerischer Werdegang im Format:
  ```json
  [
    {"year": "2024", "text": "Ausstellung in der Galerie XY"},
    {"year": "2023", "text": "Beginn des Studiums"}
  ]
  ```

---

## 🎨 Design anpassen

Alle Design-Einstellungen findest du unter **⚙️ Einstellungen → Design**.

### Farben
| Einstellung | Bedeutung | Standard |
|---|---|---|
| Akzentfarbe | Links, Hervorhebungen | `#c4a882` (Goldbeige) |
| Hintergrundfarbe | Seitenhintergrund | `#f5f0eb` (Warm-Weiß) |
| Textfarbe | Haupttext | `#1a1a1a` (Fast Schwarz) |

**Tipp für Kunstsitudierende:** Halte das Design minimalistisch. Lass die Kunst sprechen!

### Schriftarten
Du kannst aus vorinstallierten Google Fonts wählen:
- **Playfair Display** – Elegant, Serifen, Zeitungscharakter
- **Cormorant Garamond** – Klassisch, fein
- **Josefin Sans** – Modern, geometrisch, Bauhaus-inspiriert
- **Montserrat** – Klar, zeitgemäß

---

## 🔤 Eigene Schriftarten

Wenn du eine besondere Schriftart für dein Projekt hast, kannst du sie hochladen!

**So geht's:**
1. Gehe zu **⚙️ Einstellungen → Eigene Schriftart**
2. Ziehe deine Schriftartdatei in den Upload-Bereich
3. Die Schriftart wird automatisch eingebunden

**Unterstützte Formate:** `.ttf`, `.otf`, `.woff`, `.woff2`

**Warum verschiedene Formate?**
- `.woff2` – Modernster Standard, kleinste Datei → Empfohlen
- `.woff` – Älterer Standard, breite Browser-Unterstützung
- `.ttf`/`.otf` – Original-Schriftdateien (vom Designer)

---

## 🖼️ Galerie verwalten

### Bilder hochladen
- Klicke auf den Upload-Bereich oder ziehe Bilder direkt hinein
- Mehrere Bilder auf einmal hochladen möglich!
- Empfohlene Bildgröße: mindestens 1200px Breite für gute Qualität

### Bilder sortieren
- Halte ein Bild gedrückt und ziehe es an eine neue Position
- Die Reihenfolge wird automatisch gespeichert

### Bilder beschriften
- Klicke auf das ✏️-Symbol bei einem Bild
- Gib Titel, Technik/Medium und Beschreibung ein

### Bild löschen
- Klicke auf das 🗑️-Symbol bei einem Bild
- Das Bild wird vom Server gelöscht (nicht rückgängig zu machen!)

---

## 💻 Für Fortgeschrittene

### Design-Änderungen in CSS

Die Hauptstylesheet-Datei ist: `assets/css/style.css`

Am Anfang findest du die CSS-Variablen:
```css
:root {
    --accent:    #c4a882;  /* Akzentfarbe */
    --bg:        #f5f0eb;  /* Hintergrund */
    --text:      #1a1a1a;  /* Text */
    --font-heading: 'Playfair Display', serif;
    --font-body:    'Lato', sans-serif;
}
```

Diese Variablen werden vom PHP aus den Admin-Einstellungen gesetzt. Du kannst sie auch direkt hier ändern.

### Neue Seite hinzufügen

1. Neue PHP-Datei erstellen, z.B. `projekte.php`
2. Am Anfang einbinden:
   ```php
   define('CMS_ROOT', __DIR__);
   require_once __DIR__ . '/config/config.php';
   require_once __DIR__ . '/includes/functions.php';
   $settings = get_settings();
   $pageTitle = 'Projekte';
   include __DIR__ . '/includes/header.php';
   ```
3. Deinen Inhalt schreiben
4. Am Ende: `include __DIR__ . '/includes/footer.php';`
5. In `includes/header.php` die Navigation erweitern

### Galerie-Layout anpassen

Das Galerie-Grid wird in `assets/css/style.css` gesteuert:
```css
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}
```

Ändere `280px` um die Mindestbreite der Galerie-Kacheln anzupassen.

### Animationen

Alle Scroll-Animationen werden durch das `data-reveal` Attribut ausgelöst:
```html
<div data-reveal>          <!-- Von unten einblenden -->
<div data-reveal="left">   <!-- Von links einblenden -->
<div data-reveal="right">  <!-- Von rechts einblenden -->
<div data-reveal data-delay="200">  <!-- 200ms verzögert -->
```

---

## 📁 Projektstruktur erklärt

```
meine-kunstseite/
│
├── index.php           ← Startseite
├── gallery.php         ← Galerie-Seite
├── about.php           ← Über-mich-Seite
├── contact.php         ← Kontakt-Seite
├── .htaccess           ← Webserver-Sicherheitskonfiguration
│
├── config/
│   └── config.php      ← Globale Einstellungen (Pfade, Konstanten)
│
├── includes/
│   ├── functions.php   ← Alle Hilfsfunktionen (JSON lesen/schreiben)
│   ├── auth.php        ← Login/Logout-Funktionen
│   ├── header.php      ← HTML-Kopfbereich (wird überall eingebunden)
│   └── footer.php      ← HTML-Fußbereich
│
├── admin/
│   ├── index.php       ← Login-Seite
│   ├── dashboard.php   ← Übersichtsseite
│   ├── settings.php    ← Einstellungen (Farben, Schriften...)
│   ├── gallery.php     ← Galerie verwalten
│   ├── pages.php       ← Seiteninhalte bearbeiten
│   ├── upload.php      ← Upload-Handler (Bilder, Schriften)
│   ├── save.php        ← Speicher-Handler (alle Daten)
│   ├── logout.php      ← Ausloggen
│   └── partials/
│       └── sidebar.php ← Admin-Navigationsleiste
│
├── assets/
│   ├── css/
│   │   ├── style.css   ← Haupt-Stylesheet (Website-Design)
│   │   └── admin.css   ← Admin-Stylesheet
│   ├── js/
│   │   ├── main.js     ← Frontend-JavaScript (Animationen, Navigation...)
│   │   └── admin.js    ← Admin-JavaScript (Upload, Speichern...)
│   ├── images/         ← Statische Bilder (Logo etc.)
│   ├── fonts/          ← Eingebundene Schriftarten
│   └── uploads/
│       ├── images/     ← Hochgeladene Bilder (automatisch)
│       └── fonts/      ← Hochgeladene Schriftarten (automatisch)
│
└── content/
    ├── settings.json   ← Website-Einstellungen
    ├── gallery.json    ← Galerie-Daten
    └── pages/
        ├── home.json   ← Startseiten-Inhalt
        ├── about.json  ← Über-mich-Inhalt
        ├── gallery.json← Galerie-Seiten-Einstellungen
        └── contact.json← Kontakt-Seiten-Einstellungen
```

**Warum JSON und keine Datenbank?**

Eine echte Datenbank (wie MySQL) erfordert:
- Extra-Software
- Datenbankverbindung konfigurieren
- SQL-Kenntnisse

JSON-Dateien sind:
- ✅ Einfach zu verstehen (öffne sie mit einem Texteditor)
- ✅ Keine extra Software nötig
- ✅ Leicht zu sichern (einfach kopieren)
- ✅ Für kleine bis mittlere Projekte ausreichend

---

## ❓ Häufige Fragen (FAQ)

**Q: Kann ich mehrere Nutzer haben?**  
A: Im Moment unterstützt das CMS nur einen Admin-Nutzer. Für mehrere Nutzer wäre eine Datenbank nötig.

**Q: Wie sichere ich meine Website?**  
A: Kopiere einfach den gesamten Projektordner, besonders den `content/`-Ordner mit deinen Daten.

**Q: Meine Bilder laden langsam. Was kann ich tun?**  
A: Komprimiere deine Bilder vor dem Upload. Empfehlung: [Squoosh](https://squoosh.app/) (kostenlos, online).

**Q: Kann ich die Farben des Admin-Bereichs ändern?**  
A: Ja, editiere `assets/css/admin.css`. Oben findest du die CSS-Variablen.

**Q: Das Kontaktformular sendet keine E-Mails.**  
A: Prüfe, ob dein Hosting E-Mails über die PHP `mail()` Funktion unterstützt. Bei manchen Hostern musst du einen SMTP-Dienst einrichten (z.B. [PHPMailer](https://github.com/PHPMailer/PHPMailer)).

**Q: Kann ich eigene HTML/CSS-Elemente hinzufügen?**  
A: Absolut! Öffne die gewünschte `.php`-Datei und füge dein HTML zwischen den `include`-Zeilen ein.

**Q: Wie deaktiviere ich das Lade-Overlay?**  
A: In `assets/js/main.js`, entferne oder kommentiere die `initLoader()`-Zeile.

---

## 🎓 Für Dozentinnen und Dozenten

Dieses Projekt ist so gestaltet, dass Studierende:

1. **PHP verstehen** – Durch ausführliche Kommentare die erklären *warum* der Code so geschrieben ist
2. **MVC-ähnliche Struktur** – Trennung von Konfiguration, Logik und Präsentation
3. **Sicherheitsprinzipien** – XSS-Schutz, CSRF, sichere Passwort-Speicherung erklärt
4. **Dateisystembasiertes CMS** – Kein Datenbankwissen notwendig
5. **RESTful-ähnliche APIs** – Upload und Save-Handler als separate Endpunkte
6. **Responsive Design** – CSS Grid, Flexbox, Mobile-First erläutert

---

## 📄 Lizenz

MIT License – Kostenlos verwendbar für persönliche und kommerzielle Projekte.

---

*Erstellt mit ❤️ für Kunststudierende. Viel Erfolg mit deiner Website!*