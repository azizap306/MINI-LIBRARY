<?php
require_once __DIR__ . '/config/auth.php'; wajib_admin(); cek_csrf();
$id=filter_var($_POST['id']??null,FILTER_VALIDATE_INT);
$stmt=$pdo->prepare('SELECT * FROM buku WHERE id=?'); $stmt->execute([$id]); $lama=$stmt->fetch();
if (!$lama) { flash('danger','Data buku tidak ditemukan.'); header('Location: dashboard.php'); exit; }
try {
    $judul=trim($_POST['judul']??''); $kategori=trim($_POST['kategori']??''); $penulis=trim($_POST['penulis']??'');
    $tahun=filter_var($_POST['tahun']??null,FILTER_VALIDATE_INT); $stok=filter_var($_POST['stok']??null,FILTER_VALIDATE_INT);
    if (!$judul || !$kategori || !$penulis || !$tahun || $tahun<1000 || $tahun>(int)date('Y') || $stok===false || $stok<0) throw new RuntimeException('Periksa kembali data buku.');
    $sampul=simpan_sampul($_FILES['sampul']??[],$lama['sampul']);
    $up=$pdo->prepare('UPDATE buku SET judul=?,kategori=?,penulis=?,tahun=?,stok=?,sampul=? WHERE id=?');
    $up->execute([$judul,$kategori,$penulis,$tahun,$stok,$sampul,$id]);
    flash('success','Data buku berhasil diperbarui.');
} catch (Throwable $e) { flash('danger',$e->getMessage()); }
header('Location: dashboard.php'); exit;
