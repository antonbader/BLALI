<?php $title = "Tabelle & Wettkampfplan"; ?>

<h1>Aktuelle Saison</h1>

<?php if (empty($competitions)): ?>
    <p>Aktuell keine aktiven Wettbewerbe.</p>
<?php else: ?>
    <form method="get" action="<?= BASIS_URL ?>/">
        <label>Wettbewerb wählen:</label>
        <select name="comp_id" onchange="this.form.submit()">
            <?php foreach ($competitions as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $currentCompId == $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?> (<?= htmlspecialchars($c['season']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <div class="tabs" style="margin-top: 20px;">
        <button class="tab-btn active" onclick="openTab(event, 'Tabelle')">Tabelle</button>
        <button class="tab-btn" onclick="openTab(event, 'Wettkampfplan')">Wettkampfplan</button>
        <button class="tab-btn" onclick="openTab(event, 'TopSchuetzen')">Top Schützen</button>
    </div>

    <div id="Tabelle" class="tab-content" style="display: block;">
        <h2>Tabelle</h2>
        <table>
            <thead>
                <tr>
                    <th>Platz</th>
                    <th>Mannschaft</th>
                    <th>Spiele</th>
                    <th>Punkte</th>
                    <th>Ringe</th>
                </tr>
            </thead>
            <tbody>
                <?php $rank = 1; foreach ($table as $row): ?>
                <tr>
                    <td><?= $rank++ ?>.</td>
                    <td><b><?= htmlspecialchars($row['name']) ?></b></td>
                    <td><?= $row['matches_played'] ?></td>
                    <td><?= $row['points'] ?></td>
                    <td><?= $row['rings'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="Wettkampfplan" class="tab-content" style="display: none;">
        <h2>Wettkampfplan</h2>
        <table>
            <thead>
                <tr>
                    <th>Runde</th>
                    <th>Heim</th>
                    <th>Gast</th>
                    <th>Ergebnis</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($matches as $m): ?>
                <tr>
                    <td><?= $m['round_number'] ?></td>
                    <td><?= htmlspecialchars($m['home_team']) ?></td>
                    <td><?= htmlspecialchars($m['guest_team']) ?></td>
                    <td>
                        <?php if ($m['status'] == 'bestaetigt'): ?>
                            <b><?= $m['home_points'] ?> : <?= $m['guest_points'] ?></b> <small>(<?= $m['home_total_rings'] ?>:<?= $m['guest_total_rings'] ?>)</small>
                        <?php else: ?>
                            - : -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="TopSchuetzen" class="tab-content" style="display: none;">
        <h2>Top 10 Schützen</h2>
        <table>
            <thead>
                <tr>
                    <th>Platz</th>
                    <th>Name</th>
                    <th>Verein</th>
                    <th>Matches</th>
                    <th>Gesamt-Ringe</th>
                    <th>Schnitt</th>
                </tr>
            </thead>
            <tbody>
                <?php $rank = 1; foreach ($topShooters as $s): ?>
                <tr>
                    <td><?= $rank++ ?>.</td>
                    <td><?= htmlspecialchars($s['last_name'] . ', ' . $s['first_name']) ?></td>
                    <td><?= htmlspecialchars($s['club_name']) ?></td>
                    <td><?= $s['matches_count'] ?></td>
                    <td><b><?= $s['total_rings'] ?></b></td>
                    <td><?= number_format($s['average'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <style>
        .tab-btn { padding: 10px 20px; cursor: pointer; background: #eee; border: none; border-bottom: 2px solid transparent; font-size: 16px; }
        .tab-btn.active { border-bottom: 2px solid #007bff; background: #fff; font-weight: bold; }
        .tab-content { border: 1px solid #ddd; padding: 20px; background: #fff; margin-top: -1px; }
    </style>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
<?php endif; ?>
