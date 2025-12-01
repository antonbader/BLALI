<?php $title = "Wettkampf-Planung"; ?>

<h1>Wettkampf-Planung</h1>

<div style="margin-bottom: 20px;">
    <h2>Neuen Wettkampf / Saison anlegen</h2>
    <form method="post" action="<?= BASIS_URL ?>/league/create">
        <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">
        <div class="form-group">
            <label>Name (z.B. Oberliga)</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Saison (z.B. 2024/2025)</label>
            <input type="text" name="season" required>
        </div>
        <div class="form-group">
            <label>Runden (1 = Nur Hin, 2 = Hin & Rück)</label>
            <select name="rounds">
                <option value="1">1 (Nur Hinrunde)</option>
                <option value="2">2 (Hin- & Rückrunde)</option>
            </select>
        </div>
        <button type="submit" class="btn">Erstellen</button>
    </form>
</div>

<h2>Vorhandene Wettkämpfe</h2>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Saison</th>
            <th>Status</th>
            <th>Teams</th>
            <th>Aktion</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($competitions as $c): ?>
        <tr>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><?= htmlspecialchars($c['season']) ?></td>
            <td><?= ucfirst($c['status'] ?? 'Unbekannt') ?></td>
            <td> - </td> <!-- Könnte man noch zählen -->
            <td>
                <a href="<?= BASIS_URL ?>/league/details/<?= $c['id'] ?>" class="btn">Verwalten</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
