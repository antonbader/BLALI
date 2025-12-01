<?php
// config/db.php

// Default: MySQL Configuration (as requested)
// To use SQLite, change 'type' to 'sqlite' and ensure 'file' is set.

$dbDir = dirname(__DIR__) . '/data';
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0775, true);
}

// Check environment variable or default to MySQL
// In this specific sandbox environment, we might want to default to SQLite if MySQL is not available,
// but the requirement is "Default MySQL". So the config will reflect that.
// Users must provide valid MySQL credentials.

return [
    'type' => 'mysql', // Changed from 'sqlite' to 'mysql'
    'host' => 'localhost',
    'dbname' => 'blasrohr_liga',
    'user' => 'root',
    'pass' => '',

    // Fallback/Alternative SQLite config (kept for reference or dev switching)
    'sqlite_file' => $dbDir . '/blasrohr.sqlite',
];
