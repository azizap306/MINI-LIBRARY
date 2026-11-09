<?php
require_once __DIR__ . '/config/auth.php';
wajib_login();

if (($_SESSION['role'] ?? 'user') === 'admin') {
    header('Location: dashboard.php'); exit;
}

$q = trim($_GET['q'] ?? '');
$term = '%' . $q . '%';
$stmt = $pdo->prepare(
    'SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY judul ASC'
);
$stmt->execute([$term, $term, $term]);
$buku = $stmt->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Katalog Buku • Luma Library</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="app-page">
<nav class="navbar bg-white border-bottom px-3 px-md-5 py-3">
  <a class="brand text-dark" href="katalog.php"><span class="brand-icon" style="background:#6e5bc3"><i class="bi bi-book-half"></i></span> luma<span>library</span></a>
  <div class="d-flex align-items-center gap-3"><span class="small text-secondary">Halo, <?= e($_SESSION['username']) ?></span><a href="logout.php" class="btn btn-outline-secondary btn-sm">Keluar</a></div>
</nav>
<main class="container py-5">
  <div class="welcome-card mb-4"><div><span class="eyebrow">KATALOG PERPUSTAKAAN</span><h2>Jelajahi koleksi buku 📚</h2><p>Temukan bacaan yang menarik untuk menambah wawasanmu.</p></div></div>
  <form method="GET" class="search-box bg-white mb-4"><i class="bi bi-search"></i><input name="q" value="<?= e($q) ?>" placeholder="Cari judul, penulis, kategori..."><button aria-label="Cari"><i class="bi bi-arrow-right"></i></button></form>
  <div class="row g-3">
  <?php if (!$buku): ?><div class="col-12"><div class="content-card text-center text-secondary py-5">Belum ada buku yang cocok dengan pencarian.</div></div><?php endif; ?>
  <?php foreach ($buku as $b): ?>
    <div class="col-6 col-md-4 col-lg-3"><article class="content-card h-100 p-3">
      <?php if (!empty($b['sampul'])): ?>
        <img src="uploads/<?= e($b['sampul']) ?>" alt="Sampul <?= e($b['judul']) ?>" class="w-100 rounded-3 mb-3" style="height:190px;object-fit:cover">
      <?php else: ?>
        <div class="cover-placeholder w-100 rounded-3 mb-3" style="height:190px;font-size:40px"><i class="bi bi-book"></i></div>
      <?php endif; ?>
      <span class="category-pill"><?= e($b['kategori']) ?></span>
      <h6 class="mt-3 mb-1 fw-bold"><?= e($b['judul']) ?></h6>
      <p class="small text-secondary mb-2"><?= e($b['penulis']) ?> · <?= e($b['tahun']) ?></p>
      <span class="badge text-bg-<?= (int)$b['stok'] > 0 ? 'success' : 'warning' ?>"><?= (int)$b['stok'] > 0 ? 'Tersedia' : 'Sedang dipinjam' ?></span>
    </article></div>
  <?php endforeach; ?>
  </div>
</main>
</body></html>
