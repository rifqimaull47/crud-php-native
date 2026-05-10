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

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
    min-height: 100vh;
    overflow: hidden;
}

.delete-card {
    width: 430px;
    border: none;
    border-radius: 25px;
    padding: 35px;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    animation: fadeIn 0.5s ease;
}

.warning-icon {
    font-size: 70px;
    color: #dc3545;
    animation: shake 1.5s infinite;
}

.title {
    font-weight: 700;
    color: #dc3545;
}

.desc {
    color: #6c757d;
    font-size: 15px;
}

.btn {
    border-radius: 12px;
    padding: 10px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-danger {
    background: linear-gradient(90deg, #ff416c, #ff4b2b);
    border: none;
}

.btn-danger:hover {
    transform: translateY(-2px);
}

.btn-light:hover {
    background: #ececec;
}

@keyframes shake {
    0% { transform: rotate(0deg); }
    25% { transform: rotate(5deg); }
    50% { transform: rotate(0deg); }
    75% { transform: rotate(-5deg); }
    100% { transform: rotate(0deg); }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>

</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">

    <div class="delete-card text-center">

        <div class="mb-4">

            <i class="bi bi-trash3-fill warning-icon"></i>

        </div>

        <h2 class="title mb-3">
            Hapus Data?
        </h2>

        <p class="desc mb-4">
            Data yang sudah dihapus tidak dapat dikembalikan lagi.
        </p>

        <form method="POST">

            <button type="submit" class="btn btn-danger w-100">

                <i class="bi bi-trash-fill"></i>
                Ya, Hapus Sekarang

            </button>

            <a href="index.php" class="btn btn-light w-100 mt-2">

                <i class="bi bi-arrow-left"></i>
                Batal

            </a>

        </form>

    </div>

</div>

</body>
</html>