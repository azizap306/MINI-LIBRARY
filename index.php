<?php
require_once __DIR__ . '/config/auth.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: ' . (($_SESSION['role'] ?? 'user') === 'admin' ? 'dashboard.php' : 'katalog.php'));
    exit;
}

// Login otomatis melalui token remember-me yang disimpan dalam cookie.
if (!empty($_COOKIE['remember_user']) && !empty($_COOKIE['remember_token'])) {
    $q = $pdo->prepare("SELECT id, username, role, remember_token FROM users WHERE username = ?");
    $q->execute([$_COOKIE['remember_user']]);
    $u = $q->fetch();
    if ($u && $u['remember_token'] && hash_equals($u['remember_token'], hash('sha256', $_COOKIE['remember_token']))) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['username'] = $u['username'];
        $_SESSION['role'] = $u['role'];
        header('Location: ' . ($u['role'] === 'admin' ? 'dashboard.php' : 'katalog.php'));
        exit;
    }
}
?>
<!doctype html>
<html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk • Luma Library</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head><body class="login-page">
<div class="login-shell">
  <section class="login-visual">
    <div class="brand"><span class="brand-icon"><i class="bi bi-book-half"></i></span> luma<span>library</span></div>
    <div class="visual-copy">
      <span class="eyebrow">MINI DIGITAL LIBRARY</span>
      <h1>Temukan cerita.<br><em>Buka wawasan.</em></h1>
      <p>Ruang sederhana untuk mengelola koleksi buku dan menjaga setiap pengetahuan tetap dekat.</p>
    </div>
    <div class="visual-bottom"><i class="bi bi-stars"></i> Your little space for big ideas</div>
  </section>
  <section class="login-form-area">
    <div class="login-form">
      <div class="mobile-brand brand"><span class="brand-icon"><i class="bi bi-book-half"></i></span> luma<span>library</span></div>
      <span class="eyebrow text-muted">SELAMAT DATANG KEMBALI</span>
      <h2>Masuk ke akunmu</h2>
      <p class="text-secondary mb-4">Kelola koleksi buku dengan lebih mudah.</p>
      <?php tampil_flash(); ?>
      <form method="POST" action="proses_login.php">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <label class="form-label">Username</label>
        <div class="input-icon mb-3"><i class="bi bi-person"></i><input class="form-control" name="username" value="<?= e($_COOKIE['remember_user'] ?? '') ?>" placeholder="Masukkan username" required autofocus></div>
        <label class="form-label">Password</label>
        <div class="input-icon mb-3"><i class="bi bi-lock"></i><input class="form-control" type="password" name="password" placeholder="Masukkan password" required></div>
        <div class="d-flex justify-content-between align-items-center mb-4">
          <label class="form-check small"><input class="form-check-input" type="checkbox" name="remember" value="1" <?= isset($_COOKIE['remember_user']) ? 'checked' : '' ?>> Ingat saya</label>
          <a class="small register-link" href="register.php">Buat akun publik</a>
        </div>
        <button class="btn btn-dark w-100 btn-lg rounded-3">Masuk <i class="bi bi-arrow-right ms-2"></i></button>
      </form>
      <div class="demo-note mt-4"><i class="bi bi-info-circle me-2"></i>Admin demo: <b>admin</b> / <b>password</b></div>
    </div>
  </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
