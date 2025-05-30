<?php
// logout.php

session_start(); // Pastikan sesi dimulai untuk menghancurkannya

// Hapus semua variabel sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
$_SESSION['message'] = 'Anda telah berhasil logout.';
header("Location: index.php?page=login");
exit();
?>