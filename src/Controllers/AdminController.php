<?php
namespace Controllers;

use Core\Controller;
use Core\Auth;
use Core\Session;
use Models\User;
use Models\Shooter;
use Models\AuditLog;

class AdminController extends Controller {

    public function __construct() {
        Auth::requireAdmin();
    }

    public function dashboard() {
        $this->view('admin/dashboard');
    }

    public function clubs() {
        $db = \Core\Database::getInstance();
        $clubs = $db->query("SELECT * FROM clubs ORDER BY name")->fetchAll();
        $userModel = new User();
        $users = $userModel->getAllWithClubName();
        $this->view('admin/clubs', ['clubs' => $clubs, 'users' => $users]);
    }

    public function createClub() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                Session::setFlash('error', 'Ungültige Sitzung.');
                $this->redirect('/admin/clubs');
            }

            $name = $this->input('name');
            if (!empty($name)) {
                $db = \Core\Database::getInstance();
                try {
                    $db->query("INSERT INTO clubs (name) VALUES (?)", [$name]);
                    (new AuditLog())->log('verein_erstellt', $name);
                    Session::setFlash('success', 'Verein angelegt.');
                } catch (\Exception $e) {
                    Session::setFlash('error', 'Fehler: Name existiert evtl. schon.');
                }
            }
            $this->redirect('/admin/clubs');
        }
    }

    public function createUser() {
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                Session::setFlash('error', 'Ungültige Sitzung.');
                $this->redirect('/admin/clubs');
            }

            $username = $this->input('username');
            $password = $this->input('password');
            $club_id = $this->input('club_id');
            $role = empty($club_id) ? 'admin' : 'verein';

            $userModel = new User();
            try {
                $userModel->create($username, $password, $role, !empty($club_id) ? $club_id : null);
                (new AuditLog())->log('user_erstellt', $username);
                Session::setFlash('success', 'Benutzer angelegt.');
            } catch (\Exception $e) {
                Session::setFlash('error', 'Fehler: Benutzername existiert evtl. schon.');
            }
            $this->redirect('/admin/clubs');
        }
    }

    public function deleteUser($id) {
        if ($id == Auth::id()) {
             Session::setFlash('error', 'Sie können sich nicht selbst löschen.');
             $this->redirect('/admin/clubs');
        }
        if ($id == 1) {
             Session::setFlash('error', 'Der Haupt-Admin kann nicht gelöscht werden.');
             $this->redirect('/admin/clubs');
        }

        $userModel = new User();
        $userModel->delete($id);
        (new AuditLog())->log('user_geloescht', "ID: $id");
        Session::setFlash('success', 'Benutzer gelöscht.');
        $this->redirect('/admin/clubs');
    }

    public function deleteClub($id) {
        $db = \Core\Database::getInstance();
        $db->query("DELETE FROM clubs WHERE id = ?", [$id]);
        (new AuditLog())->log('verein_geloescht', "ID: $id");
        Session::setFlash('success', 'Verein gelöscht.');
        $this->redirect('/admin/clubs');
    }

    public function shooters() {
        $shooterModel = new Shooter();
        $shooters = $shooterModel->getAllWithClubAndTeam();

        $db = \Core\Database::getInstance();
        $clubs = $db->query("SELECT * FROM clubs ORDER BY name")->fetchAll();
        // Teams laden für Auswahl
        $teams = $db->query("SELECT t.*, c.name as club_name FROM teams t JOIN clubs c ON t.club_id = c.id ORDER BY c.name, t.name")->fetchAll();

        $this->view('admin/shooters', ['shooters' => $shooters, 'clubs' => $clubs, 'teams' => $teams]);
    }

    public function createShooter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
               Session::setFlash('error', 'Ungültige Sitzung.');
               $this->redirect('/admin/shooters');
           }

           $first = $this->input('first_name');
           $last = $this->input('last_name');
           $club_id = $this->input('club_id');
           $team_id = $this->input('team_id') ?: null; // Optional

           $shooterModel = new Shooter();
           $shooterModel->create($first, $last, $club_id, $team_id);

           (new AuditLog())->log('schuetze_erstellt', "$last, $first");

           Session::setFlash('success', 'Schütze angelegt.');
           $this->redirect('/admin/shooters');
        }
    }

    public function updateShooterTeam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Einfacher Handler für Team-Update via Liste (könnte man auch schöner lösen)
             $shooter_id = $this->input('shooter_id');
             $team_id = $this->input('team_id') ?: null;

             $shooterModel = new Shooter();
             $shooterModel->updateTeam($shooter_id, $team_id);

             Session::setFlash('success', 'Team-Zuordnung aktualisiert.');
             $this->redirect('/admin/shooters');
        }
    }

    public function toggleShooterStatus($id) {
        $shooterModel = new Shooter();
        $newStatus = $shooterModel->toggleStatus($id);
        if ($newStatus) {
            (new AuditLog())->log('schuetze_status', "ID: $id -> $newStatus");
            Session::setFlash('success', 'Status geändert.');
        }
        $this->redirect('/admin/shooters');
    }
}
