<?php $title = "Wettkampf Details"; ?>

<h1><?= htmlspecialchars($comp['name']) ?> (<?= htmlspecialchars($comp['season']) ?>)</h1>

<div style="display: flex; flex-wrap: wrap; gap: 30px;">

    <div style="flex: 1; min-width: 300px;">
        <h2>Mannschaften</h2>

        <?php if ($comp['status'] === 'geplant'): ?>
        <form method="post" action="<?= BASIS_URL ?>/league/addTeam/<?= $comp['id'] ?>" style="background: #f9f9f9; padding: 15px; margin-bottom: 15px;">
            <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">
            <div class="form-group">
                <label>Mannschaftsname</label>
                <input type="text" name="name" required placeholder="z.B. Team 1">
            </div>
            <div class="form-group">
                <label>Verein</label>
                <select name="club_id">
                    <?php foreach ($clubs as $club): ?>
                        <option value="<?= $club['id'] ?>"><?= htmlspecialchars($club['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn">Hinzufügen</button>
        </form>
        <?php else: ?>
            <p><em>Kader-Änderungen sind im laufenden Betrieb eingeschränkt.</em></p>
        <?php endif; ?>

        <ul>
            <?php foreach ($teams as $team): ?>
                <li><strong><?= htmlspecialchars($team['name']) ?></strong> (<?= htmlspecialchars($team['club_name']) ?>)</li>
            <?php endforeach; ?>
        </ul>

        <?php if ($comp['status'] === 'geplant' && count($teams) >= 2 && count($teams) % 2 == 0): ?>
            <a href="<?= BASIS_URL ?>/league/generateSchedule/<?= $comp['id'] ?>" class="btn" onclick="return confirm('Wettkampfplan generieren? Dies setzt den Status auf AKTIV.')">Wettkampfplan generieren</a>
        <?php elseif ($comp['status'] === 'geplant'): ?>
            <p style="color: orange;">Um den Wettkampfplan zu generieren, werden mindestens 2 Teams benötigt (gerade Anzahl).</p>
        <?php endif; ?>

        <?php if ($comp['status'] === 'aktiv'): ?>
            <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px;">
                <h3>Saison-Abschluss</h3>
                <a href="<?= BASIS_URL ?>/league/generateFinals/<?= $comp['id'] ?>" class="btn" onclick="return confirm('Final-Runde (Top 4) generieren?')">Finals generieren</a>
                <a href="<?= BASIS_URL ?>/league/exportCsv/<?= $comp['id'] ?>" class="btn" target="_blank">Tabelle als CSV</a>
            </div>
        <?php endif; ?>
    </div>

    <div style="flex: 2; min-width: 300px;">
        <h2>Wettkampfplan</h2>
        <?php if (empty($matches)): ?>
            <p>Noch kein Wettkampfplan generiert.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Runde</th>
                        <th>Heim</th>
                        <th>Gast</th>
                        <th>Status</th>
                        <th>Ergebnis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matches as $m): ?>
                    <tr>
                        <td><?= $m['round_number'] ?></td>
                        <td><?= htmlspecialchars($m['home_team']) ?></td>
                        <td><?= htmlspecialchars($m['guest_team']) ?></td>
                        <td><?= ucfirst($m['status']) ?></td>
                        <td>
                            <?php if ($m['status'] != 'offen'): ?>
                                <?= $m['home_points'] ?> : <?= $m['guest_points'] ?>
                                <small>(<?= $m['home_total_rings'] ?>:<?= $m['guest_total_rings'] ?>)</small>
                            <?php else: ?>
                                - : -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
