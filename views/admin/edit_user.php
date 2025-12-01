<?php $title = "Benutzer bearbeiten"; ?>

<h1>Benutzer bearbeiten: <?= htmlspecialchars($user['username']) ?></h1>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::csrfToken() ?>">

    <div class="form-group">
        <label>Benutzername</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>

    <div class="form-group">
        <label>Neues Passwort (leer lassen zum Beibehalten)</label>
        <input type="password" name="password" placeholder="Neues Passwort">
    </div>

    <div class="form-group">
        <label>Zugehöriger Verein (optional für Admins)</label>
        <select name="club_id">
            <option value="">-- Kein Verein (Globaler Admin) --</option>
            <?php foreach ($clubs as $club): ?>
                <option value="<?= $club['id'] ?>" <?= $club['id'] == $user['club_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($club['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small>Wenn ein Verein gewählt wird, ist die Rolle automatisch "Vereins-Admin".</small>
    </div>

    <button type="submit" class="btn">Speichern</button>
    <a href="<?= BASIS_URL ?>/admin/clubs" class="btn btn-danger" style="text-decoration:none;">Abbrechen</a>
</form>
