<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?><?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASIS_URL ?>/css/style.css">
    <style>
        /* Minimales Inline-CSS für den Start */
        body { font-family: sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        header { background: #333; color: #fff; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        header a { color: #fff; text-decoration: none; margin-left: 15px; }
        main { padding: 20px; max-width: 1200px; margin: 0 auto; background: #fff; min-height: 80vh; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .flash { padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .flash.success { background: #d4edda; color: #155724; }
        .flash.error { background: #f8d7da; color: #721c24; }
        footer { background: #333; color: #fff; text-align: center; padding: 10px; margin-top: 20px; }
        .btn { display: inline-block; padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; border: none; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
        .navbar-brand { font-size: 1.5em; font-weight: bold; }
        @media (max-width: 600px) {
            header { flex-direction: column; text-align: center; }
            header nav { margin-top: 10px; }
            header a { display: block; margin: 5px 0; }
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar-brand">
            <a href="<?= BASIS_URL ?>/"><?= APP_NAME ?></a>
        </div>
        <nav>
            <a href="<?= BASIS_URL ?>/">Tabelle & Wettkampfplan</a>
            <a href="<?= BASIS_URL ?>/public/archive">Archiv</a>
            <?php if (\Core\Auth::check()): ?>
                <?php if (\Core\Auth::isAdmin()): ?>
                    <a href="<?= BASIS_URL ?>/admin/dashboard">Admin Dashboard</a>
                <?php else: ?>
                    <a href="<?= BASIS_URL ?>/club/dashboard">Vereins-Bereich</a>
                <?php endif; ?>
                <a href="<?= BASIS_URL ?>/auth/changePassword">Passwort ändern</a>
                <a href="<?= BASIS_URL ?>/auth/logout">Abmelden (<?= \Core\Session::get('user_name') ?>)</a>
            <?php else: ?>
                <a href="<?= BASIS_URL ?>/auth/login">Anmelden</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <?php foreach (\Core\Session::getFlashes() as $flash): ?>
            <div class="flash <?= $flash['type'] ?>">
                <?= htmlspecialchars($flash['message']) ?>
            </div>
        <?php endforeach; ?>

        <?= $content ?>
    </main>

    <footer>
        &copy; <?= date('Y') ?> BLALI - Blasrohr-Liga
    </footer>

    <script src="<?= BASIS_URL ?>/js/main.js"></script>
    <script src="<?= BASIS_URL ?>/js/table.js"></script>
</body>
</html>
