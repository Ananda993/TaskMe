<?php
// login.php

// Pastikan koneksi database sudah dimuat
if (!isset($conn)) {
    require_once 'database.php';
}

// Proses Login Pengguna
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email dan kata sandi harus diisi untuk login.";
    } else {
        // Ambil pengguna dari database
        $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verifikasi kata sandi
            if (password_verify($password, $user['password'])) {
                // Login berhasil, simpan ID pengguna di sesi
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['message'] = "Selamat datang kembali, " . htmlspecialchars($user['name']) . "!";
                header("Location: index.php?page=dashboard"); // Redirect ke halaman dashboard
                exit();
            } else {
                $_SESSION['error'] = "Email atau kata sandi salah.";
            }
        } else {
            $_SESSION['error'] = "Email atau kata sandi salah.";
        }
        $stmt->close();
    }
    header("Location: index.php?page=login"); // Redirect kembali ke login untuk menampilkan error
    exit();
}
?>

<section id="login-section">
    <h2>Login ke TaskMe</h2>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="login_email">Email:</label>
            <input type="email" id="login_email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="login_password">Kata Sandi:</label>
            <input type="password" id="login_password" name="password" class="form-control" required>
        </div>
        <div class="form-actions">
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </div>
    </form>
    <p style="text-align: center; margin-top: 1.5rem;">Belum punya akun? <a href="index.php?page=register" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Daftar di sini</a></p>
</section>