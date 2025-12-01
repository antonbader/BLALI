<?php $title = "Schützen Verwaltung"; ?>

<h1>Schützen Verwaltung</h1>

<div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
    <h2>Neuen Schützen anlegen</h2>
    <form method="post" action="<?= BASIS_URL ?>/admin/createShooter" style="display: flex; gap: 10px; align-items: flex-end; flex-wrap: wrap;">
        <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">

        <div class="form-group" style="margin-bottom: 0;">
            <label>Vorname</label>
            <input type="text" name="first_name" required>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Nachname</label>
            <input type="text" name="last_name" required>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Verein</label>
            <select name="club_id" required>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= $club['id'] ?>"><?= htmlspecialchars($club['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Team (Optional)</label>
            <select name="team_id">
                <option value="">-- Kein Team --</option>
                <?php foreach ($teams as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?> (<?= htmlspecialchars($t['club_name']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn">Anlegen</button>
    </form>
</div>

<table class="sortable filterable">
    <thead>
        <tr>
            <th class="sort-header">Name</th>
            <th class="sort-header">Verein</th>
            <th class="sort-header">Team</th>
            <th class="sort-header">Status</th>
            <th class="no-filter">Aktion</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($shooters as $shooter): ?>
        <tr>
            <td><?= htmlspecialchars($shooter['last_name'] . ', ' . $shooter['first_name']) ?></td>
            <td><?= htmlspecialchars($shooter['club_name']) ?></td>
            <td>
                <form method="post" action="<?= BASIS_URL ?>/admin/updateShooterTeam" style="display:inline;">
                    <input type="hidden" name="shooter_id" value="<?= $shooter['id'] ?>">
                    <select name="team_id" onchange="this.form.submit()" style="padding: 2px;">
                        <option value="">--</option>
                        <?php foreach ($teams as $t): ?>
                            <?php if ($t['club_id'] == $shooter['club_id']): ?>
                            <option value="<?= $t['id'] ?>" <?= $shooter['team_id'] == $t['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['name']) ?>
                            </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </form>
            </td>
            <td>
                <span style="color: <?= $shooter['status'] == 'aktiv' ? 'green' : 'red' ?>;">
                    <?= ucfirst($shooter['status']) ?>
                </span>
            </td>
            <td>
                    <a href="<?= BASIS_URL ?>/admin/editShooter/<?= $shooter['id'] ?>" class="btn">Bearbeiten</a>
                <a href="<?= BASIS_URL ?>/admin/toggleShooterStatus/<?= $shooter['id'] ?>" class="btn">Status umschalten</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
