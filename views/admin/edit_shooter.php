<?php $title = "Schütze bearbeiten"; ?>

<h1>Schütze bearbeiten</h1>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">

    <div class="form-group">
        <label>Vorname:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($shooter['first_name']) ?>" required>
    </div>

    <div class="form-group">
        <label>Nachname:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($shooter['last_name']) ?>" required>
    </div>

    <div class="form-group">
        <label>Verein:</label>
        <select name="club_id" required>
            <?php foreach($clubs as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $shooter['club_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Mannschaft:</label>
        <select name="team_id">
            <option value="">(Keine Mannschaft / Ersatz)</option>
            <?php foreach($teams as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $t['id'] == $shooter['team_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['club_name'] . ' - ' . $t['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn">Speichern</button>
    <a href="<?= BASIS_URL ?>/admin/shooters" class="btn btn-danger" style="text-decoration:none;">Abbrechen</a>
</form>
