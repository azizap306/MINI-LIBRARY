<?php
require_once __DIR__ . '/config/auth.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: ' . (($_SESSION['role'] ?? 'user') === 'admin' ? 'dashboard.php' : 'katalog.php'));
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar • Luma Library</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
<div class="login-shell">
<section class="login-visual">
  <div class="brand"><span class="brand-icon"><i class="bi bi-book-half"></i></span> luma<span>library</span></div>
  <div class="visual-copy"><span class="eyebrow">GABUNG BERSAMA KAMI</span><h1>Mulai petualangan<br><em>membaca.</em></h1><p>Buat akun gratis untuk menjelajahi koleksi buku perpustakaan digital.</p></div>
  <div class="visual-bottom"><i class="bi bi-stars"></i> Your little space for big ideas</div>
</section>
<section class="login-form-area"><div class="login-form">
  <div class="mobile-brand brand"><span class="brand-icon"><i class="bi bi-book-half"></i></span> luma<span>library</span></div>
  <span class="eyebrow text-muted">PENDAFTARAN PENGGUNA</span>
  <h2>Buat akun publik</h2>
  <p class="text-secondary mb-4">Isi data berikut untuk mulai menjelajahi koleksi.</p>
  <?php tampil_flash(); ?>
  <form method="POST" action="proses_register.php">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <label class="form-label">Username</label>
    <div class="input-icon mb-3"><i class="bi bi-person"></i><input class="form-control" name="username" required minlength="3" maxlength="50" pattern="[A-Za-z0-9_]+" placeholder="Huruf, angka, garis bawah"></div>
    <label class="form-label">Password</label>
    <div class="input-icon mb-3"><i class="bi bi-lock"></i><input class="form-control" type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter"></div>
    <label class="form-label">Konfirmasi password</label>
    <div class="input-icon mb-4"><i class="bi bi-shield-lock"></i><input class="form-control" type="password" name="password_confirm" required minlength="8" placeholder="Ulangi password"></div>
    <button class="btn btn-dark w-100 btn-lg rounded-3">Daftar sekarang <i class="bi bi-arrow-right ms-2"></i></button>
  </form>
  <p class="text-center small mt-4 mb-0">Sudah punya akun? <a href="index.php" class="register-link">Masuk</a></p>
</div></section>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
