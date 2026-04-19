<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM registered_users WHERE username = ? OR email = ?");
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
// здесь определяем роль
    if (isset($user['role']) && $user['role'] === 'admin') {
         header('Location: /backend/admin.php');
     } else {
         header('Location: /cabinet.html');
     }
        exit;
    } else {
        die("Неверный логин или пароль");
    }
} else {
    header('Location: /login.html');
    exit;
}