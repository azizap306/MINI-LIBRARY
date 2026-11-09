<?php
require_once __DIR__ . '/config/auth.php'; wajib_admin(); cek_csrf();
try {
    $judul=trim($_POST['judul']??''); $kategori=trim($_POST['kategori']??'');
    $penulis=trim($_POST['penulis']??''); $tahun=filter_var($_POST['tahun']??null,FILTER_VALIDATE_INT);
    $stok=filter_var($_POST['stok']??null,FILTER_VALIDATE_INT);
    if (!$judul || !$kategori || !$penulis || !$tahun || $tahun<1000 || $tahun>(int)date('Y') || $stok===false || $stok<0) throw new RuntimeException('Periksa kembali data buku.');
    $sampul=simpan_sampul($_FILES['sampul']??[]);
    $stmt=$pdo->prepare('INSERT INTO buku (judul,kategori,penulis,tahun,stok,sampul) VALUES (?,?,?,?,?,?)');
    $stmt->execute([$judul,$kategori,$penulis,$tahun,$stok,$sampul]);
    flash('success','Buku berhasil ditambahkan.');
} catch (Throwable $e) { flash('danger',$e->getMessage()); }
header('Location: dashboard.php'); exit;
