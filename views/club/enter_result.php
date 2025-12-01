<?php $title = "Ergebnisse eingeben"; ?>

<h1>Ergebnisse eingeben</h1>
<h3><?= htmlspecialchars($match['home_team']) ?> vs. <?= htmlspecialchars($match['guest_team']) ?></h3>
<p>Max. Ringe pro Schütze: <?= $match['max_rings'] ?></p>

<form method="post" action="<?= BASIS_URL ?>/club/enterResult/<?= $match['id'] ?>">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">

    <div style="display: flex; gap: 40px; flex-wrap: wrap;">

        <!-- Heim Team -->
        <div style="flex: 1;">
            <h4><?= htmlspecialchars($match['home_team']) ?> (Heim)</h4>
            <div id="home-shooters">
                <?php for($i=0; $i<5; $i++): ?>
                <div class="shooter-row" style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <select name="home_shooter_id[]" style="width: 60%;">
                        <option value="">-- Schütze wählen --</option>
                        <?php foreach ($homeShooters as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= (isset($homeValues[$i]['shooter_id']) && $homeValues[$i]['shooter_id'] == $s['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['last_name'] . ', ' . $s['first_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="home_rings[]" placeholder="Ringe" min="0"
                           value="<?= isset($homeValues[$i]['rings']) ? $homeValues[$i]['rings'] : '' ?>"
                           style="width: 30%;">
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Gast Team -->
        <div style="flex: 1;">
            <h4><?= htmlspecialchars($match['guest_team']) ?> (Gast)</h4>
            <div id="guest-shooters">
                <?php for($i=0; $i<5; $i++): ?>
                <div class="shooter-row" style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                    <select name="guest_shooter_id[]" style="width: 60%;">
                        <option value="">-- Schütze wählen --</option>
                        <?php foreach ($guestShooters as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= (isset($guestValues[$i]['shooter_id']) && $guestValues[$i]['shooter_id'] == $s['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['last_name'] . ', ' . $s['first_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="guest_rings[]" placeholder="Ringe" min="0"
                           value="<?= isset($guestValues[$i]['rings']) ? $guestValues[$i]['rings'] : '' ?>"
                           style="width: 30%;">
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <hr>
    <p><em>Es werden automatisch die besten 3 Ergebnisse pro Team gewertet.</em></p>
    <button type="submit" class="btn">Ergebnisse speichern & einreichen</button>
    <a href="<?= BASIS_URL ?>/club/dashboard" class="btn btn-danger">Abbrechen</a>
</form>
