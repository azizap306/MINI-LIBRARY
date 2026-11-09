<?php
require_once __DIR__ . '/config/auth.php'; wajib_admin(); require_once __DIR__ . '/config/layout.php';
header_html('Tambah Buku');
?>
<div class="form-heading"><a href="dashboard.php" class="back-link"><i class="bi bi-arrow-left"></i> Kembali ke dashboard</a><h2>Tambah koleksi baru</h2><p>Lengkapi informasi buku yang ingin dimasukkan ke perpustakaan.</p></div>
<?php tampil_flash(); ?>
<form action="proses_tambah.php" method="POST" enctype="multipart/form-data" class="content-card form-card">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<div class="section-title"><span>01</span><div><b>Informasi buku</b><small>Masukkan detail dasar koleksi.</small></div></div>
<div class="row g-3"><div class="col-md-8"><label class="form-label">Judul buku *</label><input class="form-control" name="judul" required maxlength="180" placeholder="Contoh: Filosofi Teras"></div>
<div class="col-md-4"><label class="form-label">Kategori *</label><input class="form-control" name="kategori" required maxlength="80" placeholder="Pengembangan diri"></div>
<div class="col-md-6"><label class="form-label">Penulis *</label><input class="form-control" name="penulis" required maxlength="120" placeholder="Nama penulis"></div>
<div class="col-md-3"><label class="form-label">Tahun terbit *</label><input class="form-control" type="number" name="tahun" min="1000" max="<?= date('Y') ?>" required placeholder="<?= date('Y') ?>"></div>
<div class="col-md-3"><label class="form-label">Stok *</label><input class="form-control" type="number" name="stok" min="0" value="1" required></div></div>
<hr class="soft-divider">
<div class="section-title"><span>02</span><div><b>Sampul buku</b><small>Gunakan gambar JPG atau PNG, maksimal 2 MB.</small></div></div>
<label class="upload-area"><input type="file" name="sampul" accept=".jpg,.jpeg,.png,image/jpeg,image/png" onchange="document.getElementById('file-name').textContent=this.files[0]?.name || 'Pilih gambar sampul'"><i class="bi bi-cloud-arrow-up"></i><b id="file-name">Pilih gambar sampul</b><small>Seret file ke sini atau klik untuk memilih</small></label>
<div class="d-flex justify-content-end gap-2 mt-4"><a href="dashboard.php" class="btn btn-outline-secondary rounded-3 px-4">Batal</a><button class="btn btn-dark rounded-3 px-4">Simpan buku <i class="bi bi-check2 ms-2"></i></button></div>
</form>
<?php footer_html(); ?>
