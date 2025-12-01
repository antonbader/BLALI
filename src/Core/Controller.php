<?php
namespace Core;

abstract class Controller {
    protected function view($path, $data = []) {
        // Extrahiere Daten zu Variablen
        extract($data);

        // View laden
        $viewFile = VIEW_PFAD . '/' . $path . '.php';

        if (file_exists($viewFile)) {
            // Wir puffern den Output, um ihn in ein Layout einbetten zu können
            ob_start();
            require $viewFile;
            $content = ob_get_clean();

            // Layout laden (Standard: main)
            // Man kann das Layout in der View überschreiben, indem man $layout setzt,
            // aber wir machen es hier einfach.
            if (isset($noLayout) && $noLayout === true) {
                echo $content;
            } else {
                require VIEW_PFAD . '/layouts/main.php';
            }
        } else {
            die("View nicht gefunden: $path");
        }
    }

    protected function redirect($path) {
        header('Location: ' . BASIS_URL . $path);
        exit;
    }

    // Einfache Input-Sanitizer
    protected function input($key, $default = null) {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    protected function query($key, $default = null) {
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
    }
}
