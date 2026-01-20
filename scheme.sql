-- Membuat Database
CREATE DATABASE perpustakaan_sekolah;
USE perpustakaan_sekolah;

-- 1. Tabel Admin
-- Referensi: [cite: 73]
CREATE TABLE admin (
    id_admin INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_admin VARCHAR(100),
    PRIMARY KEY (id_admin)
);

-- 2. Tabel Anggota (Siswa)
-- Referensi: 
CREATE TABLE anggota (
    id_anggota INT(11) NOT NULL AUTO_INCREMENT,
    nis VARCHAR(20) NOT NULL UNIQUE,
    nama_anggota VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_anggota)
);

-- 3. Tabel Buku
-- Referensi: 
CREATE TABLE buku (
    id_buku INT(11) NOT NULL AUTO_INCREMENT,
    kode_buku VARCHAR(20) NOT NULL UNIQUE,
    judul_buku VARCHAR(255) NOT NULL,
    pengarang VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    stok INT(11) DEFAULT 1, -- Stok buku
    PRIMARY KEY (id_buku)
);

-- 4. Tabel Transaksi (Peminjaman & Pengembalian)
-- Referensi: 
CREATE TABLE transaksi (
    id_transaksi INT(11) NOT NULL AUTO_INCREMENT,
    id_anggota INT(11) NOT NULL,
    id_buku INT(11) NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE, -- Bisa NULL jika belum dikembalikan
    status ENUM('pinjam', 'kembali') DEFAULT 'pinjam',
    PRIMARY KEY (id_transaksi),
    -- Relasi Foreign Key
    FOREIGN KEY (id_anggota) REFERENCES anggota(id_anggota) ON DELETE CASCADE,
    FOREIGN KEY (id_buku) REFERENCES buku(id_buku) ON DELETE CASCADE
);