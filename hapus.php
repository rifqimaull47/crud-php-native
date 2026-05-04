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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #931010, #110a81);
            min-height: 100vh;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow p-4 text-center" style="width: 400px;">
        <h4 class="mb-3 text-danger">Yakin mau hapus data?</h4>
        <p>Data yang dihapus tidak bisa dikembalikan.</p>

        <form method="POST">
            <button type="submit" class="btn btn-danger w-100">Ya, Hapus</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>
        </form>
    </div>
</div>

</body>
</html>