<?php
$db_path = '/var/www/data/salon.db';

try {
    $pdo = new PDO('sqlite:' . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS staff (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        position TEXT NOT NULL,
        bio TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS services (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        description TEXT,
        price REAL NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS price_list (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        service_id INTEGER,
        price REAL,
        FOREIGN KEY(service_id) REFERENCES services(id)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_name TEXT,
        rating INTEGER,
        comment TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS registered_users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password_hash TEXT NOT NULL,
        role TEXT DEFAULT 'user',
        registered_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_requests (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        name TEXT NOT NULL,
        contact TEXT NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY(user_id) REFERENCES registered_users(id)
    )");

    // типа админ (пароль: admin1234)
    $pdo->exec("INSERT OR IGNORE INTO registered_users (username, email, password_hash, role) VALUES 
        ('admin', 'admin@mail.ru', '" . password_hash('admin1234', PASSWORD_DEFAULT) . "', 'admin')
    ");

    echo "Ваша база данных создана.\n";
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}