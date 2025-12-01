# Blasrohr-Liga Verwaltungssystem (BLALI)

## 1. Einführung

Das Blasrohr-Liga Verwaltungssystem (BLALI) ist eine spezialisierte Webanwendung zur Organisation und Durchführung von Blasrohr-Wettkämpfen im Ligen-Betrieb. Die Software ermöglicht die vollständige Verwaltung von Vereinen, Schützen, Mannschaften sowie die automatisierte Erstellung von Spielplänen und die Erfassung von Wettkampfergebnissen.

Die Anwendung wurde als native PHP-Lösung konzipiert und verzichtet bewusst auf große externe Frameworks, um eine maximale Flexibilität, Performance und einfache Anpassbarkeit zu gewährleisten. Die Architektur folgt dem Model-View-Controller (MVC) Entwurfsmuster.

## 2. Systemanforderungen

Um das System erfolgreich zu betreiben, muss die Serverumgebung folgende Voraussetzungen erfüllen:

*   **Webserver**: Apache, Nginx oder IIS
*   **PHP-Version**: 7.4 oder höher
*   **PHP-Erweiterungen**:
    *   `pdo` (PHP Data Objects)
    *   `pdo_mysql` (für MySQL/MariaDB Nutzung)
    *   `pdo_sqlite` (für SQLite Nutzung)
*   **Dateiberechtigungen**: Schreibrechte für den Webserver im Verzeichnis `data/` (wird bei Bedarf erstellt) und `config/` (falls Schreibvorgänge nötig sind, standardmäßig nur Lesen).

## 3. Installation

Die Installation ist so konzipiert, dass sie flexibel in jedem Verzeichnis (Root oder Unterverzeichnis) erfolgen kann.

### Schritt 1: Dateiübertragung
Kopieren Sie sämtliche Projektdateien in das gewünschte Verzeichnis auf Ihrem Webserver.

### Schritt 2: Webserver-Konfiguration
Das `Document Root` Ihres Webservers sollte idealerweise auf den Ordner `public/` zeigen, um die Sicherheit der Anwendungsdateien zu maximieren.
Falls dies nicht möglich ist (z.B. bei Shared Hosting in einem Unterverzeichnis), erkennt die Anwendung ihren Basispfad automatisch.

**Apache:**
Stellen Sie sicher, dass das Modul `mod_rewrite` aktiviert ist und `.htaccess`-Dateien verarbeitet werden (`AllowOverride All`).

### Schritt 3: Datenbank-Konfiguration
Das System unterstützt sowohl MySQL (Standard) als auch SQLite. Die Konfiguration erfolgt in der Datei `config/db.php`.

1.  Öffnen Sie die Datei `config/db.php`.
2.  Wählen Sie Ihren Datenbank-Typ:

    **Option A: MySQL / MariaDB**
    Setzen Sie `'type'` auf `'mysql'` und tragen Sie Ihre Zugangsdaten ein:
    ```php
    return [
        'type' => 'mysql',
        'host' => 'localhost',     // Datenbank-Host
        'dbname' => 'blasrohr_db', // Datenbank-Name
        'user' => 'db_user',       // Datenbank-Benutzer
        'pass' => 'geheim',        // Datenbank-Passwort
        // ...
    ];
    ```

    **Option B: SQLite**
    Setzen Sie `'type'` auf `'sqlite'`. Die Datenbankdatei wird standardmäßig im Ordner `data/` erstellt.
    ```php
    return [
        'type' => 'sqlite',
        // ...
        'sqlite_file' => __DIR__ . '/../data/blasrohr.sqlite',
    ];
    ```

### Schritt 4: Initialisierung
Rufen Sie das Installationsskript über Ihren Browser auf, um die Datenbanktabellen anzulegen und den ersten Administrator zu erstellen:

`http://<ihre-domain>/<pfad-zur-installation>/install.php`

Folgen Sie den Anweisungen auf dem Bildschirm. Nach erfolgreicher Installation wird ein Standard-Administrator angelegt.

### Schritt 5: Abschluss und Sicherheit
Nach der erfolgreichen Installation müssen folgende Schritte zur Sicherheit des Systems durchgeführt werden:
1.  **Löschen** Sie die Datei `install.php` vom Server.
2.  Stellen Sie sicher, dass der Ordner `data/` (falls vorhanden und außerhalb des Webroots) nicht öffentlich zugänglich ist, oder durch eine `.htaccess` Datei geschützt ist (bei Apache).

## 4. Technische Architektur

Das Projekt ist modular nach dem MVC-Muster aufgebaut:

### Verzeichnisstruktur

*   `config/`: Enthält Konfigurationsdateien für Datenbank und globale Einstellungen.
*   `data/`: Speicherort für SQLite-Datenbankdateien (falls verwendet).
*   `public/`: Öffentlich zugängliches Verzeichnis. Enthält den Front-Controller (`index.php`) sowie statische Assets (CSS, JavaScript).
*   `src/`: Kern der Anwendung (Quellcode).
    *   `Controllers/`: Verarbeitet Benutzereingaben und steuert den Programmfluss.
    *   `Models/`: Repräsentiert die Datenstruktur und Geschäftslogik (Datenbankzugriffe).
    *   `Core/`: Basisklassen für Routing, Datenbankverbindung, Authentifizierung und Session-Management.
*   `views/`: HTML-Templates für die Ausgabe.

### Routing
Das Routing erfolgt über die `Core\Router`-Klasse. URLs folgen dem Schema `/Controller/Action/Parameter`. Die Anwendung ermittelt dynamisch das Basisverzeichnis, sodass keine festen Pfade in der Konfiguration hinterlegt werden müssen.

## 5. Erste Schritte

Melden Sie sich nach der Installation unter folgender URL an:

`http://<ihre-domain>/<pfad>/public/`

**Standard-Zugangsdaten:**
*   Benutzer: `admin`
*   Passwort: `admin`

**Wichtig:** Ändern Sie das Passwort umgehend nach der ersten Anmeldung.
