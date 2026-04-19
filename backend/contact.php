<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('ЭТОТ метод не поддерживается');
}

$name = trim($_POST['name'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($contact) || empty($message)) {
    http_response_code(400);
    exit('Заполните все поля пожалуйста');
}

$user_id = $_SESSION['user_id'] ?? null;

try {
    $stmt = $pdo->prepare("INSERT INTO contact_requests (user_id, name, contact, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $name, $contact, $message]);

    // отправка email
    $to = 'admin@beauty-salon.local';
    $subject = 'Новая заявка с сайта';
    $body = "Имя: $name\nКонтакт: $contact\nСообщение: $message\nПользователь ID: " . ($user_id ?? 'гость');
    mail($to, $subject, $body);

    echo 'заявка отправлена';
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Ошибка базы данных: ' . $e->getMessage();
}