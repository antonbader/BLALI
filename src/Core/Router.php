<?php
namespace Core;

class Router {
    protected $routes = [];

    public function dispatch() {
        // Pfad aus der URL holen
        // Wir nehmen $_SERVER['REQUEST_URI'] und entfernen den QUERY_STRING
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Entferne das Basis-Verzeichnis des Skripts, um den relativen Pfad zu bekommen
        // scriptDir ist z.B. /mein-ordner
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        // public/index.php -> scriptDir ist /public (oder /pfad/public)

        // Wenn scriptDir nicht '/' ist, müssen wir es vom Anfang der URI entfernen
        if ($scriptDir !== '/' && strpos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        }

        $uri = trim($uri, '/');

        // Default Route
        if ($uri === '') {
            $controllerName = 'PublicController';
            $actionName = 'index';
        } else {
            $parts = explode('/', $uri);
            // Konvention: /controller/action/param
            // Wir mappen 'controller' auf 'ControllerNameController'
            // z.B. /admin/dashboard -> AdminController->dashboard

            $controllerPart = array_shift($parts);
            $actionPart = array_shift($parts) ?? 'index';

            // Controller Name: erster Buchstabe groß, Rest klein + 'Controller'
            $controllerName = ucfirst($controllerPart) . 'Controller';
            $actionName = $actionPart;

            // Parameter sind der Rest
            $params = $parts;
        }

        // Namespace hinzufügen
        $controllerClass = "Controllers\\" . $controllerName;

        // Prüfen ob Klasse existiert
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();

            if (method_exists($controller, $actionName)) {
                // Aufruf der Action mit Parametern
                // Wir nutzen call_user_func_array, um verbleibende URL-Teile als Argumente zu übergeben
                call_user_func_array([$controller, $actionName], $parts ?? []);
            } else {
                $this->handle404("Methode $actionName nicht gefunden in $controllerName");
            }
        } else {
            $this->handle404("Controller $controllerName nicht gefunden");
        }
    }

    private function handle404($msg = "") {
        header("HTTP/1.0 404 Not Found");
        echo "404 - Seite nicht gefunden. <br><small>$msg</small>";
        // Optional: Error Controller aufrufen
    }
}
