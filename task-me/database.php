<?php
// database.php

// Konfigurasi Database
define('DB_HOST', 'localhost'); // Biasanya 'localhost' untuk Laragon
define('DB_USER', 'root');      // Nama pengguna default Laragon
define('DB_PASS', '');          // Kata sandi default Laragon (kosong)
define('DB_NAME', 'taskme_db'); // Nama database yang kita buat

// Buat koneksi ke database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Mulai sesi PHP (penting untuk manajemen sesi)
session_start();

// Inisialisasi variabel pesan
// Ini akan menyimpan pesan sukses atau error untuk ditampilkan sekali
$_SESSION['message'] = $_SESSION['message'] ?? '';
$_SESSION['error'] = $_SESSION['error'] ?? '';
?>