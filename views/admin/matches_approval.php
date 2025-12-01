<?php $title = "Ergebnisse freigeben"; ?>

<h1>Eingereichte Ergebnisse prüfen</h1>

<?php if (empty($matches)): ?>
    <p>Keine offenen Ergebnisse zur Prüfung.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Wettkampf</th>
                <th>Heim</th>
                <th>Gast</th>
                <th>Datum</th>
                <th>Ergebnis (Punkte / Ringe)</th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matches as $m): ?>
            <tr>
                <td><?= htmlspecialchars($m['comp_name']) ?></td>
                <td><?= htmlspecialchars($m['home_team']) ?></td>
                <td><?= htmlspecialchars($m['guest_team']) ?></td>
                <td><?= $m['match_date'] ?></td>
                <td>
                    <b><?= $m['home_points'] ?> : <?= $m['guest_points'] ?></b><br>
                    <small><?= $m['home_total_rings'] ?> : <?= $m['guest_total_rings'] ?></small>
                </td>
                <td>
                    <a href="<?= BASIS_URL ?>/league/viewMatchResult/<?= $m['id'] ?>" class="btn" style="background: #17a2b8;">Details</a>
                    <a href="<?= BASIS_URL ?>/league/approveMatch/<?= $m['id'] ?>" class="btn">Freigeben</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
