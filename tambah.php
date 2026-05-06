<?php
require_once 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_siswa = trim($_POST['nama_siswa']);
    $kelas      = trim($_POST['kelas']);
    $tanggal    = $_POST['tanggal'];
    $status     = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO tb_absensi (nama_siswa, kelas, tanggal, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama_siswa, $kelas, $tanggal, $status);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Absensi</title>

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
            <i class="bi bi-clipboard-check-fill title-icon"></i>
            <h4 class="mt-2 fw-bold">Tambah Absensi</h4>
            <small class="text-muted">Input data kehadiran siswa</small>
        </div>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="nama_siswa" class="form-control" placeholder="Masukkan nama..." required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                    <input type="text" name="kelas" class="form-control" placeholder="Contoh: XI PPLG 1" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-check2-square"></i></span>
                    <select name="status" class="form-select">
                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Alpa">Alpa</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-save"></i> Simpan
            </button>

            <a href="index.php" class="btn btn-light w-100 mt-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

        </form>
    </div>

</div>

</body>
</html>