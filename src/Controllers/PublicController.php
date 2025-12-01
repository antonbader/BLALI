<?php
namespace Controllers;

use Core\Controller;
use Models\Shooter;

class PublicController extends Controller {

    public function index() {
        $db = \Core\Database::getInstance();

        // Aktive Wettbewerbe laden
        $competitions = $db->query("SELECT * FROM competitions WHERE status != 'geplant' ORDER BY created_at DESC")->fetchAll();

        $compId = $this->query('comp_id') ?? ($competitions[0]['id'] ?? null);

        $table = [];
        $matches = [];
        $topShooters = [];
        $roundDates = [];

        if ($compId) {
            // Rundentermine
            $roundModel = new \Models\RoundModel();
            $dates = $roundModel->getDatesByCompetition($compId);
            foreach($dates as $d) {
                $roundDates[$d['round_number']] = $d['match_date'];
            }

            // Tabelle
            $sql = "
                SELECT t.id, t.name,
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

            // Matches
            $matchModel = new \Models\MatchModel();
            $matches = $matchModel->getByCompetition($compId);

            // Top Schützen
            $shooterModel = new Shooter();
            $topShooters = $shooterModel->getTopShooters($compId);
        }

        $this->view('public/index', [
            'competitions' => $competitions,
            'currentCompId' => $compId,
            'table' => $table,
            'matches' => $matches,
            'topShooters' => $topShooters,
            'roundDates' => $roundDates
        ]);
    }

    public function matchDetails($matchId) {
        $matchModel = new \Models\MatchModel();
        $match = $matchModel->getById($matchId);

        if (!$match) {
             \Core\Session::setFlash('error', 'Match nicht gefunden');
             $this->redirect('/');
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
        ", [$matchId])->fetchAll();

        $this->view('public/match_details', [
            'match' => $match,
            'results' => $results
        ]);
    }
}
