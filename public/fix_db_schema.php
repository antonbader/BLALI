<?php
// Fixes the database schema for existing installations
require_once __DIR__ . '/../src/Core/Database.php';

$db = \Core\Database::getInstance();

try {
    echo "Updating competitions table status column...\n";
    // We include 'beendet' for backward compatibility, though the code uses 'archiviert'
    $sql = "ALTER TABLE competitions MODIFY COLUMN status ENUM('geplant', 'aktiv', 'beendet', 'deaktiviert', 'archiviert') DEFAULT 'geplant'";
    $db->query($sql);
    echo "Success: Database schema updated.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
