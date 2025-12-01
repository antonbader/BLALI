<?php $title = "Anmelden"; ?>

<h1>Anmelden</h1>

<form method="post" action="<?= BASIS_URL ?>/auth/login" style="max-width: 400px; margin: 0 auto;">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">

    <div class="form-group">
        <label for="username">Benutzername</label>
        <input type="text" id="username" name="username" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">Passwort</label>
        <input type="password" id="password" name="password" required>
    </div>

    <button type="submit" class="btn">Einloggen</button>
</form>
