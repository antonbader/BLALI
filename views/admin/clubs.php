<?php $title = "Vereine & Benutzer"; ?>

<h1>Vereine & Benutzer Verwaltung</h1>

<div style="display: flex; gap: 40px; flex-wrap: wrap;">

    <div style="flex: 1; min-width: 300px;">
        <h2>Neuen Verein anlegen</h2>
        <form method="post" action="<?= BASIS_URL ?>/admin/createClub">
            <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">
            <div class="form-group">
                <label>Vereinsname</label>
                <input type="text" name="name" required>
            </div>
            <button type="submit" class="btn">Verein erstellen</button>
        </form>

        <h2>Vereinsliste</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clubs as $club): ?>
                <tr>
                    <td><?= $club['id'] ?></td>
                    <td><?= htmlspecialchars($club['name']) ?></td>
                    <td>
                        <a href="<?= BASIS_URL ?>/admin/deleteClub/<?= $club['id'] ?>" class="btn btn-danger" onclick="return confirm('Wirklich löschen? Alle zugehörigen Daten (Teams, Schützen) werden gelöscht!')">Löschen</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="flex: 1; min-width: 300px;">
        <h2>Neuen Benutzer anlegen</h2>
        <form method="post" action="<?= BASIS_URL ?>/admin/createUser">
            <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">
            <div class="form-group">
                <label>Benutzername</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Passwort</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Zugehöriger Verein (optional für Admins)</label>
                <select name="club_id">
                    <option value="">-- Kein Verein (Globaler Admin) --</option>
                    <?php foreach ($clubs as $club): ?>
                        <option value="<?= $club['id'] ?>"><?= htmlspecialchars($club['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <small>Wenn ein Verein gewählt wird, ist die Rolle automatisch "Vereins-Admin".</small>
            </div>
            <button type="submit" class="btn">Benutzer erstellen</button>
        </form>

        <h2>Benutzerliste</h2>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Rolle</th>
                    <th>Verein</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= $user['role'] ?></td>
                    <td><?= $user['club_name'] ?? '-' ?></td>
                    <td>
                        <?php if ($user['id'] != \Core\Auth::id()): ?>
                        <a href="<?= BASIS_URL ?>/admin/deleteUser/<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Benutzer löschen?')">Löschen</a>
                        <?php else: ?>
                        <span style="color: #999;">(Du)</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
