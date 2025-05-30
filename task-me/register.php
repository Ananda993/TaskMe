<?php
// register.php

// Pastikan koneksi database sudah dimuat
if (!isset($conn)) {
    require_once 'database.php';
}

// Proses Registrasi Pengguna
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Semua kolom harus diisi untuk registrasi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid.";
    } else {
        // Hash kata sandi sebelum menyimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Periksa apakah email sudah terdaftar
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $_SESSION['error'] = "Email ini sudah terdaftar. Silakan gunakan email lain atau login.";
        } else {
            // Masukkan pengguna baru ke database
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Registrasi berhasil! Silakan login.";
                header("Location: index.php?page=login"); // Redirect ke halaman login
                exit();
            } else {
                $_SESSION['error'] = "Registrasi gagal: " . $stmt->error;
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
    header("Location: index.php?page=register"); // Redirect kembali ke register untuk menampilkan error
    exit();
}
?>

<section id="register-section">
    <h2>Daftar Akun Baru</h2>
    <form action="register.php" method="post">
        <div class="form-group">
            <label for="register_name">Nama:</label>
            <input type="text" id="register_name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="register_email">Email:</label>
            <input type="email" id="register_email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="register_password">Kata Sandi:</label>
            <input type="password" id="register_password" name="password" class="form-control" required>
        </div>
        <div class="form-actions">
            <button type="submit" name="register" class="btn btn-primary">Daftar</button>
        </div>
    </form>
    <p style="text-align: center; margin-top: 1.5rem;">Sudah punya akun? <a href="index.php?page=login" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Login di sini</a></p>
</section>