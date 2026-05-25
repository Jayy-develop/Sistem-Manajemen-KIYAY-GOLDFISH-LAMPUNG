<?php


// ================================
// KONEKSI DATABASE (SQLite3)
// ================================
session_start();
chdir(__DIR__);

// SQLite database file
$db_file = __DIR__ . '/ikankoki.sqlite';
$db = new SQLite3($db_file);
$db->busyTimeout(5000);
$db->exec("PRAGMA foreign_keys = ON;");


// ================================
// TABEL ADMIN
// ================================
query("
    CREATE TABLE IF NOT EXISTS admin (
        idAdmin INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        name TEXT NOT NULL,
        password TEXT NOT NULL,
        noHp TEXT
    )
");

// ================================
// TABEL JENIS IKAN
// ================================
query("
    CREATE TABLE IF NOT EXISTS jenisIkan (
        idJenisIkan INTEGER PRIMARY KEY AUTOINCREMENT,
        jenisIkan TEXT NOT NULL
    )
");

// ================================
// TABEL IKAN
// ================================
query("
    CREATE TABLE IF NOT EXISTS ikan (
        idIkan INTEGER PRIMARY KEY AUTOINCREMENT,
        idJenisIkan INTEGER NOT NULL,
        ukuran TEXT,
        gender TEXT,
        stokIkan INTEGER,
        harga INTEGER,
        deskripsi TEXT,
        gambarIkan TEXT,
        FOREIGN KEY(idJenisIkan) REFERENCES jenisIkan(idJenisIkan) ON UPDATE CASCADE ON DELETE CASCADE
    )
");

// ================================
// TABEL PENJUALAN
// ================================
query("
    CREATE TABLE IF NOT EXISTS penjualan (
        idPenjualan INTEGER PRIMARY KEY AUTOINCREMENT,
        tanggalPenjualan TEXT NOT NULL,
        totalHarga INTEGER,
        statusPenjualan TEXT,
        idAdmin INTEGER NOT NULL,
        FOREIGN KEY(idAdmin) REFERENCES admin(idAdmin) ON UPDATE CASCADE ON DELETE CASCADE
    )
");

// ================================
// TABEL SUB PENJUALAN
// ================================
query("
    CREATE TABLE IF NOT EXISTS subPenjualan (
        idSubPenjualan INTEGER PRIMARY KEY AUTOINCREMENT,
        idPenjualan INTEGER NOT NULL,
        idIkan INTEGER NOT NULL,
        jumlahPembelian INTEGER NOT NULL,
        FOREIGN KEY(idPenjualan) REFERENCES penjualan(idPenjualan) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY(idIkan) REFERENCES ikan(idIkan) ON UPDATE CASCADE ON DELETE CASCADE
    )
");

// // INSERT Admin
// $db->exec("
//     INSERT INTO Admin (username, name, password) VALUES
//     ('admin1', 'Nova Arundyna', 'admin123'),

// // INSERT Jenis Ikan
// $db->exec("
//     INSERT INTO JenisIkan (jenisIkan) VALUES
//     ('Oranda'), ('Ryukin'), ('Ranchu'),
//     ('Koki Mata Balon'), ('Koki Black Moor')
// ");

// // INSERT Ikan
// $db->exec("
//     INSERT INTO Ikan (idJenisIkan, ukuran, gender,stokIkan, harga, deskripsi, gambarIkan) VALUES
//     (1, '10 cm', 'Male', 5, 150000, 'Oranda merah sehat', 'oranda1.jpg'),
//     (1, '12 cm', 'Female', 7, 180000, 'Oranda premium', 'oranda2.jpg'),
//     (2, '9 cm', 'Male', 9, 120000, 'Ryukin bungkuk', 'ryukin1.jpg'),
//     (2, '11 cm', 'Female', 140000, 8, 'Ryukin merah putih', 'ryukin2.jpg'),
//     (3, '8 cm', 'Male', 12, 100000, 'Ranchu ekor pendek', 'ranchu1.jpg'),
//     (3, '10 cm', 'Female', 10, 130000, 'Ranchu impor', 'ranchu2.jpg'),
//     (4, '7 cm', 'Male', 12, 90000, 'Mata balon kuning', 'balon1.jpg'),
//     (4, '8 cm', 'Female', 13, 110000, 'Mata balon premium', 'balon2.jpg'),
//     (5, '9 cm', 'Male', 9, 125000, 'Black Moor hitam pekat', 'moore1.jpg'),
//     (5, '11 cm', 'Female', 8, 150000, 'Black Moor kontes', 'moore2.jpg')
// ");

// // INSERT Penjualan
// $db->exec("
//     INSERT INTO Penjualan (tanggalPenjualan, totalHarga, statusPenjualan, idAdmin) VALUES
//     ('2025-11-20', 300000, 'Selesai', 1),
//     ('2025-11-21', 450000, 'Diproses', 1),
//     ('2025-11-22', 250000, 'Selesai', 2)
// ");

// INSERT SubPenjualan
// $db->exec("
//     INSERT INTO SubPenjualan (idPenjualan, idIkan, jumlahPembelian) VALUES
//     (1, 13, 1),
//     (1, 15, 1),
//     (1, 16, 1),
//     (2, 18, 1),
//     (2, 17, 1),
//     (2, 19, 1),
//     (3, 21, 1),
//     (3, 22, 1)
// ");

function query($sql) {
    global $db;

    if (stripos(trim($sql), 'select') === 0) {
        $result = $db->query($sql);
        $rows = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }

        return $rows; 
    } else {
        return $db->exec($sql);
    }
}
// $hash = password_hash("admin", PASSWORD_DEFAULT);
// query("
//     INSERT INTO admin (username, name, password)
//     VALUES ('admin', 'Administrator', '$hash')
// ");

query("
    CREATE TABLE IF NOT EXISTS tabel_gambar (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama_file TEXT NOT NULL,
        uploaded_at TEXT DEFAULT CURRENT_TIMESTAMP
    )
");

function uploadGambar($file, $folder = '../assets/img/ikan/') {

    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['status' => false, 'msg' => 'Gambar tidak diupload.'];
    }

    // Error handling bawaan PHP
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['status' => false, 'msg' => 'Terjadi kesalahan saat upload.'];
    }

    // Maksimal 3MB
    $maxSize = 3 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        return ['status' => false, 'msg' => 'Ukuran gambar maksimal 3MB.'];
    }

    // Cek folder
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif'];

    if (!in_array($ext, $allowed)) {
        return ['status' => false, 'msg' => 'Format gambar tidak valid.'];
    }

    // Nama file unik
    $namaFile = uniqid('img_', true) . '.' . $ext;

    // Pindah file
    if (!move_uploaded_file($file['tmp_name'], $folder . $namaFile)) {
        return ['status' => false, 'msg' => 'Gagal menyimpan file.'];
    }

    return ['status' => true, 'file' => $namaFile];
}

query("
    CREATE TABLE IF NOT EXISTS rating (
        idRating INTEGER PRIMARY KEY AUTOINCREMENT,
        lokasi TEXT NOT NULL,
        namaOrang TEXT NOT NULL,
        foto TEXT,
        isiRating TEXT NOT NULL,
        tanggal TEXT DEFAULT CURRENT_TIMESTAMP
    )
");


