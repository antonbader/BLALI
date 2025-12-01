<?php $title = "Verein bearbeiten"; ?>

<h1>Verein bearbeiten</h1>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= \Core\Session::generateCsrfToken() ?>">

    <div class="form-group">
        <label>Name des Vereins:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($club['name']) ?>" required>
    </div>

    <button type="submit" class="btn">Speichern</button>
    <a href="<?= BASIS_URL ?>/admin/clubs" class="btn btn-danger" style="text-decoration:none;">Abbrechen</a>
</form>
