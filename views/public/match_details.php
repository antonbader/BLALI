<?php $title = "Match Details"; ?>

<h1>Ergebnis Details</h1>

<div style="background: #fff; padding: 20px; border: 1px solid #ddd; margin-bottom: 20px;">
    <h2><?= htmlspecialchars($match['home_team']) ?> vs. <?= htmlspecialchars($match['guest_team']) ?></h2>
    <p>
        <strong>Runde:</strong> <?= $match['round_number'] ?><br>
        <strong>Datum:</strong> <?= $match['match_date'] ? date('d.m.Y', strtotime($match['match_date'])) : '-' ?><br>
        <strong>Endstand:</strong> <?= $match['home_points'] ?> : <?= $match['guest_points'] ?>
        (<?= $match['home_total_rings'] ?> : <?= $match['guest_total_rings'] ?> Ringe)
    </p>
    <a href="<?= BASIS_URL ?>/" class="btn">Zurück zur Übersicht</a>
</div>

<h3>Einzelergebnisse</h3>

<?php
// Group results by team
$homeResults = [];
$guestResults = [];

foreach($results as $r) {
    if ($r['team_id'] == $match['home_team_id']) {
        $homeResults[] = $r;
    } elseif ($r['team_id'] == $match['guest_team_id']) {
        $guestResults[] = $r;
    }
}
?>

<div style="display: flex; gap: 30px; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 300px;">
        <h4><?= htmlspecialchars($match['home_team']) ?></h4>
        <table>
            <thead>
                <tr>
                    <th>Schütze</th>
                    <th>Ringe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($homeResults as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['last_name'] . ', ' . $r['first_name']) ?></td>
                    <td><?= $r['rings'] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($homeResults)): ?>
                    <tr><td colspan="2">Keine Ergebnisse.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="flex: 1; min-width: 300px;">
        <h4><?= htmlspecialchars($match['guest_team']) ?></h4>
        <table>
            <thead>
                <tr>
                    <th>Schütze</th>
                    <th>Ringe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($guestResults as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['last_name'] . ', ' . $r['first_name']) ?></td>
                    <td><?= $r['rings'] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($guestResults)): ?>
                    <tr><td colspan="2">Keine Ergebnisse.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
