<?php
// install.php
// Dieses Skript initialisiert die Datenbank

$config = require __DIR__ . '/config/config.php';
$dbConfig = require __DIR__ . '/config/db.php';

require_once __DIR__ . '/src/Core/Database.php';

use Core\Database;

try {
    $db = Database::getInstance();

    // Select SQL file based on configured database type
    $type = $dbConfig['type'] ?? 'sqlite';

    if ($type === 'mysql') {
        $sqlFile = __DIR__ . '/database_mysql.sql';
        echo "Lade MySQL Schema...<br>";
    } else {
        $sqlFile = __DIR__ . '/database_setup.sql';
        echo "Lade SQLite Schema...<br>";
    }

    if (!file_exists($sqlFile)) {
        throw new Exception("SQL Datei nicht gefunden: $sqlFile");
    }

    $sql = file_get_contents($sqlFile);

    // Execute SQL
    // For MySQL, splitting by ';' might be fragile if stored procedures were used,
    // but for this simple schema it is fine.
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
