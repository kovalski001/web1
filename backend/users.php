<?php
require_once 'config.php';
requireAdmin();
$stmt = $pdo->query("SELECT id, username, email, registered_at FROM registered_users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Пользователи | Админка</title>
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
        max-width: 1000px;
        margin: 30px auto;
        padding: 30px;
        background: rgba(20, 20, 20, 0.85);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.6), 0 0 0 1px rgba(238, 99, 0, 0.2);
        border: 1px solid rgba(238, 99, 0, 0.25);
    }
    td {
    	color: white;
    }
    h1 {
        color: #ffffff;
        font-family: 'Faberge', sans-serif;
        padding-bottom: 10px;
    }
    .breadcrumbs {
        color: #b0b0b0;
        margin-bottom: 20px;
    }
    .breadcrumbs a {
        color: #ee6300;
        text-decoration: none;
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(30, 30, 30, 0.7);
        border-radius: 16px;
        overflow: hidden;
    }
    .admin-table th {
        background: #ee6300;
        color: white;
        padding: 12px;
        text-align: left;
        font-family: 'Faberge', sans-serif;
    }
    .admin-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #3a3a3a;
    }
    .admin-table tr:hover td {
        background: rgba(238, 99, 0, 0.1);
    }
    .pagination {
        margin-top: 30px;
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    .pagination a {
        padding: 8px 16px;
        background: #2a2a2a;
        color: #e0e0e0;
        border-radius: 8px;
        text-decoration: none;
    }
    .pagination a:hover {
        background: #ee6300;
        color: white;
    }
    input[type="text"] {
        padding: 12px 16px;
        border: 2px solid #2a2a2a;
        border-radius: 40px;
        background: #1a1a1a;
	font-size: 20px;
        color: white;
        width: 100%;
        max-width: 300px;
    }
    .logo h1, .logo h1 span {
   	font-family: 'Princess', cursive !important;
    	color: #ffffff;
    }
    .logo h1 span {
   	 color: #ee6300;
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
        <div class="breadcrumbs"><a href="/index.html">Главная</a> / <a href="admin.php">Админка</a> / Пользователи</div>
        <h1>Пользователи</h1>
        <input type="text" placeholder="Поиск..." style="margin-bottom:10px; padding:8px; width:100%;">
        <table class="admin-table">
            <tr><th>ID</th><th>Логин</th><th>Email</th><th>Дата регистрации</th></tr>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['registered_at'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="pagination">
            <a href="#">Назад</a> <a href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">Вперёд</a>
        </div>
    </main>
</body>
</html>