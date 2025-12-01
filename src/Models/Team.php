<?php
namespace Models;

use Core\Model;

class Team extends Model {
    public function getByClub($clubId) {
        return $this->db->query("SELECT * FROM teams WHERE club_id = ?", [$clubId])->fetchAll();
    }

    public function getByCompetition($compId) {
         return $this->db->query("
            SELECT t.*, c.name as club_name
            FROM teams t
            JOIN clubs c ON t.club_id = c.id
            WHERE t.competition_id = ?
            ORDER BY c.name
        ", [$compId])->fetchAll();
    }

    public function create($name, $clubId, $compId) {
        $this->db->query(
            "INSERT INTO teams (name, club_id, competition_id) VALUES (?, ?, ?)",
            [$name, $clubId, $compId]
        );
        return $this->db->lastInsertId();
    }
}
