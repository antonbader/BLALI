# Benutzerhandbuch - Blasrohr-Liga Verwaltungssystem

## Inhaltsverzeichnis

1.  [Einführung](#1-einführung)
2.  [Rollen und Berechtigungen](#2-rollen-und-berechtigungen)
3.  [Wettbewerbs-Lebenszyklus](#3-wettbewerbs-lebenszyklus)
4.  [Anleitung für Administratoren](#4-anleitung-für-administratoren)
    *   [Erste Schritte und Login](#41-erste-schritte-und-login)
    *   [Stammdatenverwaltung](#42-stammdatenverwaltung)
    *   [Wettbewerbsplanung](#43-wettbewerbsplanung)
    *   [Spielpläne und Tabellen](#44-spielpläne-und-tabellen)
    *   [Ergebnisfreigabe](#45-ergebnisfreigabe)
    *   [Saisonabschluss und Archivierung](#46-saisonabschluss-und-archivierung)
5.  [Anleitung für Vereins-Administratoren](#5-anleitung-für-vereins-administratoren)
    *   [Übersicht](#51-übersicht)
    *   [Ergebniserfassung](#52-ergebniserfassung)
6.  [Öffentlicher Bereich](#6-öffentlicher-bereich)

---

## 1. Einführung

Dieses Handbuch dokumentiert die Bedienung des Blasrohr-Liga Verwaltungssystems. Die Software dient der Organisation von Ligabetrieben, der Verwaltung von Mitgliederdaten und der Erfassung sowie Auswertung von Wettkampfergebnissen.

## 2. Rollen und Berechtigungen

Das System unterscheidet zwischen drei grundlegenden Zugriffsebenen:

*   **Administrator**: Hat vollen Zugriff auf alle Funktionen. Er verwaltet Stammdaten (Vereine, Schützen), erstellt Wettbewerbe, generiert Spielpläne und gibt Ergebnisse frei.
*   **Vereins-Administrator**: Ein Benutzerkonto, das einem spezifischen Verein zugeordnet ist. Diese Rolle kann Ergebnisse für eigene Heimspiele erfassen und den eigenen Kader einsehen.
*   **Gast (Öffentlichkeit)**: Nicht angemeldete Benutzer können Tabellen, Spielpläne und Archive einsehen, jedoch keine Daten ändern.

## 3. Wettbewerbs-Lebenszyklus

Jeder Wettbewerb durchläuft im System einen definierten Lebenszyklus, der den Zugriff und die Sichtbarkeit steuert:

1.  **Geplant**: Der Wettbewerb wird erstellt und konfiguriert (Teams zuweisen, Einstellungen vornehmen). Er ist für die Öffentlichkeit und Vereine noch nicht sichtbar. Nur Administratoren haben Zugriff.
2.  **Aktiv**: Der Wettkampfplan wurde generiert und die Saison läuft. Ergebnisse können von Vereinen eingetragen werden. Tabellen und Pläne sind öffentlich sichtbar.
3.  **Deaktiviert**: Der Wettbewerb ist pausiert oder vorläufig beendet. Er ist für die Öffentlichkeit und in den Vereins-Dashboards nicht mehr sichtbar. Administratoren haben weiterhin vollen Zugriff zur Nachbearbeitung.
4.  **Archiviert**: Der Wettbewerb ist endgültig abgeschlossen. Er wird in den öffentlichen Bereich "Archiv" verschoben und ist dort als historische Referenz (Read-Only) einsehbar.

## 4. Anleitung für Administratoren

### 4.1 Erste Schritte und Login

Rufen Sie die Startseite der Anwendung auf und klicken Sie oben rechts auf "Anmelden". Verwenden Sie Ihre Administrator-Zugangsdaten. Nach dem Login gelangen Sie auf das Admin-Dashboard, welches Ihnen offene Aufgaben (z.B. ausstehende Ergebnisfreigaben) anzeigt.

### 4.2 Stammdatenverwaltung

Bevor ein Wettbewerb starten kann, müssen die Grunddaten im System hinterlegt werden.

**Vereine anlegen:**
Navigieren Sie zu "Vereine & Benutzer". Erstellen Sie hier neue Vereine mit Namen und optionalem Logo.

**Benutzerkonten erstellen:**
Erstellen Sie für jeden Verein ein Benutzerkonto. Wählen Sie dabei die Rolle "Vereins-Admin" und weisen Sie den Benutzer dem entsprechenden Verein zu. Dies ermöglicht dem Verein später die eigenständige Ergebniseingabe.

**Schützen verwalten:**
Unter dem Menüpunkt "Schützen" erfassen Sie alle teilnehmenden Sportler. Jeder Schütze muss zwingend einem Verein zugeordnet werden.
*Hinweis:* Um einen Schützen in Wettkämpfen einer Mannschaft zuzuordnen, ist die Vereinszugehörigkeit die Basis.

### 4.3 Wettbewerbsplanung

Navigieren Sie zum Bereich "Wettkampf-Planung", um eine neue Saison zu starten.

1.  **Erstellen**: Klicken Sie auf "Neuen Wettbewerb erstellen", vergeben Sie einen Namen (z.B. "Oberliga 2024") und definieren Sie die Anzahl der Durchgänge. Der Status ist zunächst "Geplant".
2.  **Teams verwalten**: In der Detailansicht des Wettbewerbs können Sie Mannschaften hinzufügen.
    *   Wählen Sie einen Verein aus und vergeben Sie einen Mannschaftsnamen.
    *   **Wichtig**: Achten Sie darauf, dass die Anzahl der teilnehmenden Mannschaften gerade ist, um einen reibungslosen Spielplan ("Round Robin") zu gewährleisten.

### 4.4 Spielpläne und Tabellen

Sobald alle Mannschaften angelegt sind, können Sie den Spielplan erstellen.

1.  Klicken Sie in der Wettbewerbsverwaltung auf "Wettkampfplan generieren".
2.  Das System berechnet automatisch alle Paarungen für die Hin- (und optional Rück-)Runde nach dem Prinzip "Jeder gegen Jeden".
3.  Mit der Generierung wechselt der Status des Wettbewerbs automatisch auf "Aktiv". Ab diesem Zeitpunkt können Ergebnisse erfasst werden.

### 4.5 Ergebnisfreigabe

Eingereichte Ergebnisse von Vereinen erscheinen auf Ihrem Dashboard unter "Offene Freigaben".

1.  Prüfen Sie die eingereichten Ringzahlen. Durch Klick auf "Details" sehen Sie die Einzelergebnisse der Schützen.
2.  Klicken Sie auf "Freigeben", um das Ergebnis offiziell zu bestätigen. Erst danach wird die Ligatabelle aktualisiert.
3.  Falls Korrekturen nötig sind, können Sie als Administrator die Ergebnisse jederzeit bearbeiten ("Ergebnis bearbeiten"), auch nach der Freigabe.

### 4.6 Saisonabschluss und Archivierung

Nach Abschluss aller Begegnungen:
1.  Prüfen Sie, ob alle Ergebnisse vorliegen und freigegeben sind.
2.  Ändern Sie den Status des Wettbewerbs manuell auf "Archiviert". Damit verschwindet der Wettbewerb von der Startseite und ist nur noch über das Archiv erreichbar.

## 5. Anleitung für Vereins-Administratoren

### 5.1 Übersicht

Nach der Anmeldung gelangen Sie in Ihren Vereinsbereich. Hier sehen Sie:
*   Eine Übersicht Ihrer Mannschaften.
*   Offene Begegnungen, für die noch kein Ergebnis vorliegt.
*   Den Status Ihrer eingereichten Ergebnisse (z.B. "Wartet auf Freigabe").

### 5.2 Ergebniserfassung

Das Recht zur Ergebniseingabe liegt ausschließlich bei der **Heimmannschaft**. Als Gastmannschaft können Sie die Ergebnisse lediglich einsehen, sobald diese vom Gegner oder Administrator eingetragen wurden.

1.  Klicken Sie bei der entsprechenden Begegnung auf "Ergebnis eingeben".
2.  **Kader wählen**: Wählen Sie für beide Mannschaften (Heim und Gast) die Schützen aus, die an diesem Wettkampf teilgenommen haben. Die Auswahl beschränkt sich auf Schützen des jeweiligen Vereins.
3.  **Ringzahlen erfassen**: Tragen Sie die erzielten Ringzahlen für jeden Schützen ein. Es erfolgt keine automatische Obergrenzen-Prüfung, achten Sie daher auf korrekte Eingaben gemäß Schießzettel.
4.  **Speichern**: Klicken Sie auf "Speichern & Einreichen". Das Ergebnis wird nun an den Administrator übermittelt. Eine nachträgliche Änderung durch den Verein ist nicht mehr möglich. Wenden Sie sich bei Fehlern an den Administrator.

## 6. Öffentlicher Bereich

Besucher der Webseite haben ohne Anmeldung Zugriff auf:
*   **Aktuelle Tabellen**: Echtzeit-Stand aller aktiven Ligen.
*   **Wettkampfpläne**: Übersicht aller anstehenden und vergangenen Begegnungen.
*   **Archiv**: Zugriff auf Tabellen und Ergebnisse vergangener, archivierter Spielzeiten.
