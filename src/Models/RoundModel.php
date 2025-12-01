<?php
namespace Models;

use Core\Model;

class RoundModel extends Model {

    public function getDatesByCompetition($compId) {
        return $this->db->query("
            SELECT round_number, match_date
            FROM round_dates
            WHERE competition_id = ?
            ORDER BY round_number
        ", [$compId])->fetchAll();
    }

    public function saveDate($compId, $round, $date) {
        // Prüfen ob existiert
        $exists = $this->db->query("
            SELECT id FROM round_dates
            WHERE competition_id = ? AND round_number = ?
        ", [$compId, $round])->fetch();

        if ($exists) {
            $this->db->query("
                UPDATE round_dates SET match_date = ?
                WHERE id = ?
            ", [$date, $exists['id']]);
        } else {
            $this->db->query("
                INSERT INTO round_dates (competition_id, round_number, match_date)
                VALUES (?, ?, ?)
            ", [$compId, $round, $date]);
        }
    }
}
