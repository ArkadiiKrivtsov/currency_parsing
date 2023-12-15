CREATE TABLE IF NOT EXISTS currencies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    currency_name VARCHAR(255) NOT NULL UNIQUE,
    exchange_rate DECIMAL(10, 4),
    updated_at DATETIME  DEFAULT CURRENT_TIMESTAMP NOT NULL
);