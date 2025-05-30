<?php
// index.php - File Router Utama

require_once 'database.php'; // Muat koneksi database & mulai sesi

// Tentukan halaman yang akan ditampilkan
$page = $_GET['page'] ?? 'login'; // Default ke 'login' jika tidak ada parameter 'page'

// Cek apakah pengguna sudah login
$is_logged_in = isset($_SESSION['user_id']);

// Redirect pengguna yang sudah login dari halaman login/register ke dashboard
if ($is_logged_in && ($page === 'login' || $page === 'register')) {
    header('Location: index.php?page=dashboard');
    exit();
}

// Redirect pengguna yang belum login dari halaman yang memerlukan login
if (!$is_logged_in && ($page === 'dashboard' || $page === 'profile')) {
    $_SESSION['error'] = 'Anda harus login untuk mengakses halaman ini.';
    header('Location: index.php?page=login');
    exit();
}

// Sertakan header (HTML awal, navigasi)
require_once 'header.php';

// Tampilkan pesan jika ada
if (!empty($_SESSION['message'])) {
    echo '<div class="message">' . htmlspecialchars($_SESSION['message']) . '</div>';
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
}
if (!empty($_SESSION['error'])) {
    echo '<div class="error">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']); // Hapus error setelah ditampilkan
}
?>

<main class="container">
    <?php
    // Sertakan konten halaman yang diminta
    switch ($page) {
        case 'login':
            require_once 'login.php';
            break;
        case 'register':
            require_once 'register.php';
            break;
        case 'dashboard':
            require_once 'dashboard.php';
            break;
        case 'profile':
            require_once 'profile.php';
            break;
        default:
            // Halaman 404 sederhana
            echo '<h2 style="text-align:center; color: var(--error-color);">Halaman Tidak Ditemukan (404)</h2><p style="text-align:center;">Halaman yang Anda cari tidak ada.</p>';
            break;
    }
    ?>
</main>

<?php
// Sertakan footer (HTML akhir)
require_once 'footer.php';
?>