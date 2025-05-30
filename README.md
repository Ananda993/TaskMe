# TaskMe
TaskMe: Pengelola Tugas Pribadi Sederhana TaskMe adalah aplikasi web pengelola tugas pribadi yang dibangun dengan fokus pada kesederhanaan dan kemudahan penggunaan. Proyek ini dibuat sebagai studi kasus untuk mengembangkan aplikasi web dari awal tanpa menggunakan framework PHP, mengandalkan PHP natif, MySQL, HTML, CSS, dan JavaScript.

TaskMe: Pengelola Tugas Pribadi
TaskMe adalah aplikasi web sederhana untuk membantu Anda mengelola daftar tugas pribadi. Aplikasi ini memungkinkan pengguna untuk mendaftar, login, menambahkan tugas, menandai tugas sebagai selesai, menghapus tugas, serta mengelola informasi profil mereka.

Fitur
Autentikasi Pengguna:

Registrasi: Buat akun baru dengan nama, email, dan kata sandi.

Login: Masuk ke akun Anda yang sudah terdaftar.

Logout: Keluar dari sesi Anda.

Manajemen Profil:

Edit Profil: Perbarui nama, email, dan kata sandi Anda.

Manajemen Tugas (To-Do List):

Tambah Tugas: Tambahkan tugas baru ke daftar Anda.

Tandai Selesai: Tandai tugas sebagai selesai.

Hapus Tugas: Hapus tugas dari daftar Anda.

Antarmuka Modern: Desain UI/UX yang bersih dan responsif.

Teknologi yang Digunakan
Proyek ini dibangun menggunakan teknologi web dasar tanpa framework PHP atau JavaScript yang kompleks, menjadikannya ringan dan mudah dipahami.

Backend:

PHP: Logika sisi server untuk autentikasi, manajemen data, dan interaksi database.

MySQL: Sistem manajemen database relasional untuk menyimpan data pengguna dan tugas.

Frontend:

HTML5: Struktur dasar halaman web.

CSS3: Styling modern dan responsif.

JavaScript (Vanilla JS): Interaksi UI dasar (digunakan untuk konfirmasi hapus tugas).

Database Tool:

Laragon: Lingkungan pengembangan lokal yang mencakup Apache, MySQL, PHP, dan phpMyAdmin.

Persyaratan Sistem
Web server (misalnya Apache, Nginx) dengan dukungan PHP.

PHP 7.4 atau lebih tinggi.

MySQL 5.7 atau lebih tinggi.

Direkomendasikan menggunakan Laragon untuk lingkungan pengembangan lokal yang mudah.

Panduan Instalasi dan Pengaturan
Ikuti langkah-langkah di bawah ini untuk mengatur dan menjalankan proyek TaskMe di lingkungan lokal Anda.

1. Kloning Repositori (Jika dari GitHub)
Jika Anda mengunduh proyek ini dari GitHub, kloning repositori ke direktori www Laragon Anda (atau direktori root web server Anda):

git clone https://github.com/your-username/TaskMe.git C:\laragon\www\TaskMe

Jika Anda mengunduh secara manual, ekstrak file-file proyek ke direktori TaskMe di dalam C:\laragon\www\ (atau lokasi serupa).

2. Konfigurasi Database
Mulai Laragon: Pastikan Apache dan MySQL berjalan di Laragon Anda.

Akses phpMyAdmin: Buka browser Anda dan navigasikan ke http://localhost/phpmyadmin (atau klik kanan ikon Laragon di taskbar > Menu > Database > phpMyAdmin).

Buat Database: Buat database baru bernama taskme_db.

Jalankan Skrip SQL: Di phpMyAdmin, pilih database taskme_db yang baru Anda buat, lalu buka tab SQL. Salin dan tempel skrip SQL berikut, lalu jalankan:

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS taskme_db;

-- Gunakan database
USE taskme_db;

-- Tabel untuk pengguna
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk tugas
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    task_name VARCHAR(255) NOT NULL,
    is_completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

3. Konfigurasi Aplikasi
Buka file database.php di root folder proyek Anda.

Pastikan detail koneksi database sesuai dengan pengaturan MySQL di Laragon Anda:

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Biasanya kosong untuk Laragon default
define('DB_NAME', 'taskme_db');

Jika Anda memiliki username atau password MySQL yang berbeda, ubah DB_USER dan DB_PASS sesuai.

4. Jalankan Aplikasi
Buka browser Anda.

Navigasikan ke URL proyek Anda: http://localhost/TaskMe/ (ganti TaskMe jika nama folder proyek Anda berbeda).

Anda akan diarahkan ke halaman login. Anda bisa mendaftar akun baru atau login jika sudah memiliki akun.

Struktur Folder Proyek
TaskMe/
├── index.php         (File utama, router untuk memuat halaman)
├── database.php      (Konfigurasi koneksi database & mulai sesi)
├── header.php        (Bagian atas HTML, termasuk <head> dan navigasi)
├── footer.php        (Bagian bawah HTML, termasuk penutup <body> dan <footer>)
├── login.php         (Form login dan logika autentikasi login)
├── register.php      (Form registrasi dan logika registrasi)
├── dashboard.php     (Tampilan dashboard, form tambah tugas, daftar tugas, dan logika manajemen tugas)
├── profile.php       (Form edit profil dan logika update profil)
├── logout.php        (Logika untuk proses logout)
└── style.css         (File CSS untuk seluruh styling UI/UX)

Kontribusi
Kontribusi dalam bentuk perbaikan bug, penambahan fitur, atau peningkatan kode sangat diterima. Silakan fork repositori ini dan kirim pull request.

Lisensi
Proyek ini dilisensikan di bawah Lisensi MIT. Lihat file LICENSE untuk detail lebih lanjut. (Anda bisa menambahkan file LICENSE secara terpisah di repositori GitHub Anda).

Developer
Proyek ini dikembangkan oleh:

mitsuha.dev
