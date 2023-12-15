<?php

namespace App\Database;

use Exception;
use mysqli;
use mysqli_result;

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
            $connection = $this->connection = new mysqli($servername, $username, $password, $dbname);

            $connection->begin_transaction();
            $this->migrate();
            $connection->commit();

        } catch (Exception $e) {
            $_SESSION['error_message'] = "Проверьте настройки подключения к базе.";
            $this->connection->rollback();
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

    private function migrate(): void
    {
        $migrationsNames = ['create_users_table', 'create_currencies_table', 'add_currencies', 'create_last_run_time_table', 'add_update_rates_process'];

        $connection = $this->connection;

        foreach ($migrationsNames as $name) {
            $migration = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . $name . '.sql');
            $connection->query("$migration");
        }
    }
}
