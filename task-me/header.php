<?php
// header.php

// Pastikan database.php sudah dimuat untuk $conn dan session
if (!isset($conn)) {
    require_once 'database.php';
}

$is_logged_in = isset($_SESSION['user_id']);
$current_user_name = $is_logged_in ? htmlspecialchars($_SESSION['user_name']) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskMe - Pengelola Tugas Anda</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>TaskMe</h1>
        <p>Pengelola Tugas Pribadi Anda</p>
        <nav>
            <?php if ($is_logged_in): ?>
                <a href="index.php?page=dashboard">Dashboard</a>
                <a href="index.php?page=profile">Profil</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="index.php?page=login">Login</a>
                <a href="index.php?page=register">Register</a>
            <?php endif; ?>
        </nav>
    </header>