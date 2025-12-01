<?php
namespace Core;

class Auth {
    // Prüft, ob Benutzer eingeloggt ist
    public static function check() {
        return Session::get('user_id') !== null;
    }

    // Prüft auf Admin-Rolle
    public static function isAdmin() {
        return self::check() && Session::get('user_role') === 'admin';
    }

    // Prüft auf Vereins-Admin-Rolle
    public static function isClubAdmin() {
        return self::check() && Session::get('user_role') === 'verein';
    }

    // Hole aktuelle User ID
    public static function id() {
        return Session::get('user_id');
    }

    // Hole Club ID des aktuellen Users (falls vorhanden)
    public static function clubId() {
        return Session::get('club_id');
    }

    // Login durchführen
    public static function login($user) {
        // Regenerate Session ID to prevent fixation
        session_regenerate_id(true);
        Session::set('user_id', $user['id']);
        Session::set('user_name', $user['username']);
        Session::set('user_role', $user['role']);
        Session::set('club_id', $user['club_id']);
    }

    // Logout
    public static function logout() {
        Session::destroy();
    }

    // Middleware-Funktion: Leitet um, wenn nicht eingeloggt
    public static function requireLogin() {
        if (!self::check()) {
            Session::setFlash('error', 'Bitte melden Sie sich an.');
            header('Location: ' . BASIS_URL . '/auth/login');
            exit;
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        if (!self::isAdmin()) {
            Session::setFlash('error', 'Zugriff verweigert. Nur für Administratoren.');
            header('Location: ' . BASIS_URL);
            exit;
        }
    }
}
