<?php
require_once __DIR__ . '/config/auth.php';
cek_csrf();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirm = $_POST['password_confirm'] ?? '';

if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $username)) {
    flash('danger', 'Username harus 3–50 karakter dan hanya berisi huruf, angka, atau garis bawah.');
    header('Location: register.php'); exit;
}
if (strlen($password) < 8) {
    flash('danger', 'Password minimal 8 karakter.');
    header('Location: register.php'); exit;
}
if ($password !== $confirm) {
    flash('danger', 'Konfirmasi password tidak sama.');
    header('Location: register.php'); exit;
}

try {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        flash('danger', 'Username sudah digunakan. Silakan pilih username lain.');
        header('Location: register.php'); exit;
    }

    // Role selalu ditentukan server sebagai user, bukan dari input browser.
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $insert = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
    $insert->execute([$username, $hash]);

    flash('success', 'Pendaftaran berhasil. Silakan login dengan akun baru.');
    header('Location: index.php'); exit;
} catch (PDOException $e) {
    error_log($e->getMessage());
    flash('danger', 'Pendaftaran gagal. Pastikan kolom role sudah tersedia pada tabel users.');
    header('Location: register.php'); exit;
}
