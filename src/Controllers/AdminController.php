<?php
namespace Controllers;

use Core\Controller;
use Core\Auth;
use Core\Session;
use Models\User;
use Models\Shooter;
use Models\AuditLog;
use Models\RoundModel;
use Models\Competition;
use Models\Club;
use Models\Team;

class AdminController extends Controller {

    public function __construct() {
        Auth::requireAdmin();
    }

    public function dashboard() {
        $db = \Core\Database::getInstance();

        // Aktive Wettbewerbe für Rundentermine
        $activeComps = $db->query("SELECT * FROM competitions WHERE status = 'aktiv'")->fetchAll();

        // Prüfen auf eingereichte Ergebnisse
        $pendingCount = $db->query("SELECT COUNT(*) as c FROM matches WHERE status = 'eingereicht'")->fetch()['c'];

        $this->view('admin/dashboard', [
            'activeComps' => $activeComps,
            'pendingCount' => $pendingCount
        ]);
    }

    public function rounds($compId) {
        $compModel = new Competition();
        $comp = $compModel->getById($compId);
        if (!$comp) {
            Session::setFlash('error', 'Wettbewerb nicht gefunden.');
            $this->redirect('/admin/dashboard');
        }

        $roundModel = new RoundModel();
        $dates = $roundModel->getDatesByCompetition($compId);

        // Mappe Datum auf Runde
        $datesMap = [];
        foreach ($dates as $d) {
            $datesMap[$d['round_number']] = $d['match_date'];
        }

        // Ermittle max Runden
        $db = \Core\Database::getInstance();
        $maxRound = $db->query("SELECT MAX(round_number) as max_r FROM matches WHERE competition_id = ?", [$comp['id']])->fetch()['max_r'];
        if (!$maxRound) $maxRound = 0;

        $this->view('admin/rounds', [
            'comp' => $comp,
            'datesMap' => $datesMap,
            'maxRound' => $maxRound
        ]);
    }

    public function saveRounds($compId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                Session::setFlash('error', 'Ungültige Sitzung.');
                $this->redirect("/admin/rounds/$compId");
            }

            $dates = $_POST['dates'] ?? [];
            $roundModel = new RoundModel();

            foreach ($dates as $round => $date) {
                if (!empty($date)) {
                    $roundModel->saveDate($compId, $round, $date);
                }
            }

