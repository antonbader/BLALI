<?php $title = "Mannschaft bearbeiten"; ?>

<h1>Mannschaft bearbeiten</h1>

<form method="post" style="margin-bottom: 2rem;">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">
    <input type="hidden" name="action" value="update_team">

    <div class="form-group">
        <label>Name der Mannschaft:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($team['name']) ?>" required>
    </div>

    <div class="form-group">
        <label>Verein:</label>
        <select name="club_id" required>
            <?php foreach($clubs as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $team['club_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Wettbewerb:</label>
        <select name="competition_id" required>
            <?php foreach($competitions as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $team['competition_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?> (<?= htmlspecialchars($c['season']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn">Speichern</button>
    <a href="<?= BASIS_URL ?>/admin/teams" class="btn btn-danger" style="text-decoration:none;">Abbrechen</a>
</form>

<hr>

<h2>Mitglieder</h2>

<?php if (empty($members)): ?>
    <p>Keine Mitglieder zugewiesen.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Nachname</th>
                <th>Vorname</th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['last_name']) ?></td>
                    <td><?= htmlspecialchars($m['first_name']) ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">
                            <input type="hidden" name="action" value="remove_member">
                            <input type="hidden" name="shooter_id" value="<?= $m['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Entfernen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<h3>Mitglied hinzufügen</h3>
<?php if (empty($availableShooters)): ?>
    <p>Keine freien Schützen in diesem Verein gefunden.</p>
<?php else: ?>
    <form method="post" class="form-inline">
        <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">
        <input type="hidden" name="action" value="add_member">

        <div class="form-group">
            <select name="shooter_id" required>
                <option value="">-- Schützen wählen --</option>
                <?php foreach ($availableShooters as $s): ?>
                    <option value="<?= $s['id'] ?>">
                        <?= htmlspecialchars($s['last_name'] . ', ' . $s['first_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">Hinzufügen</button>
        </div>
    </form>
<?php endif; ?>
