<?php
// profile.php

// Pastikan koneksi database sudah dimuat dan pengguna sudah login
if (!isset($conn) || !isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'Anda harus login untuk mengakses halaman ini.';
    header('Location: index.php?page=login');
    exit();
}

$current_user_id = $_SESSION['user_id'];
$current_user_name = $_SESSION['user_name'];
$current_user_email = $_SESSION['user_email'];

// Proses Update Profil
if (isset($_POST['update_profile'])) {
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password']; // Opsional

    // Validasi input
    if (empty($new_name) || empty($new_email)) {
        $_SESSION['error'] = "Nama dan email tidak boleh kosong.";
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email baru tidak valid.";
    } else {
        // Periksa apakah email baru sudah digunakan oleh pengguna lain
        $stmt_check_email = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt_check_email->bind_param("si", $new_email, $current_user_id);
        $stmt_check_email->execute();
        $stmt_check_email->store_result();

        if ($stmt_check_email->num_rows > 0) {
            $_SESSION['error'] = "Email baru sudah digunakan oleh pengguna lain.";
        } else {
            $update_sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
            $params = [$new_name, $new_email, $current_user_id];
            $types = "ssi";

            if (!empty($new_password)) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
                $params = [$new_name, $new_email, $hashed_new_password, $current_user_id];
                $types = "sssi";
            }

            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                $_SESSION['user_name'] = $new_name;
                $_SESSION['user_email'] = $new_email;
                $_SESSION['message'] = "Profil berhasil diperbarui!";
            } else {
                $_SESSION['error'] = "Gagal memperbarui profil: " . $stmt->error;
            }
            $stmt->close();
        }
        $stmt_check_email->close();
    }
    header("Location: index.php?page=profile"); // Redirect kembali ke profil untuk menampilkan pesan
    exit();
}
?>

<section id="profile-section" class="profile-section">
    <h2>Edit Profil Anda</h2>
    <form action="profile.php" method="post">
        <div class="form-group">
            <label for="new_name">Nama:</label>
            <input type="text" id="new_name" name="new_name" class="form-control" value="<?php echo htmlspecialchars($current_user_name); ?>" required>
        </div>
        <div class="form-group">
            <label for="new_email">Email:</label>
            <input type="email" id="new_email" name="new_email" class="form-control" value="<?php echo htmlspecialchars($current_user_email); ?>" required>
        </div>
        <div class="form-group">
            <label for="new_password">Kata Sandi Baru (kosongkan jika tidak ingin mengubah):</label>
            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Isi untuk mengubah kata sandi">
        </div>
        <div class="form-actions">
            <button type="submit" name="update_profile" class="btn btn-primary">Perbarui Profil</button>
        </div>
    </form>
</section>