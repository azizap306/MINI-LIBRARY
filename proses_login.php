<?php
require_once __DIR__ . '/config/auth.php';
cek_csrf();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$stmt = $pdo->prepare('SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    flash('danger', 'Username atau password salah.');
    header('Location: index.php'); exit;
}
session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

if (!empty($_POST['remember'])) {
    $token = bin2hex(random_bytes(32));
    $hash = hash('sha256', $token);
    $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$hash, $user['id']]);
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    setcookie('remember_user', $user['username'], ['expires' => time()+60*60*24*30, 'path'=>'/', 'secure'=>$secure, 'httponly'=>true, 'samesite'=>'Lax']);
    setcookie('remember_token', $token, ['expires' => time()+60*60*24*30, 'path'=>'/', 'secure'=>$secure, 'httponly'=>true, 'samesite'=>'Lax']);
} else {
    $pdo->prepare('UPDATE users SET remember_token = NULL WHERE id = ?')->execute([$user['id']]);
    setcookie('remember_user', '', time()-3600, '/');
    setcookie('remember_token', '', time()-3600, '/');
}
header('Location: ' . ($user['role'] === 'admin' ? 'dashboard.php' : 'katalog.php')); exit;
