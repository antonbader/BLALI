<?php
// public/index.php

// Autoloader für Klassen
spl_autoload_register(function ($class) {
    // Namespace Prefix Mapping
    // src/Core/Router -> Core/Router

    // Basis-Verzeichnis für den Namespace Prefix
    $base_dir = __DIR__ . '/../src/';

    // Ersetze Namespace-Separator mit Verzeichnis-Separator
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    // Wenn die Datei existiert, binde sie ein
    if (file_exists($file)) {
        require $file;
    }
});

// Konfiguration laden
require_once __DIR__ . '/../config/config.php';

// Router initialisieren und Anfrage verarbeiten
use Core\Router;
use Core\Session;

// Session starten
Session::start();

// Einfacher Router Aufruf
try {
    $router = new Router();
    $router->dispatch();
} catch (Exception $e) {
    echo "Ein Fehler ist aufgetreten: " . $e->getMessage();
    // In Produktion: Fehler loggen und generische Seite anzeigen
    error_log($e->getMessage());
}
