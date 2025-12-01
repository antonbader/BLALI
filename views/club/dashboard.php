<?php $title = "Vereins-Bereich"; ?>

<h1>Willkommen, <?= htmlspecialchars(\Core\Session::get('user_name')) ?></h1>

<div style="display: flex; gap: 30px; flex-wrap: wrap;">

    <div style="flex: 1; min-width: 300px;">
        <h2>Offene Spiele (Ergebniseingabe)</h2>
        <?php if (empty($matches)): ?>
            <p>Keine offenen Spiele.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Wettkampf</th>
                        <th>Heim</th>
                        <th>Gast</th>
                        <th>Runde</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matches as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['comp_name']) ?></td>
                        <td><?= htmlspecialchars($m['home_team']) ?></td>
                        <td><?= htmlspecialchars($m['guest_team']) ?></td>
                        <td><?= $m['round_number'] ?></td>
                        <td>
                            <a href="<?= BASIS_URL ?>/club/enterResult/<?= $m['id'] ?>" class="btn">Ergebnisse eingeben</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div style="flex: 1; min-width: 300px;">
        <h2>Meine Mannschaften</h2>
        <ul>
            <?php foreach ($teams as $t): ?>
                <li><?= htmlspecialchars($t['name']) ?></li>
            <?php endforeach; ?>
        </ul>
        <p><small>Mannschaften werden vom Administrator verwaltet.</small></p>
    </div>
</div>
