<?php
// dashboard.php

// Pastikan koneksi database sudah dimuat dan pengguna sudah login
if (!isset($conn) || !isset($_SESSION['user_id'])) {
    // Jika tidak diakses melalui index.php dengan sesi aktif, redirect
    $_SESSION['error'] = 'Anda harus login untuk mengakses halaman ini.';
    header('Location: index.php?page=login');
    exit();
}

$current_user_id = $_SESSION['user_id'];
$current_user_name = $_SESSION['user_name'];

// =====================================================================================================
// LOGIKA MANAJEMEN TUGAS (dalam dashboard.php)
// =====================================================================================================

// Proses Tambah Tugas
if (isset($_POST['add_task'])) {
    $task_name = $_POST['task_name'];
    if (!empty($task_name)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name) VALUES (?, ?)");
        $stmt->bind_param("is", $current_user_id, $task_name);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Tugas berhasil ditambahkan.";
        } else {
            $_SESSION['error'] = "Gagal menambahkan tugas: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Nama tugas tidak boleh kosong.";
    }
    header("Location: index.php?page=dashboard"); // Redirect untuk membersihkan POST data
    exit();
}

// Proses Selesaikan Tugas
if (isset($_GET['complete_task'])) {
    $task_id = $_GET['complete_task'];
    $stmt = $conn->prepare("UPDATE tasks SET is_completed = TRUE WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $current_user_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Tugas berhasil diselesaikan!";
    } else {
        $_SESSION['error'] = "Gagal menyelesaikan tugas: " . $stmt->error;
    }
    $stmt->close();
    header("Location: index.php?page=dashboard"); // Redirect untuk membersihkan URL
    exit();
}

// Proses Hapus Tugas
if (isset($_GET['delete_task'])) {
    $task_id = $_GET['delete_task'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $current_user_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Tugas berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus tugas: " . $stmt->error;
    }
    $stmt->close();
    header("Location: index.php?page=dashboard"); // Redirect untuk membersihkan URL
    exit();
}

// Ambil daftar tugas pengguna
$tasks = [];
$stmt = $conn->prepare("SELECT id, task_name, is_completed FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}
$stmt->close();
?>

<section id="dashboard-section">
    <h2>Selamat Datang, <?php echo htmlspecialchars($current_user_name); ?>!</h2>
    <div class="add-task-form">
        <form action="dashboard.php" method="post">
            <div class="form-group">
                <label for="task_name">Tambahkan Tugas Baru:</label>
                <input type="text" id="task_name" name="task_name" class="form-control" placeholder="Contoh: Belajar PHP & SQL" required>
            </div>
            <div class="form-actions">
                <button type="submit" name="add_task" class="btn btn-primary">Tambah Tugas</button>
            </div>
        </form>
    </div>

    <?php if (empty($tasks)): ?>
        <p style="text-align: center; margin-top: 2rem; color: var(--dark-gray);">Anda belum memiliki tugas. Tambahkan tugas pertama Anda!</p>
    <?php else: ?>
        <ul class="task-list">
            <?php foreach ($tasks as $task): ?>
                <li class="task-item <?php echo $task['is_completed'] ? 'completed' : ''; ?>">
                    <div class="task-item-content">
                        <span class="task-name"><?php echo htmlspecialchars($task['task_name']); ?></span>
                    </div>
                    <div class="task-actions">
                        <?php if (!$task['is_completed']): ?>
                            <a href="dashboard.php?complete_task=<?php echo $task['id']; ?>" class="btn btn-success" title="Tandai Selesai">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php endif; ?>
                        <a href="dashboard.php?delete_task=<?php echo $task['id']; ?>" class="btn btn-danger" title="Hapus Tugas" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>