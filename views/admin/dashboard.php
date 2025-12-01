<?php $title = "Admin Dashboard"; ?>

<h1>Admin Dashboard</h1>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
    <a href="<?= BASIS_URL ?>/admin/clubs" class="dashboard-card">
        <h3>Vereine & Benutzer</h3>
        <p>Verwaltung der Stammdaten</p>
    </a>
    <a href="<?= BASIS_URL ?>/admin/shooters" class="dashboard-card">
        <h3>Schützen</h3>
        <p>Alle Schützen verwalten</p>
    </a>
    <a href="<?= BASIS_URL ?>/admin/teams" class="dashboard-card">
        <h3>Mannschaften</h3>
        <p>Mannschaften bearbeiten/löschen</p>
    </a>
    <a href="<?= BASIS_URL ?>/league/index" class="dashboard-card">
        <h3>Wettkampf-Planung</h3>
        <p>Saisons & Spielpläne</p>
    </a>
    <a href="<?= BASIS_URL ?>/league/matches" class="dashboard-card">
        <h3>Ergebnis-Freigabe</h3>
        <p>Eingereichte Ergebnisse prüfen</p>
        <?php if (!empty($pendingCount) && $pendingCount > 0): ?>
            <div style="color: red; font-weight: bold; margin-top: 5px;">
                ⚠️ <?= $pendingCount ?> neue(s) Ergebnis(se)!
            </div>
        <?php endif; ?>
    </a>
</div>

<h2>Aktive Wettbewerbe (Rundentermine)</h2>
<ul>
    <?php if (empty($activeComps)): ?>
        <li>Keine aktiven Wettbewerbe.</li>
    <?php else: ?>
        <?php foreach($activeComps as $c): ?>
        <li>
            <strong><?= htmlspecialchars($c['name']) ?></strong>
            - <a href="<?= BASIS_URL ?>/admin/rounds/<?= $c['id'] ?>">Rundentermine verwalten</a>
        </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>

<style>
    .dashboard-card {
        background: #fff;
        border: 1px solid #ddd;
        padding: 20px;
        text-decoration: none;
        color: #333;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        display: block;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-color: #007bff;
    }
    .dashboard-card h3 { margin-top: 0; color: #007bff; }
</style>
