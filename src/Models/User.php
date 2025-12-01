<?php
namespace Models;

use Core\Model;

class User extends Model {

    public function findByUsername($username) {
        $stmt = $this->db->query("SELECT * FROM users WHERE username = ?", [$username]);
        return $stmt->fetch();
    }

    public function create($username, $password, $role = 'verein', $club_id = null) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->db->query(
            "INSERT INTO users (username, password, role, club_id) VALUES (?, ?, ?, ?)",
            [$username, $hash, $role, $club_id]
        );
        return $this->db->lastInsertId();
    }

    public function updatePassword($id, $newPassword) {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->query("UPDATE users SET password = ? WHERE id = ?", [$hash, $id]);
    }

    // Holt alle User mit Vereinsnamen (für Admin Dashboard)
    public function getAllWithClubName() {
        $sql = "SELECT u.*, c.name as club_name
                FROM users u
                LEFT JOIN clubs c ON u.club_id = c.id
                ORDER BY u.username";
        return $this->db->query($sql)->fetchAll();
    }

    public function delete($id) {
        // Verhindern, dass man sich selbst oder den Haupt-Admin löscht, müsste im Controller geprüft werden
        return $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
    }
}
