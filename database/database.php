<?php

$servername = $_ENV['DB_HOST'] ?? 'localhost';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';
$dbname = $_ENV['DB_NAME'] ?? 'database';

try {
    $connection = new mysqli ($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        throw new Exception();
        die();
    } else {
        $isDatabaseConnect = true;
    }
} catch (Exception $e) {
    $isDatabaseConnect = false;
}
