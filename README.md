# MINI-LIBRARY

# Luma Library — Mini Digital Library

Aplikasi perpustakaan mini menggunakan PHP Native, PDO MySQL, Bootstrap 5, dan CSS responsif.

## Fitur
- Login admin dan pengguna publik.
- Registrasi mandiri; akun yang didaftarkan otomatis ber-role `user`.
- Admin dapat menambah, melihat, mengedit, dan menghapus koleksi buku.
- Pengguna publik hanya dapat melihat dan mencari katalog.
- Remember Me menggunakan token acak; database menyimpan hash token.
- Upload sampul JPG/PNG maksimal 2 MB.
- Prepared statement, password hashing, CSRF token, session regeneration, dan pembatasan akses berdasarkan role.

## Instalasi baru di XAMPP
1. Ekstrak folder `mini-digital-library` ke `C:\xampp\htdocs\`.
2. Jalankan Apache dan MySQL.
3. Import `db_perpustakaan.sql` melalui phpMyAdmin.
4. Periksa `config/koneksi.php` (default XAMPP: root tanpa password).
5. Buka `http://localhost/mini-digital-library/`.

## Jika database versi lama sudah ada
Jangan import ulang SQL utama jika ingin mempertahankan data. Pilih database `db_perpustakaan` di phpMyAdmin, buka tab SQL, lalu jalankan isi file `migrasi_role.sql` satu kali. File migrasi menambahkan kolom role dan menetapkan akun `admin` sebagai admin.

## Akun demo admin
- Username: `admin`
- Password: `Admin12345`

Setelah login, sebaiknya ganti password demo. Untuk penggunaan online, gunakan HTTPS valid, password database yang kuat, dan konfigurasi server yang aman.

## Akun publik
Pengunjung memilih **Buat akun publik** pada halaman login. Username 3–50 karakter (huruf, angka, underscore), password minimal 8 karakter. Akun baru tidak dapat memilih role admin dan hanya dapat mengakses katalog.

## Struktur utama
```text
mini-digital-library/
├── assets/css/style.css
├── config/auth.php
├── config/koneksi.php
├── config/layout.php
├── uploads/
├── db_perpustakaan.sql
├── migrasi_role.sql
├── index.php
├── proses_login.php
├── register.php
├── proses_register.php
├── katalog.php
├── logout.php
└── halaman CRUD buku lainnya
```