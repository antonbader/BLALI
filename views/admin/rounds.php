<?php $title = "Rundentermine verwalten"; ?>

<h1>Rundentermine: <?= htmlspecialchars($comp['name']) ?></h1>

<p>Hier können Sie für jede Runde ein Datum festlegen, bis zu dem die Spiele gespielt sein sollen.</p>

<form method="post" action="<?= BASIS_URL ?>/admin/saveRounds/<?= $comp['id'] ?>">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::csrfToken() ?>">

    <table>
        <thead>
            <tr>
                <th>Runde</th>
                <th>Datum (Frist)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Berechne Gesamtrunden (Hin- und ggf. Rückrunde)
            // Round Robin: (Teams - 1) * rounds
            // Wir nehmen einfach an, dass der Competition Parameter 'rounds' die Durchgänge meint.
            // Aber eigentlich wissen wir nicht genau wie viele Spieltage es gibt ohne Matches zu zählen.
            // Workaround: Wir schauen in die Matches Tabelle für diesen Wettbewerb, wie viele Runden es gibt.

            $db = \Core\Database::getInstance();
            $maxRound = $db->query("SELECT MAX(round_number) as max_r FROM matches WHERE competition_id = ?", [$comp['id']])->fetch()['max_r'];
            if (!$maxRound) $maxRound = 0;

            for($r = 1; $r <= $maxRound; $r++):
                $val = $datesMap[$r] ?? '';
            ?>
            <tr>
                <td>Runde <?= $r ?></td>
                <td>
                    <input type="date" name="dates[<?= $r ?>]" value="<?= $val ?>">
                </td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Speichern</button>
        <a href="<?= BASIS_URL ?>/admin/dashboard" class="btn btn-danger" style="text-decoration:none;">Abbrechen</a>
    </div>
</form>
