<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use mysqli;
use mysqli_result;

class LastRunTimeRepository
{
    private DatabaseConnection $db;
    private ?mysqli $connection;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance();
        $this->connection = $this->db->getConnection();
    }

    public function getLastUpdateTime(): mysqli_result|bool
    {
        $query = "SELECT updated_at FROM last_run_time WHERE process_name = 'update_rates'";
        $result = $this->connection->query($query)->fetch_assoc();
        return strtotime($result['updated_at']);
    }

    public function isTimeToUpdate(): bool
    {
        $currentTime = time();
        $lastRunTime = $this->getLastUpdateTime();

        if ($currentTime - $lastRunTime >= 3 * 60 * 60) {
            return true;
        }
        return false;
    }

    public function updateTime(): void
    {
        $updateQuery = "UPDATE last_run_time SET updated_at = NOW() WHERE process_name = 'update_rates'";
        $this->connection->query($updateQuery);
    }
}