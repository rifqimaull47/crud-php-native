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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
        }
        .card {
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-4">Edit Absensi</h3>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control"
                    value="<?= htmlspecialchars($data['nama_siswa']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control"
                    value="<?= htmlspecialchars($data['kelas']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control"
                    value="<?= $data['tanggal']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Hadir" <?= $data['status']=='Hadir'?'selected':''; ?>>Hadir</option>
                    <option value="Izin" <?= $data['status']=='Izin'?'selected':''; ?>>Izin</option>
                    <option value="Sakit" <?= $data['status']=='Sakit'?'selected':''; ?>>Sakit</option>
                    <option value="Alpa" <?= $data['status']=='Alpa'?'selected':''; ?>>Alpa</option>
                </select>
            </div>

            <button type="submit" class="btn btn-warning w-100">Update</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
        </form>
    </div>
</div>

</body>
</html>