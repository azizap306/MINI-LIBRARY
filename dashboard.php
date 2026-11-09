<?php
require_once __DIR__ . '/config/auth.php'; wajib_admin(); require_once __DIR__ . '/config/layout.php';
$q = trim($_GET['q'] ?? '');
$sql = "SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? OR kategori LIKE ? ORDER BY id DESC";
$stmt = $pdo->prepare($sql); $term = "%$q%"; $stmt->execute([$term,$term,$term]); $buku = $stmt->fetchAll();
$total = (int)$pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn();
$tersedia = (int)$pdo->query("SELECT COUNT(*) FROM buku WHERE stok > 0")->fetchColumn();
$kategori = (int)$pdo->query("SELECT COUNT(DISTINCT kategori) FROM buku")->fetchColumn();
header_html('Dashboard');
?>
<div class="welcome-card"><div><span class="eyebrow">OVERVIEW KOLEKSI</span><h2>Halo, <?= e($_SESSION['username']) ?>! 👋</h2><p>Ini ringkasan koleksi perpustakaan digitalmu hari ini.</p></div><a href="tambah_buku.php" class="btn btn-light rounded-3"><i class="bi bi-plus-lg me-2"></i>Tambah buku</a></div>
<?php tampil_flash(); ?>
<div class="row g-3 stats-row">
<div class="col-md-4"><div class="stat-card"><div class="stat-icon purple"><i class="bi bi-journals"></i></div><span>Total koleksi</span><strong><?= $total ?></strong><small>Judul buku terdaftar</small></div></div>
<div class="col-md-4"><div class="stat-card"><div class="stat-icon green"><i class="bi bi-bookmark-check"></i></div><span>Buku tersedia</span><strong><?= $tersedia ?></strong><small>Siap dipinjam</small></div></div>
<div class="col-md-4"><div class="stat-card"><div class="stat-icon orange"><i class="bi bi-tags"></i></div><span>Kategori</span><strong><?= $kategori ?></strong><small>Kategori koleksi</small></div></div>
</div>
<section class="content-card mt-4">
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3"><div><h5 class="mb-1">Koleksi buku</h5><p class="text-secondary small mb-0">Kelola dan pantau seluruh buku di perpustakaan.</p></div>
<form class="search-box" method="GET"><i class="bi bi-search"></i><input name="q" value="<?= e($q) ?>" placeholder="Cari judul, penulis, kategori..."><button aria-label="Cari"><i class="bi bi-arrow-right"></i></button></form></div>
<div class="table-responsive"><table class="table align-middle library-table"><thead><tr><th>BUKU</th><th>KATEGORI</th><th>PENULIS</th><th>TAHUN</th><th>STOK</th><th>STATUS</th><th class="text-end">AKSI</th></tr></thead><tbody>
<?php if (!$buku): ?><tr><td colspan="7" class="text-center py-5 text-secondary">Belum ada buku. Tambahkan koleksi pertamamu.</td></tr><?php endif; ?>
<?php foreach ($buku as $b): [$label,$warna] = status_buku((int)$b['stok']); ?>
<tr><td><div class="book-cell"><?php if ($b['sampul']): ?><img src="uploads/<?= e($b['sampul']) ?>" alt="Sampul"><?php else: ?><div class="cover-placeholder"><i class="bi bi-book"></i></div><?php endif; ?><b><?= e($b['judul']) ?></b></div></td><td><span class="category-pill"><?= e($b['kategori']) ?></span></td><td><?= e($b['penulis']) ?></td><td><?= e($b['tahun']) ?></td><td><?= (int)$b['stok'] ?></td><td><span class="badge text-bg-<?= $warna ?> status-pill"><?= $label ?></span></td><td class="text-end"><a class="action-btn" href="edit_buku.php?id=<?= (int)$b['id'] ?>" title="Edit"><i class="bi bi-pencil-square"></i></a><form class="d-inline" method="POST" action="hapus_buku.php" onsubmit="return confirm('Yakin ingin menghapus buku ini?')"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$b['id'] ?>"><button class="action-btn danger" title="Hapus"><i class="bi bi-trash3"></i></button></form></td></tr>
<?php endforeach; ?></tbody></table></div>
<div class="table-foot"><span>Menampilkan <?= count($buku) ?> dari <?= $total ?> buku</span><span><i class="bi bi-shield-check me-1"></i> Data tersimpan di database</span></div>
</section>
<?php footer_html(); ?>
