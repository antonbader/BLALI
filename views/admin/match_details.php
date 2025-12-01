<?php $title = "Match Details"; ?>

<h1>Ergebnis-Details</h1>
<h3><?= htmlspecialchars($match['home_team']) ?> vs. <?= htmlspecialchars($match['guest_team']) ?></h3>
<p>
    Status: <b><?= ucfirst($match['status']) ?></b><br>
    Punkte: <?= $match['home_points'] ?> : <?= $match['guest_points'] ?><br>
    Ringe: <?= $match['home_total_rings'] ?> : <?= $match['guest_total_rings'] ?>
</p>

<h3>Einzelergebnisse</h3>
<table>
    <thead>
        <tr>
            <th>Mannschaft</th>
            <th>Schütze</th>
            <th>Ringe</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['team_name']) ?></td>
            <td><?= htmlspecialchars($r['last_name'] . ', ' . $r['first_name']) ?></td>
            <td><?= $r['rings'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div style="margin-top: 20px;">
    <?php if ($match['status'] === 'eingereicht'): ?>
        <a href="<?= BASIS_URL ?>/league/approveMatch/<?= $match['id'] ?>" class="btn">Freigeben</a>
    <?php elseif ($match['status'] === 'bestaetigt'): ?>
        <a href="<?= BASIS_URL ?>/league/revokeMatch/<?= $match['id'] ?>" class="btn btn-danger">Freigabe widerrufen</a>
    <?php endif; ?>

    <a href="<?= BASIS_URL ?>/club/enterResult/<?= $match['id'] ?>" class="btn">Bearbeiten</a>
    <a href="<?= BASIS_URL ?>/league/matches" class="btn" style="background: #999;">Zurück</a>
</div>
