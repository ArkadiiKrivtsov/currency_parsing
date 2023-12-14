<?php

namespace App\Database;

use Exception;
use mysqli;

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private ?mysqli $connection = null;

    private function __construct()
    {
        try {
            $servername = $_ENV['DB_HOST'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];
            $dbname = $_ENV['DB_NAME'];
            $this->connection = new mysqli($servername, $username, $password, $dbname);

        } catch (Exception $e) {
            $_SESSION['error_message'] = "Проверьте настройки подключения к базе.";
        }
    }

    public static function getInstance(): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): ?mysqli
    {
        return $this->connection;
    }
}
