# Kunst-Website CMS – Für Kunststudentinnen und Kunststudenten

**Ein einfaches, elegantes Content-Management-System für deine Kunst-Webseite.**

Gebaut für: Kunststudierende ohne viele Programmierkenntnisse 
Technologien: HTML, CSS, JavaScript, PHP (kein WordPress, keine Datenbank nötig!)

> Live-Demo: Klone das Repo und starte es lokal, um die Website auszuprobieren!

---

## Inhaltsverzeichnis

1. [Was ist das? (Für absolute Anfänger)](#was-ist-das-für-absolute-anfänger)
2. [Grundbegriffe erklärt](#grundbegriffe-erklärt)
3. [Was du bekommst](#was-du-bekommst)
4. [Voraussetzungen](#voraussetzungen)
5. [Server einrichten (Hosting-Anleitung)](#server-einrichten-hosting-anleitung)
6. [Installation (5 Minuten)](#installation-5-minuten)
7. [Erste Schritte im Admin-Bereich](#erste-schritte-im-admin-bereich)
8. [Seiten anpassen](#seiten-anpassen)
9. [Design anpassen](#design-anpassen)
10. [Eigene Schriftarten](#eigene-schriftarten)
11. [Galerie verwalten](#galerie-verwalten)
12. [Wie die Website technisch funktioniert](#wie-die-website-technisch-funktioniert)
13. [Projektstruktur erklärt (Datei für Datei)](#projektstruktur-erklärt-datei-für-datei)
14. [Für Fortgeschrittene](#für-fortgeschrittene)
15. [Häufige Fragen (FAQ)](#häufige-fragen-faq)
16. [Troubleshooting (Problemlösung)](#troubleshooting-problemlösung)

---

## Was ist das? (Für absolute Anfänger)

Dieses Projekt ist eine **fertige Kunst-Website** mit einem integrierten **CMS (Content Management System)**.

### Was bedeutet "CMS"?

Ein CMS ist wie ein **Bedienfeld für deine Website**. Stell dir vor: Deine Website ist ein Haus. Ohne CMS müsstest du jedes Mal die Wände einreißen und neu bauen, wenn du etwas ändern willst. Mit einem CMS hast du einen **Lichtschalter** – du klickst, und Dinge ändern sich.

Konkret: Du loggst dich in einen geschützten Admin-Bereich ein und kannst dort alle Texte, Bilder und Farben deiner Website über Formulare ändern – **ohne Code anfassen zu müssen**.

### Was bedeutet "Website hosten"?

Deine Website besteht aus Dateien (wie Word-Dokumente, nur für den Browser). Diese Dateien müssen auf einem **Server** liegen – einem Computer, der 24/7 eingeschaltet ist und die Dateien an Besucher ausliefert, wenn sie deine Webadresse aufrufen.

**Vergleich:** Denke an Netflix. Die Filme liegen auf Netflix-Servern. Wenn du einen Film anklickst, wird er zu dir gestreamt. Genauso liegen deine Website-Dateien auf einem Server, und wenn jemand `deine-domain.de` eingibt, werden die Dateien an den Browser des Besuchers geschickt.

### Warum kein WordPress?

| | Dieses CMS | WordPress |
|---|---|---|
| Datenbank nötig | Nein | Ja (MySQL) |
| Schwierigkeit | Einfach | Mittel |
| Anpassbar | Sehr | Sehr |
| Ladezeit | Schnell | Variiert |
| Code verstehen | Leicht lesbar | Komplex |
| Sicherheitsupdates | Kaum nötig | Regelmäßig nötig |
| Kosten Hosting | Günstiger | Teurer |

---

## Grundbegriffe erklärt

Bevor wir loslegen, hier die wichtigsten Begriffe, die dir immer wieder begegnen werden:

### Programmiersprachen in diesem Projekt

| Begriff | Was ist das? | Wozu braucht man es? | Wo findest du es? |
|---|---|---|---|
| **HTML** | Die "Sprache" für den **Inhalt** einer Webseite | Definiert *was* auf der Seite steht: Überschriften, Texte, Bilder, Links | Alle `.php`-Dateien enthalten HTML |
| **CSS** | Die "Sprache" für das **Aussehen** | Definiert *wie* es aussieht: Farben, Schriften, Abstände, Layout | `assets/css/style.css` |
| **JavaScript (JS)** | Die "Sprache" für **Interaktivität** | Macht die Seite "lebendig": Animationen, Klick-Reaktionen, Menü öffnen | `assets/js/main.js` |
| **PHP** | Eine **Server-Sprache** | Wird auf dem Server ausgeführt *bevor* die Seite an den Browser geschickt wird. Liest Daten, verarbeitet Formulare | Alle `.php`-Dateien |
| **JSON** | Ein **Datenformat** zum Speichern | Speichert deine Einstellungen und Inhalte als einfach lesbarer Text | Alle `.json`-Dateien in `content/` |

### Analogie: Eine Website ist wie ein Haus

```
HTML = Die Wände, Türen, Fenster (Struktur)
CSS = Die Farbe, Tapete, Möbel (Aussehen)
JS = Lichtschalter, Türklingel (Interaktion)
PHP = Der Architekt, der das Haus baut bevor du es siehst (Logik)
JSON = Die Bauanleitung mit allen Details (Daten)
```

### Weitere wichtige Begriffe

| Begriff | Erklärung |
|---|---|
| **Server** | Ein Computer, der immer an ist und deine Website-Dateien an Besucher ausliefert |
| **Domain** | Die Webadresse, z.B. `meine-kunst.de` |
| **Hosting** | Der Dienst, der dir einen Server zur Verfügung stellt |
| **FTP/SFTP** | Ein Programm zum Hochladen von Dateien auf den Server (wie USB-Stick, nur übers Internet) |
| **Browser** | Das Programm, mit dem du Websites anschaust (Chrome, Firefox, Safari) |
| **Frontend** | Das was der Besucher sieht (die Website) |
| **Backend** | Das was hinter den Kulissen passiert (Admin-Bereich, PHP-Code) |
| **Responsive** | Die Website passt sich automatisch an verschiedene Bildschirmgrößen an (Handy, Tablet, Desktop) |
| **Session** | Wie der Server sich merkt, dass du eingeloggt bist (wie ein Armband im Schwimmbad) |
| **CSRF-Token** | Ein Sicherheitscode, der verhindert, dass andere Websites Formulare auf deiner Seite absenden |
| **XSS-Schutz** | Verhindert, dass böswillige Besucher schädlichen Code in deine Website einschleusen |

---

## Was du bekommst

**4 fertige Webseiten:**
- **Startseite** – Mit großem Hero-Bild, Intro-Text, Galerie-Vorschau
- **Galerie** – Elegantes Grid-Layout mit Lightbox (Bild-Großansicht)
- **Über mich** – Dein Foto, Text, CV/Vita
- **Kontakt** – Formular das dir E-Mails schickt

**Admin-Bereich zum Verwalten:**
- Einstellungen (Name, Farben, Schriften, Social Media)
- Galerie (Bilder hochladen, sortieren, beschriften)
- Seiten (alle Texte bearbeiten)
- Sicheres Login-System

**Design-Features:**
- Responsive (funktioniert auf Handy, Tablet, Desktop)
- Elegante Animationen beim Scrollen
- Komplett anpassbare Farben
- Google Fonts + eigene Schriftarten hochladbar
- Lightbox für die Galerie

---

## Voraussetzungen

### Was brauche ich zum Hosten? (Website online stellen)

1. **Webhosting mit PHP** – Ein Hosting-Anbieter, der PHP unterstützt (die meisten tun das!)
2. **PHP Version 8.0 oder neuer** – Die Programmiersprache, in der das CMS geschrieben ist
3. **Schreibrechte auf dem Server** – Damit das CMS Dateien speichern kann (Bilder, Einstellungen)
4. *(Optional)* Apache-Webserver mit `mod_rewrite` für schönere URLs

> **Hinweis: Was ist PHP 8.0?** PHP ist die Programmiersprache, die auf dem Server läuft. Version 8.0 ist von 2020. Die meisten Hosting-Anbieter bieten mittlerweile PHP 8.1 oder 8.2 an – das ist noch besser!

### Was brauche ich zum lokalen Entwickeln? (Auf meinem Computer testen)

Wenn du die Website erst auf deinem eigenen Computer testen willst (empfohlen!), brauchst du ein Programm, das einen lokalen Webserver simuliert:

| Programm | System | Beschreibung |
|---|---|---|
| [XAMPP](https://www.apachefriends.org/) | Windows, Mac, Linux | Empfohlen – Am einfachsten zu installieren |
| [MAMP](https://www.mamp.info/) | Mac | Ebenfalls sehr einfach, schöne Oberfläche |
| [Laragon](https://laragon.org/) | Windows | Modern und schnell |

> **Hinweis: Was macht XAMPP?** XAMPP installiert einen Apache-Webserver, PHP und MySQL auf deinem Computer. Damit kannst du PHP-Websites lokal testen, ohne sie ins Internet hochzuladen. Es ist wie ein "Privat-Internet" nur für dich.

---

## Server einrichten (Hosting-Anleitung)

### Schritt 1: Einen Hosting-Anbieter wählen

Du brauchst **Webhosting mit PHP-Unterstützung**. Hier einige empfohlene Anbieter:

| Anbieter | Preis ab | PHP | Besonderheit |
|---|---|---|---|
| [Strato](https://www.strato.de) | ~3€/Monat | 8.x | Deutscher Anbieter, guter Support |
| [All-Inkl](https://all-inkl.com) | ~5€/Monat | 8.x | Sehr beliebt bei Webentwicklern |
| [IONOS](https://www.ionos.de) | ~4€/Monat | 8.x | Ehemals 1&1, großer Anbieter |
| [Hetzner](https://www.hetzner.com) | ~2€/Monat | 8.x | Technik-orientiert, günstig |
| [netcup](https://www.netcup.de) | ~3€/Monat | 8.x | Gutes Preis-Leistungs-Verhältnis |
| [Uberspace](https://uberspace.de) | Pay what you want | 8.x | Für Studierende ideal, sehr fair |

> **Hinweis: Tipp für Studierende:** Viele Hochschulen bieten kostenloses Webhosting für Studierende an! Frag bei deiner IT-Abteilung nach.

### Schritt 2: PHP-Version einstellen

Nach dem Kauf des Hostings musst du sicherstellen, dass **PHP 8.0 oder neuer** aktiviert ist.

**So geht's bei den meisten Anbietern:**
1. Logge dich in dein **Hosting-Control-Panel** ein (z.B. Plesk, cPanel, oder das eigene Panel des Anbieters)
2. Suche nach **"PHP"** oder **"PHP-Version"** in den Einstellungen
3. Wähle **PHP 8.1** oder **PHP 8.2** aus (je neuer, desto besser)
4. Speichern

```
Beispiel bei All-Inkl:
 → Einloggen auf kas.all-inkl.com
 → Domain → [deine Domain] → Einstellungen
 → PHP-Version → 8.2 auswählen → Speichern
```

### Schritt 3: Benötigte PHP-Module prüfen

Diese PHP-Module werden benötigt (sind bei den meisten Hostern bereits aktiviert):

| Modul | Wozu? | Normalerweise aktiv? |
|---|---|---|
| `json` | JSON-Dateien lesen/schreiben (unsere "Datenbank") | Ja |
| `fileinfo` | Dateitypen beim Upload prüfen (Sicherheit) | Ja (meistens) |
| `mbstring` | Umlaute (ä,ö,ü) korrekt verarbeiten | Ja (meistens) |
| `session` | Login-System (sich merken wer eingeloggt ist) | Ja |

> **Hinweis: Wie prüfe ich das?** Erstelle eine Datei `phpinfo.php` mit dem Inhalt `<?php phpinfo(); ?>` und lade sie auf deinen Server. Rufe sie im Browser auf. Du siehst dann alle aktiven Module. **Lösche die Datei danach wieder!** (Sie zeigt sensible Server-Informationen.)

### Schritt 4: Schreibrechte (Permissions) setzen

Dein CMS muss Dateien speichern können (Bilder, Einstellungen, Texte). Dafür brauchen bestimmte Ordner **Schreibrechte**.

**Was sind "Rechte" (Permissions)?**

Auf einem Server hat jede Datei und jeder Ordner Rechte, die bestimmen wer lesen, schreiben und ausführen darf. Das wird mit Zahlen angegeben:

| Zahl | Bedeutung |
|---|---|
| `644` | Datei: Besitzer kann lesen+schreiben, alle anderen nur lesen |
| `755` | Ordner: Besitzer kann alles, alle anderen können lesen+betreten |
| `775` | Ordner: Besitzer + Gruppe können alles, andere nur lesen |

**Diese Ordner brauchen Schreibrechte (755 oder 775):**

```
content/ ← Hier werden Einstellungen und Texte gespeichert
content/pages/ ← Hier liegen die Seiteninhalte (home.json, about.json, etc.)
assets/uploads/ ← Hier landen hochgeladene Dateien
assets/uploads/images/ ← Hochgeladene Bilder
assets/uploads/fonts/ ← Hochgeladene Schriftarten
```

**So setzt du Rechte per FTP (FileZilla):**
1. Rechtsklick auf den Ordner → **"Dateiberechtigungen"** (oder "Permissions")
2. Gib `755` ein
3. Aktiviere **"In Unterverzeichnisse einsteigen"**
4. Klicke OK

**So setzt du Rechte per SSH (Terminal):**
```bash
# Verbinde dich per SSH mit deinem Server
ssh benutzername@dein-server.de

# Navigiere zum Website-Ordner
cd /var/www/html/deine-website # oder public_html/

# Rechte setzen
chmod -R 755 content/
chmod -R 755 assets/uploads/
```

### Schritt 5: Domain einrichten (DNS)

Wenn du eine eigene Domain hast (z.B. `meine-kunst.de`), musst du sie auf deinen Server zeigen lassen:

1. **Beim Domain-Anbieter** (oder Hosting wenn beides beim selben Anbieter):
 - Suche **DNS-Einstellungen** oder **Nameserver**
 - Setze den **A-Record** auf die IP-Adresse deines Servers
 - Oder ändere die **Nameserver** auf die deines Hosting-Anbieters

2. **Beim Hosting-Anbieter:**
 - Füge die Domain in deinem Control-Panel hinzu
 - Weise sie dem Verzeichnis zu, in dem deine Website-Dateien liegen

> **Wichtig:** DNS-Änderungen können bis zu 24 Stunden dauern bis sie weltweit aktiv sind. Hab Geduld!

### Schritt 6: SSL-Zertifikat (HTTPS) einrichten

**Was ist SSL/HTTPS?** Das kleine Schloss-Symbol in der Browser-Adresszeile. Es verschlüsselt die Verbindung zwischen deiner Website und dem Besucher. **Pflicht für jede moderne Website!**

**So aktivierst du es:**
- Die meisten Hosting-Anbieter bieten kostenlose **Let's Encrypt**-Zertifikate an
- Im Control-Panel: Suche nach **"SSL"** oder **"HTTPS"** oder **"Let's Encrypt"**
- Aktiviere es für deine Domain
- Aktiviere **"HTTP auf HTTPS umleiten"** (damit auch `http://` automatisch zu `https://` wird)

### Zusammenfassung: Server-Checkliste

```
Hosting mit PHP 8.0+ gebucht
PHP-Version auf 8.1 oder 8.2 gesetzt
Domain eingerichtet und zeigt auf den Server
SSL/HTTPS aktiviert (Let's Encrypt)
Dateien hochgeladen (per FTP/SFTP)
Schreibrechte gesetzt (content/, assets/uploads/)
Standard-Passwort geändert (admin123 → eigenes Passwort!)
```

---

## Installation (5 Minuten)

### Option A: Auf echtem Webhosting (empfohlen)

1. **Dateien hochladen** – Alle Dateien via FTP/SFTP auf deinen Server laden
 - Empfohlene FTP-Programme: [FileZilla](https://filezilla-project.org/) (kostenlos)
 - Lade alle Dateien in das `public_html/` oder `www/` Verzeichnis

2. **Schreibrechte setzen** – Diese Ordner müssen schreibbar sein (Rechte: 755 oder 775):
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
 - **Passwort sofort ändern!**

### Option B: Lokal mit XAMPP

1. XAMPP installieren und starten (Apache + PHP)
2. Projektordner kopieren:
 - **Windows:** `C:\xampp\htdocs\meine-kunstseite\`
 - **Mac:** `/Applications/XAMPP/htdocs/meine-kunstseite/`
3. Browser öffnen: `http://localhost/meine-kunstseite/`
4. Admin: `http://localhost/meine-kunstseite/admin/`

> **Hinweis: Warum lokal testen?** Du kannst alles in Ruhe ausprobieren, ohne dass Besucher deine halbfertige Seite sehen. Wenn alles perfekt ist, lädst du die Dateien auf den echten Server.

---

## Erste Schritte im Admin-Bereich

Nach dem ersten Login siehst du das **Dashboard**. Folge dieser Reihenfolge:

### 1. Einstellungen anpassen
Gehe zu **Einstellungen** und ändere:
- **Seitenname** – Dein Name oder dein Künstlername
- **Tagline** – Dein Motto oder deine künstlerische Ausrichtung
- **E-Mail** – Hierhin kommen Kontaktformular-Nachrichten
- **Akzentfarbe** – Die Hauptfarbe deines Designs
- **Passwort** – Das Standard-Passwort `admin123` ändern!

### 2. Erste Bilder hochladen
Gehe zu **Galerie** und lade deine Kunstwerke hoch.
- Einfach in den Upload-Bereich klicken oder Bilder reinziehen
- Danach kannst du Titel und Beschreibung eingeben

### 3. Texte anpassen
Gehe zu **Seiten bearbeiten** und passe alle Texte an.

---

## Seiten anpassen

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

## Design anpassen

Alle Design-Einstellungen findest du unter **Einstellungen -> Design**.

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

## Eigene Schriftarten

Wenn du eine besondere Schriftart für dein Projekt hast, kannst du sie hochladen!

**So geht's:**
1. Gehe zu **Einstellungen -> Eigene Schriftart**
2. Ziehe deine Schriftartdatei in den Upload-Bereich
3. Die Schriftart wird automatisch eingebunden

**Unterstützte Formate:** `.ttf`, `.otf`, `.woff`, `.woff2`

**Warum verschiedene Formate?**
- `.woff2` – Modernster Standard, kleinste Datei → Empfohlen
- `.woff` – Älterer Standard, breite Browser-Unterstützung
- `.ttf`/`.otf` – Original-Schriftdateien (vom Designer)

---

## Galerie verwalten

### Bilder hochladen
- Klicke auf den Upload-Bereich oder ziehe Bilder direkt hinein
- Mehrere Bilder auf einmal hochladen möglich!
- Empfohlene Bildgröße: mindestens 1200px Breite für gute Qualität

### Bilder sortieren
- Halte ein Bild gedrückt und ziehe es an eine neue Position
- Die Reihenfolge wird automatisch gespeichert

### Bilder beschriften
- Klicke auf das (Bearbeiten)-Symbol bei einem Bild
- Gib Titel, Technik/Medium und Beschreibung ein

### Bild löschen
- Klicke auf das (Löschen)-Symbol bei einem Bild
- Das Bild wird vom Server gelöscht (nicht rückgängig zu machen!)

---

## Wie die Website technisch funktioniert

Dieser Abschnitt erklärt **Schritt für Schritt**, was passiert, wenn ein Besucher deine Website aufruft.

### Der Weg einer Anfrage (Request)

```
┌─────────────┐ ① Besucher tippt ┌──────────────┐
│ │ deine-domain.de │ │
│ Browser │ ───────────────────────────▶ │ Server │
│ (Besucher) │ │ (Webhost) │
│ │ ④ Fertige HTML-Seite │ │
│ │ ◀─────────────────────────── │ │
└─────────────┘ └──────┬───────┘
 │
 ② Server führt
 PHP-Code aus
 │
 ┌──────▼───────┐
 │ PHP liest │
 │ JSON-Dateien │
 │ (Einstellungen,│
 │ Texte, etc.) │
 └──────┬───────┘
 │
 ③ PHP baut die
 HTML-Seite
 zusammen
```

### Was passiert genau?

**Schritt ①** – Der Besucher tippt `deine-domain.de` in den Browser 
→ Der Browser fragt den Server: "Gib mir die Startseite!"

**Schritt ②** – Der Server empfängt die Anfrage 
→ Er schaut: Welche Datei soll ich ausliefern? Wenn keine Datei angegeben ist, nimmt er automatisch `index.php` (das ist eine Konvention, wie dass die Haustür immer vorne ist).

**Schritt ③** – PHP wird ausgeführt 
→ `index.php` wird Zeile für Zeile abgearbeitet:
```php
// Zuerst: Einstellungen laden (aus content/settings.json)
$settings = get_settings();

// Dann: Seiteninhalte laden (aus content/pages/home.json)
$homePage = get_page('home');

// Dann: Galerie-Daten laden (aus content/gallery.json)
$gallery = get_gallery();
```
→ PHP liest also die JSON-Dateien, in denen deine Texte und Einstellungen stehen.

**Schritt ④** – PHP baut die HTML-Seite zusammen 
→ Die PHP-Variablen werden in HTML eingesetzt:
```php
<!-- Aus PHP: -->
<h1><?= escape($homePage['hero_title']) ?></h1>

<!-- Wird zu fertigem HTML: -->
<h1>Kunst beginnt dort, wo die Sprache endet.</h1>
```
→ Der Browser bekommt **nur HTML, CSS und JavaScript** – kein PHP! PHP läuft nur auf dem Server.

### Das "Include"-System

Statt den gleichen Code (Header, Footer, Navigation) auf jeder Seite zu wiederholen, wird er **einmal geschrieben** und dann **eingebunden**:

```
index.php (Startseite):
┌────────────────────────┐
│ include 'header.php' │ ← Wird aus includes/ geladen
│ ──────────────────── │
│ Eigener Seiteninhalt │ ← Nur der Inhalt ist individuell
│ ──────────────────── │
│ include 'footer.php' │ ← Wird aus includes/ geladen
└────────────────────────┘

gallery.php, about.php, contact.php:
 → Alle nutzen denselben header.php und footer.php!
```

**Warum?** Wenn du z.B. einen neuen Menüpunkt hinzufügen willst, änderst du es nur in `header.php` – und es erscheint automatisch auf allen Seiten!

### Wie Daten gespeichert werden (JSON statt Datenbank)

Normalerweise nutzen Websites eine **Datenbank** (wie MySQL). Dieses CMS macht es einfacher: Es speichert alles in **JSON-Dateien**.

**Beispiel: `content/settings.json`:**
```json
{
 "site_name": "Dein Name",
 "site_tagline": "Deine Kunstrichtung",
 "accent_color": "#c4a882",
 "bg_color": "#f5f0eb",
 "text_color": "#1a1a1a"
}
```

**Was passiert wenn du im Admin etwas änderst:**
1. Du änderst den Seitennamen im Admin-Formular → Klickst "Speichern"
2. PHP empfängt die Formulardaten
3. PHP schreibt die neuen Daten in die JSON-Datei:
 ```php
 json_write('settings', $neueEinstellungen);
 // → Speichert nach content/settings.json
 ```
4. Beim nächsten Seitenaufruf liest PHP die aktualisierte JSON-Datei

### Das Login-System (Sessions)

**Wie funktioniert "eingeloggt bleiben"?**

```
1. Du gibst Benutzername + Passwort ein
2. PHP prüft: Stimmt das Passwort? (verschlüsselt verglichen!)
3. Bei Erfolg: PHP setzt eine "Session"
 → Wie ein Stempel auf deiner Hand im Club
 → Der Browser merkt sich diesen Stempel (als Cookie)
4. Bei jedem weiteren Admin-Aufruf:
 → PHP prüft: "Hat der Browser den Stempel?" → Ja → Zugang erlaubt
```

**Warum wird das Passwort verschlüsselt gespeichert?**
```php
// So wird das Passwort NICHT gespeichert: (SCHLECHT!)
"password": "meinPasswort123"

// So wird es gespeichert: (GUT!)
"password": "$2y$10$xJ8Qk... (langer verschlüsselter Hash)"

// Selbst wenn jemand die Datei stiehlt,
// kann er das Passwort nicht lesen!
```

---

## Projektstruktur erklärt (Datei für Datei)

```
meine-kunstseite/
│
|-- index.php ← STARTSEITE
│ Der Webserver öffnet automatisch diese Datei
│ wenn jemand deine Domain aufruft.
│ Enthält: Hero-Bereich, Über-mich-Vorschau, Galerie-Vorschau
│
|-- gallery.php ← GALERIE-SEITE
│ Zeigt alle Kunstwerke in einem Grid-Layout.
│ Bilder können angeklickt werden → Lightbox (Großansicht)
│
|-- about.php ← ÜBER-MICH-SEITE
│ Dein Porträt, Text über dich, Vita/Lebenslauf.
│ Layout passt sich an: Mit Bild = 2 Spalten, ohne = zentriert
│
|-- contact.php ← KONTAKT-SEITE
│ Kontaktformular das E-Mails versendet.
│ Hat Spam-Schutz (CSRF-Token) eingebaut
│
|-- .htaccess ← WEBSERVER-KONFIGURATION
│ Sicherheitsregeln für den Apache-Webserver.
│ Blockiert direkten Zugriff auf sensible Dateien
│
|-- config/
│ └── config.php ← ZENTRALE KONFIGURATION
│ Alle globalen Einstellungen an einem Ort:
│ - Pfade zu Ordnern (wo liegen Uploads? wo liegen Inhalte?)
│ - Erlaubte Dateitypen (Sicherheit: nur JPG/PNG/etc.)
│ - Maximale Upload-Größe (10 MB)
│ - Session-Name (für Login-System)
│ Warum eine separate Datei? → Änderungen nur an einem Ort nötig!
│
|-- includes/ ← WIEDERVERWENDBARE CODE-BAUSTEINE
│ │ Diese Dateien werden von anderen Dateien "eingebunden" (included).
│ │ Vorteil: Code nur einmal schreiben, überall nutzen!
│ │
│ ├── functions.php ← HILFSFUNKTIONEN (das "Schweizer Taschenmesser")
│ │ Enthält alle wichtigen Funktionen:
│ │ - json_read() / json_write() → JSON-Dateien lesen/schreiben
│ │ - get_settings() → Einstellungen laden
│ │ - get_page() → Seiteninhalt laden
│ │ - get_gallery() → Galerie-Daten laden
│ │ - escape() → Benutzereingaben sicher machen (XSS-Schutz)
│ │ - handle_upload() → Datei-Upload verarbeiten
│ │ "Funktion" = Ein Code-Block mit Name den du immer wieder aufrufen kannst
│ │
│ ├── auth.php ← AUTHENTIFIZIERUNG (Login-System)
│ │ - is_logged_in() → Prüft ob jemand eingeloggt ist
│ │ - require_login() → Blockiert Admin-Seite wenn nicht eingeloggt
│ │ - login() → Prüft Benutzername + Passwort
│ │ - logout() → Loggt aus (Session zerstören)
│ │ - change_password() → Passwort sicher ändern
│ │ Passwörter werden NIEMALS im Klartext gespeichert!
│ │
│ ├── header.php ← HTML-KOPFBEREICH (wird auf JEDER Seite eingebunden)
│ │ Enthält: <head>-Tag, Meta-Tags, CSS-Links, Google Fonts,
│ │ Navigation, Lade-Animation
│ │ Einmal ändern → ändert sich überall!
│ │
│ └── footer.php ← HTML-FUSSBEREICH (wird auf JEDER Seite eingebunden)
│ Enthält: Footer-Links, Social Media, Copyright,
│ JavaScript-Einbindung
│ JavaScript am Ende = Seite lädt schneller!
│
|-- admin/ ← ADMIN-BEREICH (geschützter Bereich)
│ │ Alle Dateien hier sind nur für eingeloggte Nutzer!
│ │
│ ├── index.php ← LOGIN-SEITE
│ │ Zeigt das Login-Formular. Hier gibt man
│ │ Benutzername und Passwort ein.
│ │
│ ├── dashboard.php ← ÜBERSICHTSSEITE (nach dem Login)
│ │ Zeigt eine Zusammenfassung: Wie viele Bilder,
│ │ welche Seiten vorhanden, Quick-Links
│ │
│ ├── settings.php ← EINSTELLUNGEN BEARBEITEN
│ │ Formulare für: Seitenname, Farben, Schriften,
│ │ Social-Media-Links, Passwort ändern
│ │
│ ├── gallery.php ← GALERIE VERWALTEN
│ │ Bilder hochladen, sortieren (Drag & Drop),
│ │ beschriften und löschen
│ │
│ ├── pages.php ← SEITENINHALTE BEARBEITEN
│ │ Texte aller Seiten (Start, Über mich, Kontakt) bearbeiten
│ │
│ ├── upload.php ← UPLOAD-HANDLER (Backend)
│ │ Verarbeitet Datei-Uploads (Bilder + Schriften).
│ │ Prüft Dateityp und Größe → Sicherheit!
│ │ "Handler" = Eine Datei die Aktionen ausführt (kein HTML)
│ │
│ ├── save.php ← SPEICHER-HANDLER (Backend)
│ │ Empfängt Formulardaten und speichert sie
│ │ in die JSON-Dateien
│ │
│ ├── logout.php ← AUSLOGGEN
│ │ Zerstört die Session und leitet zum Login weiter
│ │
│ └── partials/
│ └── sidebar.php ← ADMIN-NAVIGATIONSLEISTE
│ Wird auf jeder Admin-Seite eingebunden (wie header.php)
│
|-- assets/ ← ALLE "ASSETS" (Medien und Gestaltungsdateien)
│ │ "Assets" = Alles was nicht PHP-Logik ist
│ │
│ ├── css/ ← STYLESHEETS (Aussehen der Website)
│ │ ├── style.css ← HAUPT-STYLESHEET
│ │ │ Das Herzstück des Designs! Enthält:
│ │ │ - CSS-Variablen (Farben, Schriften, Abstände)
│ │ │ - Reset (alle Browser gleich machen)
│ │ │ - Layout (Grid, Flexbox, Container)
│ │ │ - Komponenten (Header, Hero, Galerie, Footer)
│ │ │ - Animationen (Scroll-Reveal, Hover-Effekte)
│ │ │ - Responsive Design (Handy-Anpassung)
│ │ │ ~1000 Zeilen mit ausführlichen Kommentaren!
│ │ │
│ │ └── admin.css ← ADMIN-STYLESHEET
│ │ Separates Design für den Admin-Bereich
│ │
│ ├── js/ ← JAVASCRIPT (Interaktivität)
│ │ ├── main.js ← FRONTEND-JAVASCRIPT
│ │ │ - Scroll-Animationen (Elemente einblenden)
│ │ │ - Header-Verhalten (Hintergrund beim Scrollen)
│ │ │ - Mobile Navigation (Hamburger-Menü)
│ │ │ - Lightbox (Galerie-Großansicht)
│ │ │ - Lade-Animation
│ │ │ - Kontaktformular (AJAX-Versand)
│ │ │
│ │ └── admin.js ← ADMIN-JAVASCRIPT
│ │ - Datei-Upload (Drag & Drop)
│ │ - Galerie sortieren (Drag & Drop)
│ │ - Formulare speichern
│ │ - Vorschau-Funktionen
│ │
│ ├── images/ ← STATISCHE BILDER
│ │ Logo, Favicon, etc. (von dir vorab platziert)
│ │
│ └── uploads/ ← HOCHGELADENE DATEIEN (vom CMS verwaltet)
│ ├── images/ ← Galerie-Bilder, Hero-Bilder, Porträtfotos
│ └── fonts/ ← Eigene Schriftarten (.woff2, .ttf, etc.)
│
|-- content/ ← INHALTSDATEN (unsere "Datenbank")
 │ Alles was du im Admin-Bereich änderst, wird hier gespeichert.
 │ Diese Dateien sind einfacher Text → leicht zu sichern!
 │
 ├── settings.json ← WEBSITE-EINSTELLUNGEN
 │ Name, Farben, Schriften, Social Media, Passwort (verschlüsselt)
 │
 ├── gallery.json ← GALERIE-DATEN
 │ Liste aller Bilder mit Titel, Beschreibung, Dateipfad
 │
 └── pages/ ← SEITENINHALTE
 ├── home.json ← Startseite (Hero-Titel, Untertitel, Über-mich-Text)
 ├── about.json ← Über-mich (Text, Bild, CV-Einträge)
 ├── gallery.json ← Galerie-Seite (Titel, Beschreibung)
 └── contact.json ← Kontakt-Seite (Text, Formular-Einstellungen)
```

### Warum JSON und keine Datenbank?

| | JSON-Dateien (dieses CMS) | MySQL-Datenbank (WordPress) |
|---|---|---|
| **Einrichtung** | Keine nötig! | Server installieren, DB erstellen, User anlegen |
| **Backup** | Ordner kopieren | SQL-Export erstellen, DB sichern |
| **Verstehen** | Mit Texteditor öffnen | SQL-Kenntnisse nötig |
| **Hosting-Kosten** | Günstiger (kein DB-Server) | DB-Server kostet extra |
| **Performance** | Für kleine Seiten perfekt | Für große Seiten besser |
| **Skalierung** | Bis ~100 Bilder super | Tausende Einträge kein Problem |

---

## Für Fortgeschrittene

### Design-Änderungen in CSS

Die Hauptstylesheet-Datei ist: `assets/css/style.css`

Am Anfang findest du die CSS-Variablen:
```css
:root {
 --accent: #c4a882; /* Akzentfarbe */
 --bg: #f5f0eb; /* Hintergrund */
 --text: #1a1a1a; /* Text */
 --font-heading: 'Playfair Display', serif;
 --font-body: 'Lato', sans-serif;
}
```

Diese Variablen werden vom PHP aus den Admin-Einstellungen gesetzt. Du kannst sie auch direkt hier ändern.

### Neue Seite hinzufügen

1. Neue PHP-Datei erstellen, z.B. `projekte.php`
2. Am Anfang einbinden:
 ```php
 <?php
 // Diese 4 Zeilen braucht JEDE neue Seite:
 define('CMS_ROOT', __DIR__); // Wo ist das Hauptverzeichnis?
 require_once __DIR__ . '/config/config.php'; // Konfiguration laden
 require_once __DIR__ . '/includes/functions.php'; // Hilfsfunktionen laden
 $settings = get_settings(); // Website-Einstellungen laden
 $pageTitle = 'Projekte'; // Seitentitel (für Browser-Tab)
 include __DIR__ . '/includes/header.php'; // HTML-Kopf + Navigation einbinden
 ?>
 ```
3. Deinen Inhalt als HTML schreiben
4. Am Ende: `<?php include __DIR__ . '/includes/footer.php'; ?>`
5. In `includes/header.php` die Navigation erweitern

### Galerie-Layout anpassen

Das Galerie-Grid wird in `assets/css/style.css` gesteuert:
```css
.gallery-grid {
 display: grid;
 /* auto-fill: So viele Spalten wie reinpassen */
 /* minmax: Mindestens 280px breit, maximal so breit wie möglich */
 grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
 gap: 1.5rem; /* Abstand zwischen den Kacheln */
}
```

Ändere `280px` um die Mindestbreite der Galerie-Kacheln anzupassen.

### Animationen

Alle Scroll-Animationen werden durch das `data-reveal` Attribut ausgelöst:
```html
<div data-reveal> <!-- Von unten einblenden -->
<div data-reveal="left"> <!-- Von links einblenden -->
<div data-reveal="right"> <!-- Von rechts einblenden -->
<div data-reveal data-delay="200"> <!-- 200ms verzögert -->
```

### Wie funktioniert das technisch?

```javascript
// In main.js:
// Der "Intersection Observer" beobachtet alle Elemente mit [data-reveal]
// Sobald ein Element in den sichtbaren Bereich scrollt,
// bekommt es die CSS-Klasse "is-visible" → CSS-Animation startet!
```

---

## Häufige Fragen (FAQ)

**Q: Kann ich mehrere Nutzer haben?** 
A: Im Moment unterstützt das CMS nur einen Admin-Nutzer. Für mehrere Nutzer wäre eine Datenbank nötig.

**Q: Wie sichere ich meine Website?** 
A: Kopiere einfach den gesamten Projektordner, besonders den `content/`-Ordner mit deinen Daten und den `assets/uploads/`-Ordner mit deinen Bildern.

**Q: Meine Bilder laden langsam. Was kann ich tun?** 
A: Komprimiere deine Bilder vor dem Upload. Empfehlung: [Squoosh](https://squoosh.app/) (kostenlos, online). Ideal: WebP-Format, max. 2000px Breite.

**Q: Kann ich die Farben des Admin-Bereichs ändern?** 
A: Ja, editiere `assets/css/admin.css`. Oben findest du die CSS-Variablen.

**Q: Das Kontaktformular sendet keine E-Mails.** 
A: Prüfe, ob dein Hosting E-Mails über die PHP `mail()` Funktion unterstützt. Bei manchen Hostern musst du einen SMTP-Dienst einrichten (z.B. [PHPMailer](https://github.com/PHPMailer/PHPMailer)). Siehe auch: Troubleshooting.

**Q: Kann ich eigene HTML/CSS-Elemente hinzufügen?** 
A: Absolut! Öffne die gewünschte `.php`-Datei und füge dein HTML zwischen den `include`-Zeilen ein.

**Q: Wie deaktiviere ich das Lade-Overlay?** 
A: In `assets/js/main.js`, entferne oder kommentiere die `initLoader()`-Zeile.

**Q: Welche PHP-Version brauche ich?** 
A: PHP 8.0 oder neuer. Du kannst die Version in deinem Hosting-Control-Panel einstellen (siehe Server-Einrichtung oben).

**Q: Muss ich Programmieren können?** 
A: Nein! Für die normale Nutzung (Texte ändern, Bilder hochladen, Farben anpassen) brauchst du **keinerlei Programmierkenntnisse**. Nur wenn du die Website grundlegend verändern willst (z.B. neue Seiten hinzufügen), brauchst du etwas HTML/CSS-Wissen.

---

## Troubleshooting (Problemlösung)

### "Weiße Seite" / Nichts wird angezeigt

**Ursache:** Meistens ein PHP-Fehler. 
**Lösung:**
1. PHP-Fehlermeldungen aktivieren – Erstelle eine `.user.ini` Datei im Hauptverzeichnis:
 ```ini
 display_errors = On
 error_reporting = E_ALL
 ```
2. Prüfe ob die PHP-Version mindestens 8.0 ist
3. Prüfe ob alle Dateien korrekt hochgeladen wurden

### "403 Forbidden" / Zugriff verweigert

**Ursache:** Falsche Dateirechte. 
**Lösung:**
- Dateien: `644`
- Ordner: `755`
- Upload-Ordner: `755` oder `775`

### "500 Internal Server Error"

**Ursache:** Fehler in der `.htaccess`-Datei oder PHP-Konfiguration. 
**Lösung:**
1. Benenne `.htaccess` temporär um (z.B. in `.htaccess.bak`)
2. Wenn die Seite dann funktioniert: `.htaccess`-Regeln einzeln testen
3. Manche Hoster erlauben kein `mod_rewrite` – frage beim Support nach

### Bilder werden nicht hochgeladen

**Ursache:** Fehlende Schreibrechte oder PHP-Upload-Limit. 
**Lösung:**
1. Prüfe Schreibrechte: `assets/uploads/images/` muss beschreibbar sein (755/775)
2. Prüfe PHP-Upload-Limit: Erstelle eine `.user.ini`:
 ```ini
 upload_max_filesize = 20M
 post_max_size = 25M
 ```

### Kontaktformular sendet keine Mails

**Ursache:** PHP `mail()` Funktion ist auf dem Server nicht konfiguriert. 
**Lösung:**
1. Frage deinen Hosting-Anbieter ob `mail()` unterstützt wird
2. Manche Hoster erfordern, dass du zuerst eine E-Mail-Adresse im Control-Panel anlegst
3. Alternative: Verwende einen externen Maildienst wie [Formspree](https://formspree.io/) (kostenlos)

---

## Für Dozentinnen und Dozenten

Dieses Projekt ist so gestaltet, dass Studierende:

1. **PHP verstehen** – Durch ausführliche Kommentare die erklären *warum* der Code so geschrieben ist
2. **MVC-ähnliche Struktur** – Trennung von Konfiguration (`config/`), Logik (`includes/`), und Präsentation (`.php`-Seiten)
3. **Sicherheitsprinzipien** – XSS-Schutz (`escape()`), CSRF-Tokens, sichere Passwort-Speicherung (`password_hash()`)
4. **Dateisystembasiertes CMS** – Kein Datenbankwissen notwendig, JSON als einfache Alternative
5. **RESTful-ähnliche APIs** – Upload und Save-Handler als separate Endpunkte
6. **Responsive Design** – CSS Grid, Flexbox, Mobile-First mit Kommentaren
7. **Moderne CSS-Features** – Custom Properties, `clamp()`, `aspect-ratio`, `backdrop-filter`
8. **JavaScript-Konzepte** – Intersection Observer, Fetch API, Event Delegation, Drag & Drop

### Lernziele die abgedeckt werden

| Thema | Wo im Projekt | Schwierigkeit |
|---|---|---|
| HTML-Grundlagen | Alle `.php`-Dateien | Einfach |
| CSS-Layouts (Grid, Flexbox) | `style.css` | Einfach |
| CSS-Variablen | `style.css` + `header.php` | Einfach |
| PHP-Grundlagen | `config.php`, `functions.php` | Einfach |
| Datei-I/O (Lesen/Schreiben) | `functions.php` | Einfach |
| Sessions & Authentifizierung | `auth.php` | Einfach |
| Datei-Upload | `upload.php`, `functions.php` | Einfach |
| Sicherheit (XSS, CSRF) | überall (escape(), Tokens) | Einfach |
| JavaScript DOM-Manipulation | `main.js` | Einfach |
| AJAX / Fetch API | `admin.js`, `contact.php` | Einfach |
| Responsive Design | `style.css` (@media) | Einfach |

---

## Lizenz

MIT License – Kostenlos verwendbar für persönliche und kommerzielle Projekte.

---

*Erstellt mit Sorgfalt für Kunststudierende. Viel Erfolg mit deiner Website!*
