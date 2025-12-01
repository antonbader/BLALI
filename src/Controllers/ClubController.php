<?php
namespace Controllers;

use Core\Controller;
use Core\Auth;
use Core\Session;
use Models\MatchModel;
use Models\Team;
use Models\Shooter;
use Models\Result;
use Models\AuditLog;

class ClubController extends Controller {

    public function __construct() {
        Auth::requireLogin();
        if (!Auth::isAdmin() && !Auth::isClubAdmin()) {
             Session::setFlash('error', 'Kein Zugriff.');
             $this->redirect('/');
        }
    }

    public function dashboard() {
        $clubId = Auth::clubId();

        if (Auth::isAdmin() && !$clubId) {
             Session::setFlash('info', 'Sie sind als Super-Admin eingeloggt. Nutzen Sie das Admin Dashboard.');
             $this->redirect('/admin/dashboard');
        }

        $teamModel = new Team();
        $teams = $teamModel->getByClub($clubId);

        $matchModel = new MatchModel();
        $matches = $matchModel->getOpenByClub($clubId);

        $this->view('club/dashboard', ['teams' => $teams, 'matches' => $matches]);
    }

    public function enterResult($matchId) {
        $clubId = Auth::clubId();

        $matchModel = new MatchModel();
        $match = $matchModel->getById($matchId);

        if (!$match) {
             Session::setFlash('error', 'Match nicht gefunden.');
             $this->redirect('/club/dashboard');
        }

        // Darf nur bearbeiten, wenn eigener Club beteiligt (oder Admin)
        if (!Auth::isAdmin() && $match['home_club_id'] != $clubId && $match['guest_club_id'] != $clubId) {
             Session::setFlash('error', 'Keine Berechtigung für dieses Match.');
             $this->redirect('/club/dashboard');
        }

        // Darf nur bearbeiten, wenn nicht bestätigt (außer Admin)
        if (!Auth::isAdmin() && $match['status'] === 'bestaetigt') {
             Session::setFlash('error', 'Match ist bereits bestätigt und kann nicht mehr bearbeitet werden.');
             $this->redirect('/club/dashboard');
        }

        $shooterModel = new Shooter();
        $homeShooters = $shooterModel->getByClub($match['home_club_id'], true);
        $guestShooters = $shooterModel->getByClub($match['guest_club_id'], true);

        // Vorhandene Ergebnisse laden (für Pre-Fill)
        $db = \Core\Database::getInstance();
        $existingResults = $db->query("SELECT * FROM results WHERE match_id = ?", [$matchId])->fetchAll();

        // Helfer zum Extrahieren der Werte für die View
        $getValues = function($teamId) use ($existingResults, $shooterModel) {
            $data = [];
            // Suche Ergebnisse für dieses Team
            foreach($existingResults as $r) {
                if ($r['team_id'] == $teamId) {
                    $data[] = ['shooter_id' => $r['shooter_id'], 'rings' => $r['rings']];
                }
            }

            // Wenn keine Ergebnisse da sind, Kader laden (Pre-Fill)
            if (empty($data)) {
                 $kader = $shooterModel->getByTeam($teamId); // Hier müsste man Team ID haben, aber getByTeam braucht Team ID.
                 // $teamId ist die Team ID.
                 foreach($kader as $s) {
                     $data[] = ['shooter_id' => $s['id'], 'rings' => ''];
                     if (count($data) >= 5) break; // Max 5 vorbelegen
                 }
            }

            // Auffüllen auf 5 Slots, falls weniger
            while(count($data) < 5) {
                $data[] = ['shooter_id' => '', 'rings' => ''];
            }
            return $data;
        };

        $homeValues = $getValues($match['home_team_id']);
        $guestValues = $getValues($match['guest_team_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             if (!Session::verifyCsrfToken($this->input('csrf_token'))) {
                 Session::setFlash('error', 'Sitzung abgelaufen.');
                 $this->redirect("/club/enterResult/$matchId");
             }

             $homeIds = $_POST['home_shooter_id'] ?? [];
             $homeRings = $_POST['home_rings'] ?? [];
             $guestIds = $_POST['guest_shooter_id'] ?? [];
             $guestRings = $_POST['guest_rings'] ?? [];

             $resultModel = new Result();

             try {
                 $db->getConnection()->beginTransaction();

                 // Alte Ergebnisse löschen
                 $resultModel->deleteByMatch($matchId);

                 // Closure zum Verarbeiten
                 $processResults = function($teamId, $ids, $rings) use ($resultModel, $matchId, $match) {
                     $teamRings = [];
                     for($i = 0; $i < count($ids); $i++) {
                         $sid = $ids[$i];
                         $val = intval($rings[$i]);
                         // Leere Inputs ignorieren, aber 0 ist gültig
                         if ($sid && $rings[$i] !== '') {
                             // Limit Prüfung entfernt gemäß Anforderung
                             // if ($val > $match['max_rings']) ...

                             $resultModel->save($matchId, $teamId, $sid, $val);
                             $teamRings[] = $val;
                         }
                     }
                     rsort($teamRings);
                     $sum = 0;
                     $count = min(count($teamRings), 3);
                     for($k=0; $k<$count; $k++) $sum += $teamRings[$k];
                     return $sum;
                 };

                 $homeTotal = $processResults($match['home_team_id'], $homeIds, $homeRings);
                 $guestTotal = $processResults($match['guest_team_id'], $guestIds, $guestRings);

                 // Punkte
                 $homePoints = 0;
                 $guestPoints = 0;

                 if ($homeTotal > $guestTotal) {
                     $homePoints = 2;
                 } elseif ($guestTotal > $homeTotal) {
                     $guestPoints = 2;
                 } else {
                     $homePoints = 1;
                     $guestPoints = 1;
                 }

                 $matchModel->updateScore($matchId, $homePoints, $guestPoints, $homeTotal, $guestTotal);

                 // Audit Log
                 $audit = new AuditLog();
                 $audit->log('ergebnis_eingereicht', "Match ID $matchId: $homeTotal:$guestTotal Ringe");

                 $db->getConnection()->commit();
                 Session::setFlash('success', 'Ergebnisse gespeichert und eingereicht.');
                 // Admin bleibt auf Seite oder zur Liste? Verein zum Dashboard.
                 if (Auth::isAdmin()) {
                     $this->redirect('/league/matches');
                 } else {
                     $this->redirect('/club/dashboard');
                 }

             } catch (\Exception $e) {
                 $db->getConnection()->rollBack();
                 Session::setFlash('error', 'Fehler beim Speichern: ' . $e->getMessage());
             }
        }

        $this->view('club/enter_result', [
            'match' => $match,
            'homeShooters' => $homeShooters,
            'guestShooters' => $guestShooters,
            'homeValues' => $homeValues,
            'guestValues' => $guestValues
        ]);
    }
}
