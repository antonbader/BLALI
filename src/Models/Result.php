<?php
namespace Models;

use Core\Model;

class Result extends Model {

    public function save($matchId, $teamId, $shooterId, $rings) {
        $this->db->query(
            "INSERT INTO results (match_id, team_id, shooter_id, rings) VALUES (?, ?, ?, ?)",
            [$matchId, $teamId, $shooterId, $rings]
        );
    }

    public function deleteByMatch($matchId) {
        $this->db->query("DELETE FROM results WHERE match_id = ?", [$matchId]);
    }
}
