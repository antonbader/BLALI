<?php
namespace Controllers;

use Core\Controller;
use Core\Auth;
use Core\Session;
use Models\Competition;
use Models\MatchModel;
use Models\AuditLog;

class LeagueController extends Controller {

    public function __construct() {
        Auth::requireAdmin();
    }

    public function index() {
        $compModel = new Competition();
        $competitions = $compModel->getAll();
        $this->view('admin/league_index', ['competitions' => $competitions]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
               Session::setFlash('error', 'Ungültige Sitzung.');
               $this->redirect('/league/index');
           }

           $name = $this->input('name');
           $season = $this->input('season');
           $rounds = $this->input('rounds');

           $compModel = new Competition();
           $compModel->create($name, $season, $rounds);

           (new AuditLog())->log('wettkampf_erstellt', "Name: $name, Saison: $season");

           Session::setFlash('success', 'Wettkampf angelegt.');
           $this->redirect('/league/index');
        }
    }

    public function details($id) {
        $compModel = new Competition();
        $comp = $compModel->getById($id);

        if (!$comp) {
            Session::setFlash('error', 'Wettkampf nicht gefunden.');
            $this->redirect('/league/index');
        }

        $teams = $compModel->getTeams($id);

        // Vereine für Dropdown laden (kann man auch via Club Model machen, aber hier kurz direkt)
        $db = \Core\Database::getInstance();
        $clubs = $db->query("SELECT * FROM clubs ORDER BY name")->fetchAll();

        $matchModel = new MatchModel();
        $matches = $matchModel->getByCompetition($id);

        $this->view('admin/league_details', [
            'comp' => $comp,
            'teams' => $teams,
            'clubs' => $clubs,
            'matches' => $matches
        ]);
    }

    public function addTeam($compId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $name = $this->input('name');
             $clubId = $this->input('club_id');

             $compModel = new Competition();
             $compModel->addTeam($name, $clubId, $compId);

             (new AuditLog())->log('team_hinzugefuegt', "Comp ID: $compId, Team: $name");

             Session::setFlash('success', 'Mannschaft hinzugefügt.');
             $this->redirect("/league/details/$compId");
        }
    }

    public function generateSchedule($compId) {
        $compModel = new Competition();
        try {
            $compModel->generateSchedule($compId);
            (new AuditLog())->log('wettkampfplan_generiert', "Comp ID: $compId");
            Session::setFlash('success', 'Wettkampfplan erfolgreich erstellt.');
        } catch (\Exception $e) {
            Session::setFlash('error', $e->getMessage());
        }
        $this->redirect("/league/details/$compId");
    }

    public function setStatus($compId, $status) {
        $compModel = new Competition();
        try {
            $compModel->setStatus($compId, $status);
            (new AuditLog())->log('wettkampf_status_geaendert', "Comp ID: $compId, Status: $status");
            Session::setFlash('success', "Wettkampf-Status auf '$status' geändert.");
        } catch (\Exception $e) {
             Session::setFlash('error', $e->getMessage());
        }
        $this->redirect("/league/details/$compId");
    }

    public function matches() {
        $matchModel = new MatchModel();
        $matches = $matchModel->getSubmitted();

        $this->view('admin/matches_approval', ['matches' => $matches]);
    }

    public function approveMatch($id) {
        $matchModel = new MatchModel();
        $matchModel->setStatus($id, 'bestaetigt');

        (new AuditLog())->log('match_bestaetigt', "Match ID: $id");

        Session::setFlash('success', 'Match bestätigt.');
        $this->redirect('/league/matches');
    }

    public function revokeMatch($id) {
        $matchModel = new MatchModel();
        $matchModel->setStatus($id, 'eingereicht');

        (new AuditLog())->log('match_freigabe_widerrufen', "Match ID: $id");

        Session::setFlash('success', 'Freigabe widerrufen (Status zurück auf eingereicht).');
        $this->redirect('/league/matches');
    }

    public function viewMatchResult($id) {
        $matchModel = new MatchModel();
        $match = $matchModel->getById($id);

        if (!$match) {
            Session::setFlash('error', 'Match nicht gefunden.');
            $this->redirect('/league/matches');
        }

        // Ergebnisse laden
        $db = \Core\Database::getInstance();
        $results = $db->query("
            SELECT r.*, s.first_name, s.last_name, t.name as team_name
            FROM results r
            JOIN shooters s ON r.shooter_id = s.id
            JOIN teams t ON r.team_id = t.id
            WHERE r.match_id = ?
            ORDER BY t.id, r.rings DESC
        ", [$id])->fetchAll();

        $this->view('admin/match_details', ['match' => $match, 'results' => $results]);
    }

    public function exportCsv($compId) {
        $db = \Core\Database::getInstance();
        // Tabelle berechnen
        $sql = "
            SELECT t.name,
                   SUM(CASE
                       WHEN m.home_team_id = t.id THEN m.home_points
                       WHEN m.guest_team_id = t.id THEN m.guest_points
                       ELSE 0 END) as points,
                   SUM(CASE
                       WHEN m.home_team_id = t.id THEN m.home_total_rings
                       WHEN m.guest_team_id = t.id THEN m.guest_total_rings
                       ELSE 0 END) as rings,
                   COUNT(m.id) as matches_played
            FROM teams t
            LEFT JOIN matches m ON (m.home_team_id = t.id OR m.guest_team_id = t.id)
                               AND m.competition_id = ?
                               AND m.status = 'bestaetigt'
            WHERE t.competition_id = ?
            GROUP BY t.id
            ORDER BY points DESC, rings DESC
        ";

        $table = $db->query($sql, [$compId, $compId])->fetchAll();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="tabelle_export.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['Mannschaft', 'Spiele', 'Punkte', 'Ringe']);
        foreach($table as $row) {
            fputcsv($out, [$row['name'], $row['matches_played'], $row['points'], $row['rings']]);
        }
        fclose($out);
        exit;
    }
}
