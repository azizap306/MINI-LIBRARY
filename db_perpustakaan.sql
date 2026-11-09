CREATE DATABASE IF NOT EXISTS db_perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_perpustakaan;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    remember_token CHAR(64) NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(180) NOT NULL,
    kategori VARCHAR(80) NOT NULL,
    penulis VARCHAR(120) NOT NULL,
    tahun SMALLINT UNSIGNED NOT NULL,
    stok INT UNSIGNED NOT NULL DEFAULT 0,
    sampul VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun demo admin: admin / password
INSERT INTO users (username, password, role)
VALUES ('admin', '$2y$12$puarVJxfzFoN0XJWmvRXQuU/Ejp3V/QZsWUuiSK3dn5bLHrQyPT5e', 'admin')
ON DUPLICATE KEY UPDATE password = VALUES(password), role = 'admin';

INSERT INTO buku (judul,kategori,penulis,tahun,stok,sampul)
SELECT 'Filosofi Teras','Pengembangan Diri','Henry Manampiring',2018,4,NULL
WHERE NOT EXISTS (SELECT 1 FROM buku WHERE judul='Filosofi Teras');

INSERT INTO buku (judul,kategori,penulis,tahun,stok,sampul)
SELECT 'Laut Bercerita','Novel','Leila S. Chudori',2017,0,NULL
WHERE NOT EXISTS (SELECT 1 FROM buku WHERE judul='Laut Bercerita');

INSERT INTO buku (judul,kategori,penulis,tahun,stok,sampul)
SELECT 'Atomic Habits','Produktivitas','James Clear',2018,3,NULL
WHERE NOT EXISTS (SELECT 1 FROM buku WHERE judul='Atomic Habits');
