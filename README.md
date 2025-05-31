Berikut adalah README.md yang sudah dirapikan dan diformat lebih baik agar mudah dibaca:

---

# TaskMe

**TaskMe: Pengelola Tugas Pribadi Sederhana**  
TaskMe adalah aplikasi web pengelola tugas pribadi yang dibangun dengan fokus pada kesederhanaan dan kemudahan penggunaan. Proyek ini dibuat sebagai studi kasus untuk mengembangkan aplikasi web dari awal tanpa framework PHP.

## Fitur

- **Autentikasi Pengguna**
  - Registrasi: Buat akun baru dengan nama, email, dan kata sandi
  - Login: Masuk ke akun yang sudah terdaftar
  - Logout: Keluar dari sesi Anda

- **Manajemen Profil**
  - Edit Profil: Perbarui nama, email, dan kata sandi

- **Manajemen Tugas (To-Do List)**
  - Tambah Tugas: Tambahkan tugas baru ke daftar Anda
  - Tandai Selesai: Tandai tugas sebagai selesai
  - Hapus Tugas: Hapus tugas dari daftar Anda

- **Antarmuka Modern**
  - Desain UI/UX yang bersih dan responsif

## Teknologi yang Digunakan

- **Backend**
  - PHP: Logika sisi server untuk autentikasi, manajemen data, dan interaksi database
  - MySQL: Sistem manajemen database relasional untuk menyimpan data pengguna dan tugas

- **Frontend**
  - HTML5: Struktur dasar halaman web
  - CSS3: Styling modern dan responsif
  - JavaScript (Vanilla JS): Interaksi UI dasar (misal: konfirmasi hapus tugas)

- **Database Tool**
  - Laragon: Lingkungan pengembangan lokal yang mencakup Apache, MySQL, PHP, dan phpMyAdmin

## Persyaratan Sistem

- Web server (misal: Apache, Nginx) dengan dukungan PHP
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Direkomendasikan menggunakan Laragon untuk kemudahan pengembangan lokal

## Panduan Instalasi dan Pengaturan

1. **Kloning Repositori**
   ```bash
   git clone https://github.com/your-username/TaskMe.git C:\laragon\www\TaskMe
   ```
   Atau, unduh manual dan ekstrak ke direktori `C:\laragon\www\TaskMe`.

2. **Konfigurasi Database**
   - Mulai Laragon (pastikan Apache dan MySQL berjalan)
   - Akses phpMyAdmin di [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Buat database baru: `taskme_db`
   - Jalankan skrip SQL berikut pada database `taskme_db`:
     ```sql
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
     ```

3. **Konfigurasi Aplikasi**
   - Buka file `database.php` di root folder proyek
   - Pastikan detail koneksi database sebagai berikut (atau sesuaikan):
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', ''); // Biasanya kosong untuk Laragon default
     define('DB_NAME', 'taskme_db');
     ```

4. **Jalankan Aplikasi**
   - Buka browser dan akses: [http://localhost/TaskMe/](http://localhost/TaskMe/)
   - Anda akan diarahkan ke halaman login. Silakan mendaftar atau login.

## Struktur Folder Proyek

```
TaskMe/
├── index.php         # File utama, router untuk memuat halaman
├── database.php      # Konfigurasi koneksi database & mulai sesi
├── header.php        # Bagian atas HTML, termasuk <head> dan navigasi
├── footer.php        # Bagian bawah HTML, termasuk penutup <body> dan <footer>
├── login.php         # Form login dan logika autentikasi login
├── register.php      # Form registrasi dan logika registrasi
├── dashboard.php     # Tampilan dashboard, form tambah tugas, daftar tugas, dan logika manajemen tugas
├── profile.php       # Form edit profil dan logika update profil
├── logout.php        # Logika untuk proses logout
└── style.css         # File CSS untuk seluruh styling UI/UX
```

## Kontribusi

Kontribusi berupa perbaikan bug, penambahan fitur, atau peningkatan kode sangat diterima. Silakan fork repositori ini dan kirim pull request.

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT. Lihat file LICENSE untuk detail lebih lanjut.

## Developer

Proyek ini dikembangkan oleh:  
**mitsuha.dev**