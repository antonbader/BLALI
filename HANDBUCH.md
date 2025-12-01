# Benutzerhandbuch - Blasrohr-Liga Verwaltungssystem

## Inhaltsverzeichnis

1.  [Einführung](#1-einführung)
2.  [Bereich für Öffentliche Besucher](#2-bereich-für-öffentliche-besucher)
    *   [2.1 Startseite und Navigation](#21-startseite-und-navigation)
    *   [2.2 Aktuelle Tabellen einsehen](#22-aktuelle-tabellen-einsehen)
    *   [2.3 Wettkampfpläne abrufen](#23-wettkampfpläne-abrufen)
    *   [2.4 Archivierte Saisons](#24-archivierte-saisons)
3.  [Bereich für Vereins-Administratoren](#3-bereich-für-vereins-administratoren)
    *   [3.1 Login und Dashboard](#31-login-und-dashboard)
    *   [3.2 Mannschaftsübersicht](#32-mannschaftsübersicht)
    *   [3.3 Ergebnisse erfassen (Nur Heimspiele)](#33-ergebnisse-erfassen-nur-heimspiele)
    *   [3.4 Status der Ergebnisse prüfen](#34-status-der-ergebnisse-prüfen)
4.  [Bereich für Administratoren](#4-bereich-für-administratoren)
    *   [4.1 System-Verwaltung und Login](#41-system-verwaltung-und-login)
    *   [4.2 Stammdatenpflege (Vereine & Benutzer)](#42-stammdatenpflege-vereine--benutzer)
    *   [4.3 Schützenverwaltung](#43-schützenverwaltung)
    *   [4.4 Wettbewerbsmanagement](#44-wettbewerbsmanagement)
        *   [4.4.1 Neuen Wettbewerb anlegen](#441-neuen-wettbewerb-anlegen)
        *   [4.4.2 Mannschaften zuweisen](#442-mannschaften-zuweisen)
        *   [4.4.3 Spielplan generieren (Round Robin)](#443-spielplan-generieren-round-robin)
    *   [4.5 Ergebnisverwaltung und Freigabe](#45-ergebnisverwaltung-und-freigabe)
    *   [4.6 Wettbewerbsstatus und Archivierung](#46-wettbewerbsstatus-und-archivierung)

---

## 1. Einführung

Dieses Handbuch dokumentiert umfassend die Bedienung des Blasrohr-Liga Verwaltungssystems. Die Funktionen sind streng nach den Benutzerrollen (Öffentlichkeit, Verein, Administrator) getrennt, um eine zielgerichtete Anleitung zu gewährleisten.

---

## 2. Bereich für Öffentliche Besucher

Dieser Bereich ist für jeden Besucher der Webseite ohne Anmeldung zugänglich. Er dient der Information über laufende und vergangene Wettbewerbe.

### 2.1 Startseite und Navigation
Die Startseite bietet einen sofortigen Überblick über die aktuell laufenden Wettbewerbe (Status "Aktiv"). Über die Navigationsleiste können Besucher zwischen der Startseite, der Login-Seite und dem Archiv wechseln.

### 2.2 Aktuelle Tabellen einsehen
Zu jedem aktiven Wettbewerb wird auf der Startseite oder über die Detailansicht die aktuelle Ligatabelle angezeigt.
*   **Vorgehen**: Klicken Sie auf den Namen eines Wettbewerbs, um zur Detailansicht zu gelangen.
*   **Daten**: Die Tabelle zeigt Platzierung, Mannschaftsname, Anzahl der Spiele, Siege, Niederlagen, Unentschieden, Ringzahl-Schnitt und Punkte.
*   **Sortierung**: Die Sortierung erfolgt primär nach Punkten, sekundär nach dem Ringschnitt.

### 2.3 Wettkampfpläne abrufen
Innerhalb der Wettbewerbsansicht ist der Reiter "Wettkampfplan" verfügbar.
*   **Filterung**: Der Plan zeigt alle Begegnungen, gruppiert nach Spieltagen (Runden).
*   **Ergebnisse**: Sobald ein Spiel stattgefunden hat und freigegeben wurde, wird das Ergebnis (z.B. "1500 : 1480") direkt in der Paarung angezeigt.
*   **Status**: Noch nicht ausgetragene Spiele sind ohne Ergebnis gelistet.

### 2.4 Archivierte Saisons
Wettbewerbe, die abgeschlossen sind, werden vom Administrator in das Archiv verschoben.
*   **Zugriff**: Klicken Sie in der Hauptnavigation auf "Archiv".
*   **Inhalt**: Das Archiv listet alle vergangenen Saisons auf. Durch Klick auf eine Saison können die Abschlusstabellen und alle Spielergebnisse permanent eingesehen werden.

---

## 3. Bereich für Vereins-Administratoren

Vereins-Administratoren verwalten die Belange ihres eigenen Vereins und sind für die Ergebnismeldung verantwortlich. Jeder Verein erhält genau einen Zugang.

### 3.1 Login und Dashboard
*   **Anmeldung**: Nutzen Sie den Link "Anmelden" oben rechts und geben Sie die vom Administrator erhaltenen Zugangsdaten ein.
*   **Dashboard**: Nach dem Login sehen Sie Ihre persönliche Übersicht. Diese enthält:
    *   **Offene Runden**: Eine Liste aller Begegnungen, die aktuell zur Austragung anstehen und an denen Ihr Verein beteiligt ist.
    *   **Mannschaftsübersicht**: Eine Auflistung aller Mannschaften Ihres Vereins, die in aktiven Wettbewerben gemeldet sind.

### 3.2 Mannschaftsübersicht
Hier sehen Sie, welche Mannschaften Ihres Vereins aktuell in welchen Ligen spielen. Diese Zuweisung erfolgt zentral durch den Administrator und kann vom Verein nur eingesehen, nicht aber geändert werden.

### 3.3 Ergebnisse erfassen (Nur Heimspiele)
Das wichtigste Recht des Vereins-Admins ist die Eingabe der Wettkampfergebnisse.

**Wichtiges Prinzip**: Nur die **Heimmannschaft** kann Ergebnisse eintragen. Die Gastmannschaft hat hierfür keine Berechtigung.

**Schritt-für-Schritt Anleitung:**
1.  Suchen Sie im Dashboard im Bereich "Offene Runden" die entsprechende Begegnung.
2.  Klicken Sie auf den Button **"Ergebnis eingeben"**. (Ist dieser ausgegraut, sind Sie die Gastmannschaft oder das Spiel ist nicht aktiv).
3.  Es öffnet sich das Erfassungsformular.
4.  **Kader-Auswahl (Heim & Gast)**: Wählen Sie aus den Dropdown-Menüs für jeden Startplatz den entsprechenden Schützen aus.
    *   Das System zeigt Ihnen nur Schützen an, die dem jeweiligen Verein zugeordnet sind.
    *   Stellen Sie sicher, dass Sie auch für den Gegner die korrekten Schützen auswählen, wie sie auf dem Schießzettel stehen.
5.  **Ringe eintragen**: Geben Sie neben jedem Schützen das geschossene Ringergebnis ein.
    *   Achten Sie auf exakte Übertragung.
    *   Es erfolgt keine Plausibilitätsprüfung auf Maximalwerte durch das System.
6.  **Absenden**: Klicken Sie unten auf **"Speichern & Einreichen"**.
7.  Das Ergebnis wird gespeichert und der Status der Begegnung wechselt auf "Wartet auf Freigabe".

### 3.4 Status der Ergebnisse prüfen
Nach der Einreichung können Sie das Ergebnis im Dashboard unter "Gespielte Begegnungen" sehen.
*   **Status 'Wartet auf Freigabe'**: Das Ergebnis liegt dem Administrator zur Prüfung vor. Änderungen sind jetzt nur noch durch den Administrator möglich.
*   **Status 'Bestätigt'**: Der Administrator hat das Ergebnis akzeptiert. Es fließt nun in die Tabelle ein.

---

## 4. Bereich für Administratoren

Administratoren haben die volle Kontrolle über das System, alle Daten und den Prozessablauf.

### 4.1 System-Verwaltung und Login
Melden Sie sich mit Ihrem Administrator-Konto an. Sie landen auf dem Admin-Dashboard. Dieses zeigt Ihnen prominent:
*   Anzahl der aktiven Wettbewerbe.
*   Anzahl der registrierten Vereine und Schützen.
*   **Wichtig**: Eine Liste "Offene Freigaben" mit Ergebnissen, die Ihre Aufmerksamkeit erfordern.

### 4.2 Stammdatenpflege (Vereine & Benutzer)
Die Basis des Systems sind Vereine und deren Benutzerkonten.

**Verein anlegen:**
1.  Menüpunkt "Vereine" wählen -> "Neuen Verein anlegen".
2.  Namen eingeben und speichern.

**Vereins-Admin anlegen:**
1.  Menüpunkt "Benutzer" wählen -> "Neuen Benutzer anlegen".
2.  Benutzernamen und Passwort vergeben.
3.  **Rolle**: Wählen Sie "Verein".
4.  **Zuordnung**: Wählen Sie im Dropdown den zugehörigen Verein aus. Ohne diese Zuordnung kann der Benutzer keine Ergebnisse eintragen.

### 4.3 Schützenverwaltung
Alle Sportler müssen zentral erfasst werden.
1.  Menüpunkt "Schützen" -> "Neuer Schütze".
2.  Geben Sie Vorname, Nachname und zwingend den **Verein** an.
3.  Optional können Sie Schützenpass-Nummern oder Geburtsjahre hinterlegen.
4.  Schützen können jederzeit bearbeitet oder einem anderen Verein zugewiesen werden (Vereinswechsel).

### 4.4 Wettbewerbsmanagement

#### 4.4.1 Neuen Wettbewerb anlegen
1.  Navigieren Sie zu "Wettbewerbe" -> "Neu erstellen".
2.  Geben Sie einen Namen (z.B. "Kreisliga A 2024") und die Saison an.
3.  Legen Sie die Anzahl der Runden fest (1 = nur Hinrunde, 2 = Hin- und Rückrunde).
4.  Der Wettbewerb wird im Status **"Geplant"** erstellt.

#### 4.4.2 Mannschaften zuweisen
Öffnen Sie die Detailansicht des geplanten Wettbewerbs ("Verwalten").
1.  Im Bereich "Teilnehmende Mannschaften" fügen Sie Teams hinzu.
2.  Wählen Sie den Verein aus und vergeben Sie einen Mannschaftsnamen (z.B. "SV Holzhausen I").
3.  Wiederholen Sie dies für alle Teilnehmer.
4.  **Achtung**: Für den Spielplan-Algorithmus wird eine gerade Anzahl an Mannschaften benötigt. Fügen Sie ggf. ein "Freilos"-Team hinzu, falls die Anzahl ungerade ist.

#### 4.4.3 Spielplan generieren (Round Robin)
Wenn alle Mannschaften angelegt sind:
1.  Klicken Sie in der Wettbewerbs-Verwaltung auf **"Wettkampfplan generieren"**.
2.  Bestätigen Sie den Vorgang.
3.  Das System erstellt alle Paarungen und setzt den Wettbewerbsstatus automatisch auf **"Aktiv"**.
4.  Ab jetzt ist der Wettbewerb öffentlich sichtbar und Vereine können Ergebnisse melden.

### 4.5 Ergebnisverwaltung und Freigabe
Dies ist eine fortlaufende Aufgabe während der Saison.

**Ergebnisse freigeben:**
1.  Prüfen Sie auf dem Dashboard die "Offenen Freigaben".
2.  Klicken Sie auf "Details", um die Ringzahlen zu kontrollieren.
3.  Ist alles korrekt, klicken Sie auf **"Freigeben"**. Die Tabelle wird sofort aktualisiert.

**Ergebnisse korrigieren:**
Sollte ein Verein falsche Daten übermittelt haben, können Sie vor oder nach der Freigabe eingreifen:
1.  Klicken Sie in der Ergebnis-Detailansicht auf **"Bearbeiten"**.
2.  Korrigieren Sie die Schützen oder Ringzahlen manuell.
3.  Speichern Sie die Änderung.

### 4.6 Wettbewerbsstatus und Archivierung
Sie steuern die Sichtbarkeit über den Status:
*   **Geplant**: Nur für Admins sichtbar. (Vorbereitungsphase)
*   **Aktiv**: Öffentlich sichtbar, Ergebnisse möglich. (Laufende Saison)
*   **Deaktiviert**: Unsichtbar für Öffentlichkeit und Vereine. Dient zum Pausieren oder Verstecken bei Problemen. Admins haben weiterhin Zugriff.
*   **Archiviert**: Öffentlich im Archiv lesbar (Read-Only). Keine Änderungen mehr möglich.

**Saisonabschluss:**
Wenn alle Spiele absolviert sind, ändern Sie den Status manuell auf **"Archiviert"**. Damit ist die Saison offiziell beendet.
