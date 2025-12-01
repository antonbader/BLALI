<?php
namespace Models;

use Core\Model;

class MatchModel extends Model {

    public function getById($id) {
        return $this->db->query("
            SELECT m.*,
                   t1.name as home_team, t1.club_id as home_club_id,
                   t2.name as guest_team, t2.club_id as guest_club_id,
                   c.max_rings, c.name as comp_name
            FROM matches m
            JOIN teams t1 ON m.home_team_id = t1.id
            JOIN teams t2 ON m.guest_team_id = t2.id
            JOIN competitions c ON m.competition_id = c.id
            WHERE m.id = ?
        ", [$id])->fetch();
    }

    public function getByCompetition($compId) {
        return $this->db->query("
            SELECT m.*,
                   t1.name as home_team,
                   t2.name as guest_team
            FROM matches m
            JOIN teams t1 ON m.home_team_id = t1.id
            JOIN teams t2 ON m.guest_team_id = t2.id
            WHERE m.competition_id = ?
            ORDER BY m.round_number, m.match_date
        ", [$compId])->fetchAll();
    }

    public function getOpenByClub($clubId) {
        return $this->db->query("
            SELECT m.*,
                   c.name as comp_name,
                   t1.name as home_team,
                   t2.name as guest_team
            FROM matches m
            JOIN competitions c ON m.competition_id = c.id
            JOIN teams t1 ON m.home_team_id = t1.id
            JOIN teams t2 ON m.guest_team_id = t2.id
            WHERE (t1.club_id = ? OR t2.club_id = ?)
              AND m.status = 'offen'
            ORDER BY m.round_number
        ", [$clubId, $clubId])->fetchAll();
    }

    public function getSubmitted() {
        return $this->db->query("
            SELECT m.*,
                   c.name as comp_name,
                   t1.name as home_team,
                   t2.name as guest_team
            FROM matches m
            JOIN competitions c ON m.competition_id = c.id
            JOIN teams t1 ON m.home_team_id = t1.id
            JOIN teams t2 ON m.guest_team_id = t2.id
            WHERE m.status = 'eingereicht'
            ORDER BY m.match_date DESC
        ")->fetchAll();
    }

    public function updateScore($id, $homePoints, $guestPoints, $homeRings, $guestRings) {
        $this->db->query("UPDATE matches SET
                     home_points = ?, guest_points = ?,
                     home_total_rings = ?, guest_total_rings = ?,
                     status = 'eingereicht', match_date = ?
                     WHERE id = ?",
                     [$homePoints, $guestPoints, $homeRings, $guestRings, date('Y-m-d'), $id]
        );
    }

    public function setStatus($id, $status) {
        $this->db->query("UPDATE matches SET status = ? WHERE id = ?", [$status, $id]);
    }

    public function create($compId, $homeId, $guestId, $round, $status = 'offen') {
        $this->db->query(
            "INSERT INTO matches (competition_id, home_team_id, guest_team_id, round_number, status) VALUES (?, ?, ?, ?, ?)",
            [$compId, $homeId, $guestId, $round, $status]
        );
    }

    public function deleteByCompetition($compId) {
         $this->db->query("DELETE FROM matches WHERE competition_id = ?", [$compId]);
    }
}