            Session::setFlash('success', 'Rundentermine gespeichert.');
            $this->redirect("/admin/rounds/$compId");
        }
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

    public function editUser($id) {
        if ($id == 1 && Auth::id() != 1) {
            Session::setFlash('error', 'Haupt-Admin kann nur von sich selbst bearbeitet werden.');
            $this->redirect('/admin/clubs');
        }

        $userModel = new User();
        $user = $userModel->getById($id);

        if (!$user) {
            Session::setFlash('error', 'User nicht gefunden.');
            $this->redirect('/admin/clubs');
        }

        $db = \Core\Database::getInstance();
        $clubs = $db->query("SELECT * FROM clubs ORDER BY name")->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                 Session::setFlash('error', 'Sitzung abgelaufen.');
                 $this->redirect("/admin/editUser/$id");
             }

             $username = $this->input('username');
             $password = $this->input('password'); // Optional
             $club_id = $this->input('club_id') ?: null;
             $role = $club_id ? 'verein' : 'admin';

             if ($username) {
                 try {
                     $userModel->update($id, $username, $role, $club_id);

                     if (!empty($password)) {
                         $userModel->updatePassword($id, $password);
                     }

                     (new AuditLog())->log('user_editiert', "ID: $id ($username)");
                     Session::setFlash('success', 'Benutzer gespeichert.');
                     $this->redirect('/admin/clubs');
                 } catch (\Exception $e) {
                     Session::setFlash('error', 'Fehler: Username vergeben?');
                 }
             }
        }

        $this->view('admin/edit_user', ['user' => $user, 'clubs' => $clubs]);
    }

    public function editClub($id) {
        $clubModel = new Club();
        $club = $clubModel->getById($id);

        if (!$club) {
            Session::setFlash('error', 'Verein nicht gefunden.');
            $this->redirect('/admin/clubs');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                 Session::setFlash('error', 'Sitzung abgelaufen.');
                 $this->redirect("/admin/editClub/$id");
             }

             $name = $this->input('name');
             if ($name) {
                 try {
                     $clubModel->update($id, $name);
                     (new AuditLog())->log('verein_editiert', "$id -> $name");
                     Session::setFlash('success', 'Verein gespeichert.');
                     $this->redirect('/admin/clubs');
                 } catch (\Exception $e) {
                     Session::setFlash('error', 'Fehler: Name vergeben?');
                 }
             }
        }

        $this->view('admin/edit_club', ['club' => $club]);
    }

    public function editShooter($id) {
        $shooterModel = new Shooter();
        $shooter = $shooterModel->getById($id);

        if (!$shooter) {
             Session::setFlash('error', 'Schütze nicht gefunden.');
             $this->redirect('/admin/shooters');
        }

        $db = \Core\Database::getInstance();
        $clubs = $db->query("SELECT * FROM clubs ORDER BY name")->fetchAll();
        $teams = $db->query("SELECT t.*, c.name as club_name FROM teams t JOIN clubs c ON t.club_id = c.id ORDER BY c.name, t.name")->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                 Session::setFlash('error', 'Sitzung abgelaufen.');
                 $this->redirect("/admin/editShooter/$id");
            }

            $first = $this->input('first_name');
            $last = $this->input('last_name');
            $clubId = $this->input('club_id');
            $teamId = $this->input('team_id') ?: null;

            if ($first && $last && $clubId) {
                $shooterModel->update($id, $first, $last, $clubId, $teamId);
                (new AuditLog())->log('schuetze_editiert', "ID: $id");
                Session::setFlash('success', 'Schütze gespeichert.');
                $this->redirect('/admin/shooters');
            }
        }

        $this->view('admin/edit_shooter', ['shooter' => $shooter, 'clubs' => $clubs, 'teams' => $teams]);
    }

    public function resetMatch($id) {
        $matchModel = new \Models\MatchModel();
        $matchModel->resetScore($id);
        (new AuditLog())->log('match_reset', "Match ID: $id");
        Session::setFlash('success', 'Match zurückgesetzt.');
        $this->redirect('/league/matches');
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

    public function teams() {
        $teamModel = new Team();
        $teams = $teamModel->getAllWithDetails();
        $this->view('admin/teams', ['teams' => $teams]);
    }

    public function deleteTeam($id) {
        $teamModel = new Team();
        $teamModel->delete($id);
        (new AuditLog())->log('team_geloescht', "ID: $id");
        Session::setFlash('success', 'Mannschaft gelöscht.');
        $this->redirect('/admin/teams');
    }

    public function editTeam($id) {
        $teamModel = new Team();
        $team = $teamModel->getById($id);

        if (!$team) {
            Session::setFlash('error', 'Mannschaft nicht gefunden.');
            $this->redirect('/admin/teams');
        }

        $db = \Core\Database::getInstance();
        $clubs = $db->query("SELECT * FROM clubs ORDER BY name")->fetchAll();
        $competitions = $db->query("SELECT * FROM competitions WHERE status != 'beendet' ORDER BY created_at DESC")->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                 Session::setFlash('error', 'Sitzung abgelaufen.');
                 $this->redirect("/admin/editTeam/$id");
            }

            $name = $this->input('name');
            $clubId = $this->input('club_id');
            $compId = $this->input('competition_id');

            if ($name && $clubId && $compId) {
                $teamModel->update($id, $name, $clubId, $compId);
                (new AuditLog())->log('team_editiert', "ID: $id ($name)");
                Session::setFlash('success', 'Mannschaft gespeichert.');
                $this->redirect('/admin/teams');
            }
        }

        $this->view('admin/edit_team', ['team' => $team, 'clubs' => $clubs, 'competitions' => $competitions]);
    }
}
