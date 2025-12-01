<?php
namespace Core;

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $config = require ROOT_PFAD . '/config/db.php';

        try {
            if ($config['type'] === 'sqlite') {
                $dsn = 'sqlite:' . $config['file'];
                $this->pdo = new \PDO($dsn);
            } else {
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
                $this->pdo = new \PDO($dsn, $config['user'], $config['pass']);
            }

            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

            // Aktivieren von Fremdschlüsseln für SQLite
            if ($config['type'] === 'sqlite') {
                $this->pdo->exec("PRAGMA foreign_keys = ON;");
            }

        } catch (\PDOException $e) {
            die("Datenbankverbindungsfehler: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    // Helper für Prepared Statements
    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Letzte Insert ID
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
