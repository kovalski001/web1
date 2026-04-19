<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        die("Заполните все поля.");
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO registered_users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hash]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        header('Location: /cabinet.html');
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            die("Пользователь с таким именем или email уже существует.");
        } else {
            die("Ошибка регистрации.");
        }
    }
} else {
    header('Location: /register.html');
    exit;
}