<?php
function header_html(string $title): void { ?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?> • Luma Library</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet"></head><body class="app-page">
<aside class="sidebar">
  <a class="brand" href="dashboard.php"><span class="brand-icon"><i class="bi bi-book-half"></i></span> luma<span>library</span></a>
  <div class="side-label">MENU UTAMA</div>
  <a class="side-link <?= basename($_SERVER['PHP_SELF'])==='dashboard.php'?'active':'' ?>" href="dashboard.php"><i class="bi bi-grid-1x2"></i> Dashboard</a>
  <a class="side-link <?= in_array(basename($_SERVER['PHP_SELF']),['tambah_buku.php','edit_buku.php'])?'active':'' ?>" href="tambah_buku.php"><i class="bi bi-plus-circle"></i> Tambah Buku</a>
  <div class="sidebar-bottom"><div class="user-mini"><div class="avatar"><?= strtoupper(substr($_SESSION['username'],0,1)) ?></div><div><b><?= e($_SESSION['username']) ?></b><small><?= e($_SESSION['role'] ?? 'admin') ?></small></div></div><a href="logout.php" class="logout-link"><i class="bi bi-box-arrow-left"></i> Keluar</a></div>
</aside>
<main class="main-content"><header class="topbar"><div><span class="eyebrow">DIGITAL LIBRARY</span><h5><?= e($title) ?></h5></div><div class="topbar-right"><span class="status-dot"></span><small>Admin online</small><div class="avatar"><?= strtoupper(substr($_SESSION['username'],0,1)) ?></div></div></header>
<div class="page-inner">
<?php }
function footer_html(): void { ?>
</div></main><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body></html>
<?php }
