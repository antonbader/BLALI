<?php
namespace Models;

use Core\Model;

class Shooter extends Model {
    public function getByClub($clubId, $activeOnly = false) {
        $sql = "SELECT * FROM shooters WHERE club_id = ?";
        if ($activeOnly) {
            $sql .= " AND status = 'aktiv'";
        }
        $sql .= " ORDER BY last_name, first_name";
        return $this->db->query($sql, [$clubId])->fetchAll();
    }

    public function getByTeam($teamId) {
        return $this->db->query("SELECT * FROM shooters WHERE team_id = ? AND status = 'aktiv' ORDER BY last_name, first_name", [$teamId])->fetchAll();
    }

    public function getAllWithClubAndTeam() {
        return $this->db->query("
            SELECT s.*, c.name as club_name, t.name as team_name
            FROM shooters s
            JOIN clubs c ON s.club_id = c.id
            LEFT JOIN teams t ON s.team_id = t.id
            ORDER BY c.name, s.last_name
        ")->fetchAll();
    }

    public function create($firstName, $lastName, $clubId, $teamId = null) {
        $this->db->query(
            "INSERT INTO shooters (first_name, last_name, club_id, team_id) VALUES (?, ?, ?, ?)",
            [$firstName, $lastName, $clubId, $teamId]
        );
        return $this->db->lastInsertId();
    }

    public function updateTeam($id, $teamId) {
        $this->db->query("UPDATE shooters SET team_id = ? WHERE id = ?", [$teamId, $id]);
    }

    public function toggleStatus($id) {
        $shooter = $this->db->query("SELECT status FROM shooters WHERE id = ?", [$id])->fetch();
        if ($shooter) {
            $newStatus = $shooter['status'] === 'aktiv' ? 'inaktiv' : 'aktiv';
            $this->db->query("UPDATE shooters SET status = ? WHERE id = ?", [$newStatus, $id]);
            return $newStatus;
        }
        return false;
    }

    public function getTopShooters($compId, $limit = 10) {
        return $this->db->query("
            SELECT s.first_name, s.last_name, c.name as club_name,
                   SUM(r.rings) as total_rings,
                   COUNT(r.id) as matches_count,
                   AVG(r.rings) as average
            FROM results r
            JOIN shooters s ON r.shooter_id = s.id
            JOIN clubs c ON s.club_id = c.id
            JOIN matches m ON r.match_id = m.id
            WHERE m.competition_id = ? AND m.status = 'bestaetigt'
            GROUP BY s.id
            ORDER BY total_rings DESC, average DESC
            LIMIT $limit
        ", [$compId])->fetchAll();
    }
}
