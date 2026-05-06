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

// Kalau user konfirmasi hapus
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $stmt = $conn->prepare("DELETE FROM tb_absensi WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal hapus: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hapus Data</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body {
    background: linear-gradient(135deg, #9c0003, #000000);
    min-height: 100vh;
}

.card {
    border: none;
    border-radius: 20px;
    padding: 25px;
}

.warning-icon {
    font-size: 50px;
    color: #dc3545;
}
</style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    
    <div class="card shadow-lg text-center" style="width: 420px;">

        <div class="mb-3">
            <i class="bi bi-exclamation-triangle-fill warning-icon"></i>
        </div>

        <h4 class="text-danger fw-bold">Yakin mau hapus data?</h4>
        <p class="text-muted">Data yang dihapus tidak bisa dikembalikan.</p>

        <form method="POST">
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-trash"></i> Ya, Hapus
            </button>

            <a href="index.php" class="btn btn-light w-100 mt-2">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </form>

    </div>

</div>

</body>
</html>