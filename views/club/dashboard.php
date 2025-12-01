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
                            <?php if ($m['home_club_id'] == $currentClubId): ?>
                                <a href="<?= BASIS_URL ?>/club/enterResult/<?= $m['id'] ?>" class="btn">Ergebnisse eingeben</a>
                            <?php else: ?>
                                <button class="btn" disabled title="Nur die Heimmannschaft darf Ergebnisse melden." style="opacity: 0.5; cursor: not-allowed;">Ergebnisse eingeben</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div style="flex: 1; min-width: 300px;">
        <h2>Meine Mannschaften</h2>
        <?php foreach ($teams as $t): ?>
            <div class="team-card" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
                <h3><?= htmlspecialchars($t['name']) ?></h3>
                <?php if(!empty($t['shooters'])): ?>
                    <ul>
                        <?php foreach($t['shooters'] as $s): ?>
                            <li><?= htmlspecialchars($s['first_name'] . ' ' . $s['last_name']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p><i>Keine Schützen zugewiesen.</i></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <p><small>Mannschaften und Schützen werden vom Administrator verwaltet.</small></p>
    </div>
</div>
