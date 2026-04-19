<?php
// запускаем сессию
session_start();

// сбрасываем сессию
$_SESSION = array();

// если используются куки удаляем
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// удаляем сессию
session_destroy();

// на главную
header('Location: /index.html');
exit;