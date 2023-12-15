<?php

namespace App\Repository;

use App\Database\DatabaseConnection;
use Exception;

class UsersRepository
{
    private DatabaseConnection $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance();
    }

    public function create(array $data): bool
    {
        $name = $data['name'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $preparedSql = "INSERT INTO users(email, password, username) VALUES (?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($preparedSql);

        try {
            if ($stmt) {
                $stmt->bind_param("sss", $email, $password, $name);
                $stmt->execute();
                $stmt->close();
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Ошибка добавления в базу';
            return false;
        }
        return true;
    }

    public function getUserPass(string $email): string
    {
        $preparedSql = "SELECT password FROM users WHERE email = ?";
        $stmt = $this->db->getConnection()->prepare($preparedSql);
        try {
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($password);
                $stmt->fetch();
                $stmt->close();
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Ошибка подключения к бд';
        }

        return $password ?? '';
    }
}
