<?php
// config/config.php

// Automatische Erkennung der Basis-URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);

// Da index.php in /public liegt, müssen wir schauen, wo das im Pfad ist
// Wenn wir z.B. unter /mein-ordner/public/index.php aufgerufen werden, ist scriptDir /mein-ordner/public
// Die Basis-URL für Assets sollte /mein-ordner/public sein
// Die Basis-URL für Links innerhalb der App sollte auch relativ dazu sein

// Bereinige Slashes am Ende
$scriptDir = rtrim($scriptDir, '/');

define('BASIS_URL', $protocol . "://" . $host . $scriptDir);
define('ROOT_PFAD', dirname(__DIR__));
define('VIEW_PFAD', ROOT_PFAD . '/views');
define('APP_NAME', 'Blasrohr-Liga V9.0');

// Fehleranzeige (für Entwicklung an, später ausschalten)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Zeitzone
date_default_timezone_set('Europe/Berlin');
