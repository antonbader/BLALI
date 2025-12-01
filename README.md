# BLALI - Blasrohr-Liga

## Installation

Diese Software ist so konzipiert, dass sie in einem beliebigen Verzeichnis auf einem Webserver installiert werden kann.

### Voraussetzungen
- Webserver (Apache, Nginx, etc.)
- PHP 7.4 oder höher
- PHP SQLite Erweiterung (Standardmäßig aktiviert)
- Schreibrechte auf dem Verzeichnis `data/` (wird automatisch erstellt)

### Installationsschritte

1. **Dateien kopieren**
   Kopieren Sie alle Dateien in das gewünschte Verzeichnis auf Ihrem Webserver.

2. **Webserver Konfiguration**
   Das Document Root des Webservers (oder Alias) sollte idealerweise auf den Ordner `public/` zeigen.
   Falls dies nicht möglich ist und die Installation in einem Unterordner erfolgt (z.B. `example.com/liga/public/`), passt sich die Software automatisch an.

   Stellen Sie sicher, dass `.htaccess` Dateien verarbeitet werden (`AllowOverride All` in Apache).

3. **Datenbank Initialisierung**
   Führen Sie einmalig das Installations-Skript aus, indem Sie es im Browser aufrufen (passen Sie den Pfad ggf. an):

   `http://ihre-domain.de/pfad-zur-installation/install.php`

   Dies erstellt die Datenbank im Ordner `data/` und legt den initialen Admin-User an.

4. **Sicherheit**
   Löschen Sie die Datei `install.php` nach erfolgreicher Installation.
   Sichern Sie den Ordner `data/` gegen direkten Web-Zugriff (z.B. via `.htaccess` `Deny from all` im `data` Ordner, falls dieser im Web-Root liegt). In der Standard-Struktur liegt `data/` parallel zu `public/` und ist somit ohnehin nicht direkt via Web erreichbar.

### Erster Login

- **URL**: `http://ihre-domain.de/pfad/public/`
- **Benutzer**: `admin`
- **Passwort**: `admin`

Bitte ändern Sie das Passwort umgehend nach dem ersten Login!

## Ordnerstruktur

- `public/`: Öffentlich zugängliche Dateien (index.php, CSS, JS).
- `src/`: Quellcode der Anwendung (MVC).
- `views/`: HTML Templates.
- `config/`: Konfiguration.
- `data/`: SQLite Datenbank (wird erstellt).

## Features

- MVC Architektur ohne Frameworks
- Rollenbasierte Zugriffsrechte (Admin, Verein)
- Automatische Spielplan-Erstellung (Round Robin)
- Ergebnis-Management mit Freigabe-Workflow
- Responsive Design (Mobile First)
