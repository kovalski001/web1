<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

$stmt = $pdo->prepare("SELECT username, email FROM registered_users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['username' => $user['username'], 'email' => $user['email']]);
} else {
    http_response_code(401);
    echo json_encode(['error' => 'User not found']);
}