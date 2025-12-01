<?php
namespace Models;

use Core\Model;
use Core\Auth;

class AuditLog extends Model {
    public function log($action, $details = null) {
        $userId = Auth::id(); // Kann null sein, wenn System-Aktion oder nicht eingeloggt
        $this->db->query("INSERT INTO audit_logs (user_id, action, details) VALUES (?, ?, ?)", [$userId, $action, $details]);
    }
}
