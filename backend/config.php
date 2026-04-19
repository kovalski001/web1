<?php
$sessionPath = '/var/www/data/sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}
session_save_path($sessionPath);
session_start();
$db_path = '/var/www/data/salon.db';
$pdo = new PDO('sqlite:' . $db_path);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function requireAdmin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.html');
        exit;
    }
    // c полем role
	 global $pdo;
     $stmt = $pdo->prepare("SELECT role FROM registered_users WHERE id = ?");
     $stmt->execute([$_SESSION['user_id']]);
     $user = $stmt->fetch();
     if (!$user || $user['role'] !== 'admin') {
         http_response_code(403);
         die("К сожалению, вам доступ запрещён. Не обижайтесь :)");
    }
}