<?php
require_once __DIR__ . '/config/auth.php'; wajib_admin(); require_once __DIR__ . '/config/layout.php';
$id=filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
$stmt=$pdo->prepare('SELECT * FROM buku WHERE id=?'); $stmt->execute([$id]); $b=$stmt->fetch();
if (!$b) { flash('danger','Data buku tidak ditemukan.'); header('Location: dashboard.php'); exit; }
header_html('Edit Buku');
?>
<div class="form-heading"><a href="dashboard.php" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke dashboard</a><h2>Edit informasi buku</h2><p>Perbarui detail koleksi sesuai informasi terbaru.</p></div>
<?php tampil_flash(); ?>
<form action="proses_edit.php" method="POST" enctype="multipart/form-data" class="content-card form-card">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
<div class="section-title"><span>01</span><div><b>Informasi buku</b><small>Ubah detail dasar koleksi.</small></div></div>
<div class="row g-3"><div class="col-md-8"><label class="form-label">Judul buku *</label><input class="form-control" name="judul" required maxlength="180" value="<?= e($b['judul']) ?>"></div>
<div class="col-md-4"><label class="form-label">Kategori *</label><input class="form-control" name="kategori" required maxlength="80" value="<?= e($b['kategori']) ?>"></div>
<div class="col-md-6"><label class="form-label">Penulis *</label><input class="form-control" name="penulis" required maxlength="120" value="<?= e($b['penulis']) ?>"></div>
<div class="col-md-3"><label class="form-label">Tahun terbit *</label><input class="form-control" type="number" name="tahun" min="1000" max="<?= date('Y') ?>" required value="<?= e($b['tahun']) ?>"></div>
<div class="col-md-3"><label class="form-label">Stok *</label><input class="form-control" type="number" name="stok" min="0" required value="<?= e($b['stok']) ?>"></div></div>
<hr class="soft-divider"><div class="section-title"><span>02</span><div><b>Sampul buku</b><small>Unggah gambar baru jika ingin mengganti sampul.</small></div></div>
<?php if ($b['sampul']): ?><div class="current-cover"><img src="uploads/<?= e($b['sampul']) ?>" alt="Sampul saat ini"><span>Sampul saat ini</span></div><?php endif; ?>
<label class="upload-area"><input type="file" name="sampul" accept=".jpg,.jpeg,.png,image/jpeg,image/png" onchange="document.getElementById('file-name').textContent=this.files[0]?.name || 'Pilih gambar sampul'"><i class="bi bi-cloud-arrow-up"></i><b id="file-name">Pilih gambar sampul baru</b><small>JPG/PNG, maksimal 2 MB. Kosongkan jika tidak ingin mengganti.</small></label>
<div class="d-flex justify-content-end gap-2 mt-4"><a href="dashboard.php" class="btn btn-outline-secondary rounded-3 px-4">Batal</a><button class="btn btn-dark rounded-3 px-4">Simpan perubahan <i class="bi bi-check2 ms-2"></i></button></div>
</form>
<?php footer_html(); ?>
