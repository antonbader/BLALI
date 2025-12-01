<?php $title = "Passwort ändern"; ?>

<h1>Passwort ändern</h1>

<form method="post" action="<?= BASIS_URL ?>/auth/changePassword" style="max-width: 400px; margin: 0 auto;">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">

    <div class="form-group">
        <label for="old_password">Altes Passwort</label>
        <input type="password" id="old_password" name="old_password" required>
    </div>

    <div class="form-group">
        <label for="new_password">Neues Passwort</label>
        <input type="password" id="new_password" name="new_password" required>
    </div>

    <div class="form-group">
        <label for="confirm_password">Neues Passwort bestätigen</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>

    <button type="submit" class="btn">Passwort ändern</button>
</form>
