<?php
require_once 'config/koneksi.php';

// Validasi ID
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan!");
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if ($id === false) {
    die("ID tidak valid!");
}

// Ambil data lama
$stmt = $conn->prepare("SELECT * FROM tb_absensi WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan!");
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa = trim($_POST['nama_siswa']);
    $kelas      = trim($_POST['kelas']);
    $tanggal    = $_POST['tanggal'];
    $status     = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tb_absensi 
        SET nama_siswa=?, kelas=?, tanggal=?, status=? 
        WHERE id=?");

    $stmt->bind_param("ssssi", $nama_siswa, $kelas, $tanggal, $status, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Absensi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body {
    background: linear-gradient(135deg, #3a96f2, #ffffff);
    min-height: 100vh;
}

.card {
    border: none;
    border-radius: 20px;
    padding: 20px;
}

.form-control, .form-select {
    border-radius: 10px;
}

.btn {
    border-radius: 10px;
}

.title-icon {
    font-size: 40px;
    color: #4e54c8;
}
</style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    
    <div class="card shadow-lg" style="width: 420px;">

        <div class="text-center mb-3">
            <i class="bi bi-pencil-square title-icon"></i>
            <h4 class="mt-2 fw-bold">Edit Absensi</h4>
            <small class="text-muted">Perbarui data kehadiran siswa</small>
        </div>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="nama_siswa" class="form-control"
                        value="<?= htmlspecialchars($data['nama_siswa']); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                    <input type="text" name="kelas" class="form-control"
                        value="<?= htmlspecialchars($data['kelas']); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                    <input type="date" name="tanggal" class="form-control"
                        value="<?= $data['tanggal']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-check2-square"></i></span>
                    <select name="status" class="form-select">
                        <option value="Hadir" <?= $data['status']=='Hadir'?'selected':''; ?>>Hadir</option>
                        <option value="Izin" <?= $data['status']=='Izin'?'selected':''; ?>>Izin</option>
                        <option value="Sakit" <?= $data['status']=='Sakit'?'selected':''; ?>>Sakit</option>
                        <option value="Alpa" <?= $data['status']=='Alpa'?'selected':''; ?>>Alpa</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-warning w-100">
                <i class="bi bi-save"></i> Update
            </button>

            <a href="index.php" class="btn btn-light w-100 mt-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

        </form>
    </div>

</div>

</body>
</html>