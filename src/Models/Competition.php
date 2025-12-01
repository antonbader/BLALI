<?php
namespace Models;

use Core\Model;

class Competition extends Model {

    public function create($name, $season, $rounds = 1) {
        $max_rings = 999999; // De facto kein Limit
        $this->db->query(
            "INSERT INTO competitions (name, season, rounds, max_rings) VALUES (?, ?, ?, ?)",
            [$name, $season, $rounds, $max_rings]
        );
        return $this->db->lastInsertId();
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM competitions ORDER BY created_at DESC")->fetchAll();
    }

    public function getById($id) {
        return $this->db->query("SELECT * FROM competitions WHERE id = ?", [$id])->fetch();
    }

    // Teams für einen Wettkampf
    public function getTeams($competitionId) {
        return $this->db->query("
            SELECT t.*, c.name as club_name
            FROM teams t
            JOIN clubs c ON t.club_id = c.id
            WHERE t.competition_id = ?
            ORDER BY c.name
        ", [$competitionId])->fetchAll();
    }

    public function addTeam($name, $clubId, $competitionId) {
        $this->db->query(
            "INSERT INTO teams (name, club_id, competition_id) VALUES (?, ?, ?)",
            [$name, $clubId, $competitionId]
        );
    }

    public function deleteTeam($id) {
        $this->db->query("DELETE FROM teams WHERE id = ?", [$id]);
    }

    // Wettkampfplan Generierung (Round Robin)
    public function generateSchedule($competitionId) {
        $teams = $this->getTeams($competitionId);
        $numTeams = count($teams);

        if ($numTeams < 2) return false;

        // Wenn ungerade, Dummy-Team hinzufügen (hier: Warnung oder Fehler, da laut Plan gerade Anzahl gefordert)
        // Plan sagt: "Sicherstellen, dass nur eine gerade Anzahl an Mannschaften zugelassen wird"
        if ($numTeams % 2 != 0) {
            throw new \Exception("Ungerade Anzahl an Mannschaften. Bitte eine Mannschaft hinzufügen oder entfernen.");
        }

        // Alte Matches löschen? Nur wenn noch keine Ergebnisse da sind.
        // Wir gehen davon aus, dass dies nur initial passiert.
        $this->db->query("DELETE FROM matches WHERE competition_id = ?", [$competitionId]);

        $rounds = $numTeams - 1; // Anzahl Spieltage pro Runde (Hinrunde)

        // Circle Method
        // Indizes der Teams
        $teamIndices = array_column($teams, 'id');

        $matches = [];

        // Hinrunde
        for ($r = 0; $r < $rounds; $r++) {
            for ($i = 0; $i < $numTeams / 2; $i++) {
                $home = $teamIndices[$i];
                $guest = $teamIndices[$numTeams - 1 - $i];

                // Match erstellen
                // Runde = $r + 1
                $matches[] = [
                    'comp_id' => $competitionId,
                    'home' => $home,
                    'guest' => $guest,
                    'round' => $r + 1
                ];
            }

            // Rotation (Erstes Element bleibt fix, Rest rotiert)
            // [0, 1, 2, 3] -> [0, 3, 1, 2]
            $first = array_shift($teamIndices);
            $last = array_pop($teamIndices);
            array_unshift($teamIndices, $last);
            array_unshift($teamIndices, $first);
        }

        // Rückrunde?
        $comp = $this->getById($competitionId);
        if ($comp['rounds'] > 1) {
             foreach ($matches as $m) {
                 // Einfach Heim/Gast tauschen, Runde erhöhen
                 $newMatch = $m;
                 $newMatch['home'] = $m['guest'];
                 $newMatch['guest'] = $m['home'];
                 $newMatch['round'] = $m['round'] + $rounds;
                 $matches[] = $newMatch;
             }
        }

        // Speichern
        $sql = "INSERT INTO matches (competition_id, home_team_id, guest_team_id, round_number, status) VALUES (?, ?, ?, ?, 'offen')";
        $stmt = $this->db->getConnection()->prepare($sql);

        foreach ($matches as $m) {
            $stmt->execute([$m['comp_id'], $m['home'], $m['guest'], $m['round']]);
        }

        // Status Update
        $this->db->query("UPDATE competitions SET status = 'aktiv' WHERE id = ?", [$competitionId]);

        return true;
    }

}
