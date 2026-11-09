<?php
require_once __DIR__ . '/config/auth.php';
if (!empty($_SESSION['user_id'])) {
    $pdo->prepare('UPDATE users SET remember_token = NULL WHERE id = ?')->execute([$_SESSION['user_id']]);
}
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'] ?? '', $p['secure'], $p['httponly']);
}
setcookie('remember_user', '', time()-3600, '/');
setcookie('remember_token', '', time()-3600, '/');
session_destroy();
header('Location: index.php'); exit;
