<?php
require_once 'config.php';
requireAdmin();
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM contact_requests WHERE id = ?");
$stmt->execute([$id]);
$req = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$req) die("Заявка не найдена");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Просмотр заявки #<?= $id ?></title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/cabinet-styles.css">
    <style>
    body {
        background: #0a0a0a;
        color: #e0e0e0;
        font-family: 'TT', sans-serif;
        margin: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    main {
        flex: 1;
    }
    .admin-container {
        max-width: 800px;
        margin: 30px auto;
        padding: 30px;
        background: rgba(20, 20, 20, 0.85);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.6), 0 0 0 1px rgba(238, 99, 0, 0.2);
        border: 1px solid rgba(238, 99, 0, 0.25);
    }
    h1 {
        color: #ffffff;
        font-family: 'Faberge', sans-serif;
        padding-bottom: 10px;
    }
    .logo h1, .logo h1 span {
        font-family: 'Princess', cursive !important;
        color: #ffffff;
    }
    .logo h1 span {
        color: #ee6300;
    }
    .breadcrumbs {
        color: #b0b0b0;
        margin-bottom: 20px;
    }
    .breadcrumbs a {
        color: #ee6300;
        text-decoration: none;
    }
    p {
        line-height: 1.6;
        color: white;
    }
</style>
</head>
<body>
    <header class="inner-page">
        <div class="header-content">
            <div class="logo">
                <a href="/index.html">
                    <h1>Салон Красоты<br><span>Beauty</span></h1>
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="/index.html">Главная</a></li>
                    <li><a href="/cabinet.html">Кабинет</a></li>
                    <li><a href="/backend/logout.php" class="logout-btn">Выйти</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="admin-container">
        <div class="breadcrumbs"><a href="/index.html">Главная</a> / <a href="admin.php">Заявки</a> / Просмотр</div>
        <h1>Заявка №<?= $id ?></h1>
        <p><strong>Имя:</strong> <?= htmlspecialchars($req['name']) ?></p>
        <p><strong>Контакт:</strong> <?= htmlspecialchars($req['contact']) ?></p>
        <p><strong>Сообщение:</strong> <?= nl2br(htmlspecialchars($req['message'])) ?></p>
        <p><strong>Дата:</strong> <?= $req['created_at'] ?></p>
        <a href="admin.php">← Назад к списку</a>
    </main>
</body>
</html>