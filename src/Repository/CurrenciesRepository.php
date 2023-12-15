<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use Exception;

class CurrenciesRepository
{
    private DatabaseConnection $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance();
    }

    public function update(array $data): bool
    {
        $connection = $this->db->getConnection();

        $connection->begin_transaction();
        if (!empty($data)) {
            foreach ($data as $currency) {
                $name = $currency['name'];
                $value = floatval(str_replace(',', '.', $currency['value']));;
                $query = "UPDATE currencies SET exchange_rate = ? WHERE currency_name = ?";
                $stmt = $connection->prepare($query);

                try {
                    if ($stmt) {
                        $stmt->bind_param("ds", $value, $name);
                        $stmt->execute();
                        $stmt->close();
                    }

                    $connection->commit();
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Ошибка добавления в базу';
                    $connection->rollback();
                    return false;
                }
            }
        }

        return true;
    }

    public function getCurrencies(): array
    {
        $sql = "SELECT * FROM currencies";

        $result = $this->db->getConnection()->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $resultArray[] = $row;
            }
        }

        return $resultArray ?? [];
    }

    public function getRate(string $currencyName): string|null
    {
        $preparedSql = "SELECT exchange_rate FROM currencies WHERE currency_name = ?";
        $stmt = $this->db->getConnection()->prepare($preparedSql);

        try {
            if ($stmt) {
                $stmt->bind_param("s", $currencyName);
                $stmt->execute();
                $stmt->bind_result($rate);
                $stmt->fetch();
                $stmt->close();
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Ошибка подключения к бд';
        }

        return $rate ?? null;
    }
}