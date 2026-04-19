<?php
require_once 'config.php';
requireAdmin();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Административная панель | Салон Красоты Beauty</title>
    <link rel="stylesheet" href="/styles.css">
    <link rel="stylesheet" href="/cabinet-styles.css">
    <style>
    body {
        background: #0a0a0a;
        font-family: 'TT', sans-serif;
        margin: 0;
        padding: 0;
	display: flex;
	flex-direction: column;
	min-height: 100vh;
    }
    main {
    	flex: 1;
    }
    p {
    color: white;
    }
    .admin-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 30px;
        background: rgba(20, 20, 20, 0.85);
        backdrop-filter: blur(8px);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.6), 0 0 0 1px rgba(238, 99, 0, 0.2);
        border: 1px solid rgba(238, 99, 0, 0.25);
        color: #f0f0f0;
    }
    .admin-container h2, .admin-container h3 {
        color: #ffffff;
        font-family: 'Faberge', sans-serif;
        margin-top: 0;
    }
    .admin-container h2 {
        padding-bottom: 10px;
		transform: translateX(0px);
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
        font-weight: 600;
        padding: 14px 12px;
        text-align: left;
        font-family: 'Faberge', sans-serif;
    }
    .admin-table td {
        padding: 12px;
        color: #e0e0e0;
    }
    .logout-btn {
        display: inline-block;
        margin-left: 20px;
        color: #ee6300 !important;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    .logout-btn:hover {
        color: #ff7518 !important;
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
        <h2>Админка</h2>
        <h3>Заявки с формы записи</h3>
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM contact_requests ORDER BY created_at DESC");
            $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($requests) > 0) {
                echo '<table class="admin-table">';
                echo '<tr><th>ID</th><th>Имя</th><th>Контакт</th><th>Сообщение</th><th>Дата</th></tr>';
                foreach ($requests as $r) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($r['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($r['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($r['contact']) . '</td>';
                    echo '<td>' . htmlspecialchars($r['message']) . '</td>';
                    echo '<td>' . htmlspecialchars($r['created_at']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>Заявок пока нет.</p>';
            }
        } catch (PDOException $e) {
            echo '<p style="color:red;">Ошибка базы данных: ' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        ?>
    </main>

    <footer>
        <p class="footer-text">© 2026 Салон Красоты Beauty.<br><a href="https://vk.com/cnbbygirl">Вконтакте</a><br><a href="https://t.me/cnbbyy">Телеграм</a></p>
    </footer>
</body>
</html>