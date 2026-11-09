-- Jalankan satu kali pada database db_perpustakaan versi lama.
USE db_perpustakaan;

ALTER TABLE users
    ADD COLUMN role ENUM('admin','user') NOT NULL DEFAULT 'user';

-- Set akun demo admin dan password default yang valid: admin / password
UPDATE users
SET role='admin',
    password='$2y$12$H7ZodBIw3Ap/JwvJ7jOkv.AIxBHK/DLmS2tJoMhlQzVZPX3iVVjpS',
    remember_token=NULL
WHERE username='admin';
