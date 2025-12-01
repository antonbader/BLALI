<?php $title = "Rundentermine verwalten"; ?>

<h1>Rundentermine: <?= htmlspecialchars($comp['name']) ?></h1>

<p>Hier können Sie für jede Runde ein Datum festlegen, bis zu dem die Spiele gespielt sein sollen.</p>

<form method="post" action="<?= BASIS_URL ?>/admin/saveRounds/<?= $comp['id'] ?>">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">

    <table>
        <thead>
            <tr>
                <th>Runde</th>
                <th>Datum (Frist)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($maxRound < 1):
            ?>
            <tr>
                <td colspan="2">
                    Keine Spieltage gefunden. Bitte generieren Sie erst den Wettkampfplan für diese Saison.
                </td>
            </tr>
            <?php
            else:
            for($r = 1; $r <= $maxRound; $r++):
                $val = $datesMap[$r] ?? '';
            ?>
            <tr>
                <td>Runde <?= $r ?></td>
                <td>
                    <input type="date" name="dates[<?= $r ?>]" value="<?= $val ?>">
                </td>
            </tr>
            <?php endfor; endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Speichern</button>
        <a href="<?= BASIS_URL ?>/admin/dashboard" class="btn btn-danger" style="text-decoration:none;">Abbrechen</a>
    </div>
</form>
