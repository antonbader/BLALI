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

    public function getAllWithDetails() {
        return $this->db->query("
            SELECT t.*, c.name as club_name, comp.name as comp_name, comp.season
            FROM teams t
            JOIN clubs c ON t.club_id = c.id
            JOIN competitions comp ON t.competition_id = comp.id
            ORDER BY comp.created_at DESC, c.name, t.name
        ")->fetchAll();
    }

    public function getById($id) {
        return $this->db->query("
            SELECT t.*, c.name as club_name
            FROM teams t
            JOIN clubs c ON t.club_id = c.id
            WHERE t.id = ?
        ", [$id])->fetch();
    }

    public function update($id, $name, $clubId, $compId) {
        $this->db->query("UPDATE teams SET name = ?, club_id = ?, competition_id = ? WHERE id = ?", [$name, $clubId, $compId, $id]);
    }

    public function delete($id) {
        $this->db->query("DELETE FROM teams WHERE id = ?", [$id]);
    }
}
