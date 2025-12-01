<?php $title = "Mannschaft bearbeiten"; ?>

<h1>Mannschaft bearbeiten</h1>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">

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
