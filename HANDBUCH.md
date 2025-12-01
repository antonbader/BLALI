# Benutzerhandbuch - Blasrohr-Liga V9.0

Willkommen beim Ligen-Management-System für die Blasrohr-Liga.

## Inhaltsverzeichnis
1. [Allgemeines](#allgemeines)
2. [Login & Erste Schritte](#login)
3. [Für Administratoren](#admin)
    - [Stammdaten verwalten](#stammdaten)
    - [Wettbewerb & Saison planen](#wettbewerb)
    - [Ergebnisse prüfen](#pruefung)
4. [Für Vereins-Admins](#verein)
    - [Dashboard](#dashboard)
    - [Ergebnisse eingeben](#ergebnisse)

---

<a name="allgemeines"></a>
## 1. Allgemeines
Diese Software dient zur Verwaltung von Blasrohr-Wettkämpfen im Ligen-Betrieb. Sie unterstützt die Verwaltung von Vereinen, Schützen, Mannschaften, Spielplänen und Ergebnissen.

<a name="login"></a>
## 2. Login & Erste Schritte
Rufen Sie die Startseite auf. Klicken Sie oben rechts auf **Anmelden**.
- **Administratoren**: Nutzen Sie Ihre zugewiesenen Admin-Daten.
- **Vereins-Admins**: Nutzen Sie die vom Administrator erhaltenen Zugangsdaten.

Nach dem ersten Login sollten Sie Ihr Passwort unter "Passwort ändern" aktualisieren.

<a name="admin"></a>
## 3. Für Administratoren

Das Admin-Dashboard erreichen Sie nach dem Login über den Menüpunkt **Admin Dashboard**.

<a name="stammdaten"></a>
### Stammdaten verwalten
Unter **Vereine & Benutzer**:
1. Legen Sie neue Vereine an.
2. Erstellen Sie Benutzer für diese Vereine (Rolle: Vereins-Admin). Diese Benutzer können später Ergebnisse für ihren Verein eintragen.

Unter **Schützen**:
1. Erfassen Sie alle Schützen und weisen Sie diese den Vereinen zu.
2. Schützen können auf "Inaktiv" gesetzt werden, wenn sie nicht mehr antreten.

<a name="wettbewerb"></a>
### Wettbewerb & Saison planen
Unter **Wettkampf-Planung**:
1. Erstellen Sie eine neue Saison (z.B. "Oberliga 2024").
2. Klicken Sie auf **Verwalten**.
3. Fügen Sie Mannschaften hinzu und weisen Sie diese einem Verein zu. **Wichtig**: Es wird eine gerade Anzahl an Mannschaften benötigt.
4. Klicken Sie auf **Wettkampfplan generieren**. Dies erstellt automatisch alle Paarungen für Hin- (und optional Rück-)Runde nach dem "Round Robin" Prinzip.

<a name="pruefung"></a>
### Ergebnisse prüfen
Sobald Vereine Ergebnisse eingetragen haben, erscheinen diese unter **Ergebnis-Freigabe**.
1. Klicken Sie auf **Details**, um die Einzelergebnisse der Schützen zu sehen.
2. Klicken Sie auf **Freigeben**, um das Ergebnis für die offizielle Tabelle zu übernehmen.
3. Sie können Ergebnisse auch **Bearbeiten** oder eine bereits erteilte Freigabe **Widerrufen**.

### Saison-Abschluss & Finals
Wenn die reguläre Saison beendet ist:
1. Gehen Sie in die **Wettkampf-Details**.
2. Klicken Sie auf **Finals generieren**, um Halbfinal-Paarungen (Top 4) zu erstellen.
3. Klicken Sie auf **Tabelle als CSV**, um den aktuellen Stand zu exportieren.

<a name="verein"></a>
## 4. Für Vereins-Admins

<a name="dashboard"></a>
### Dashboard
Nach dem Login landen Sie im **Vereins-Bereich**. Hier sehen Sie:
- Ihre offenen Spiele, für die noch Ergebnisse fehlen.
- Eine Übersicht Ihrer Mannschaften.

<a name="ergebnisse"></a>
### Ergebnisse eingeben
1. Klicken Sie bei einer offenen Begegnung auf **Ergebnisse eingeben**.
2. Wählen Sie für Heim- und Gastmannschaft die Schützen aus, die geschossen haben.
3. Tragen Sie die Ringzahlen ein.
4. Das System berechnet automatisch die Punkte (Top 3 Ergebnisse zählen).
5. Klicken Sie auf **Speichern & Einreichen**.
6. Das Ergebnis wird nun an den Administrator zur Prüfung gesendet.
