<?php $title = "Mannschaften Verwaltung"; ?>

<h1>Mannschaften Verwaltung</h1>

<p><small>Neue Mannschaften werden bei der <a href="<?= BASIS_URL ?>/league/index">Wettkampf-Planung</a> angelegt.</small></p>

<table class="sortable filterable">
    <thead>
        <tr>
            <th class="sort-header">Name</th>
            <th class="sort-header">Verein</th>
            <th class="sort-header">Wettbewerb</th>
            <th class="sort-header">Saison</th>
            <th class="no-filter">Aktion</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($teams as $t): ?>
        <tr>
            <td><?= htmlspecialchars($t['name']) ?></td>
            <td><?= htmlspecialchars($t['club_name']) ?></td>
            <td><?= htmlspecialchars($t['comp_name']) ?></td>
            <td><?= htmlspecialchars($t['season']) ?></td>
            <td>
                <a href="<?= BASIS_URL ?>/admin/editTeam/<?= $t['id'] ?>" class="btn">Bearbeiten</a>
                <a href="<?= BASIS_URL ?>/admin/deleteTeam/<?= $t['id'] ?>" class="btn btn-danger" onclick="return confirm('Mannschaft löschen? Alle Matches und Ergebnisse gehen verloren!')">Löschen</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
