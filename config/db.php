<?php
// config/db.php

// Wir verwenden SQLite für maximale Portabilität ("beliebige Ordner")
// Die Datenbankdatei wird im 'data' Ordner außerhalb von public erstellt.

$dbDir = dirname(__DIR__) . '/data';
if (!is_dir($dbDir)) {
    mkdir($dbDir, 0775, true);
}

return [
    'type' => 'sqlite',
    'file' => $dbDir . '/blasrohr.sqlite',
    // Optional: MySQL Konfiguration
    'host' => 'localhost',
    'dbname' => 'blasrohr_liga',
    'user' => 'root',
    'pass' => '',
];
