<?php
// install.php
// Dieses Skript initialisiert die Datenbank

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/src/Core/Database.php';

use Core\Database;

try {
    $db = Database::getInstance();
    $sql = file_get_contents(__DIR__ . '/database_setup.sql');

    // Split SQL by commands if necessary or run at once.
    // PDO might not support multiple queries in one call for SQLite in all versions,
    // but usually exec() works for batch if supported.
    // Safe way: split by semicolon

    $commands = explode(';', $sql);

    foreach ($commands as $command) {
        $command = trim($command);
        if (!empty($command)) {
            $db->getConnection()->exec($command);
        }
    }

    echo "Tabellen erfolgreich erstellt.<br>";

    // Initialen Admin-User anlegen
    // Prüfen, ob Admin schon existiert
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE username = 'admin'");
    $result = $stmt->fetch();

    if ($result['count'] == 0) {
        $password = password_hash('admin', PASSWORD_DEFAULT);
        $db->query("INSERT INTO users (username, password, role) VALUES ('admin', ?, 'admin')", [$password]);
        echo "Initialer Admin-User (admin/admin) wurde angelegt.<br>";
    } else {
        echo "Admin-User existiert bereits.<br>";
    }

    echo "Installation abgeschlossen.";

} catch (Exception $e) {
    echo "Fehler bei der Installation: " . $e->getMessage();
}
