<?php
require_once __DIR__ . '/config/auth.php'; wajib_admin(); cek_csrf();
$id=filter_var($_POST['id']??null,FILTER_VALIDATE_INT);
$stmt=$pdo->prepare('SELECT sampul FROM buku WHERE id=?'); $stmt->execute([$id]); $b=$stmt->fetch();
if ($b) {
    $pdo->prepare('DELETE FROM buku WHERE id=?')->execute([$id]);
    if ($b['sampul']) {
        $path=__DIR__.'/uploads/'.basename($b['sampul']);
        if (is_file($path)) unlink($path);
    }
    flash('success','Buku dan file sampul berhasil dihapus.');
} else flash('warning','Data buku tidak ditemukan.');
header('Location: dashboard.php'); exit;
