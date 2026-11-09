<?php
if (session_status() === PHP_SESSION_NONE) {
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0, 'path' => '/', 'secure' => $secure,
        'httponly' => true, 'samesite' => 'Lax'
    ]);
    session_start();
}
require_once __DIR__ . '/koneksi.php';

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function wajib_login(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
}
function flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
function tampil_flash(): void {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        echo '<div class="alert alert-' . e($f['type']) . ' alert-dismissible fade show" role="alert">'
            . e($f['message']) . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
        unset($_SESSION['flash']);
    }
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function cek_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
        !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403);
        exit('Permintaan tidak valid. Silakan kembali dan coba lagi.');
    }
}
function status_buku(int $stok): array {
    if ($stok > 0) return ['Tersedia', 'success'];
    return ['Dipinjam', 'warning'];
}
function simpan_sampul(array $file, ?string $lama = null): ?string {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return $lama;
    if ($file['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Upload sampul gagal.');
    if ($file['size'] > 2 * 1024 * 1024) throw new RuntimeException('Ukuran sampul maksimal 2 MB.');

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    if (!isset($allowed[$mime])) throw new RuntimeException('Format sampul harus JPG atau PNG.');

    $folder = dirname(__DIR__) . '/uploads';
    if (!is_dir($folder)) mkdir($folder, 0755, true);
    $nama = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], $folder . '/' . $nama)) {
        throw new RuntimeException('Tidak dapat menyimpan file sampul.');
    }
    if ($lama && is_file($folder . '/' . basename($lama))) {
        unlink($folder . '/' . basename($lama));
    }
    return $nama;
}

function wajib_admin(): void {
    wajib_login();
    if (($_SESSION['role'] ?? 'user') !== 'admin') {
        header('Location: katalog.php');
        exit;
    }
}
