<?php
require_once 'config/koneksi.php';

// Query data A-Z
$query = "SELECT * FROM tb_absensi ORDER BY nama_siswa ASC";
$result = $conn->query($query);

// Statistik
$hadir = $conn->query("SELECT COUNT(*) as total FROM tb_absensi WHERE status='Hadir'")->fetch_assoc()['total'];
$izin  = $conn->query("SELECT COUNT(*) as total FROM tb_absensi WHERE status='Izin'")->fetch_assoc()['total'];
$sakit = $conn->query("SELECT COUNT(*) as total FROM tb_absensi WHERE status='Sakit'")->fetch_assoc()['total'];
$alpa  = $conn->query("SELECT COUNT(*) as total FROM tb_absensi WHERE status='Alpa'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Absensi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
body {
    background: linear-gradient(135deg, #3a96f2, #ffffff);
    min-height: 100vh;
}

.container-box {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.card {
    border: none;
    border-radius: 15px;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.table thead {
    background: #4e54c8;
    color: white;
}

h3 {
    font-weight: bold;
}
</style>

</head>
<body>

<div class="container py-5">
<div class="container-box">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>📊 Dashboard Absensi</h3>
    <a href="tambah.php" class="btn btn-success">+ Tambah</a>
</div>

<!-- STATISTIK -->
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            <div class="d-flex justify-content-between">
                <div>
                    <small>Hadir</small>
                    <h4 class="text-success"><?= $hadir ?></h4>
                </div>
                <i class="bi bi-check-circle-fill text-success fs-2"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            <div class="d-flex justify-content-between">
                <div>
                    <small>Izin</small>
                    <h4 class="text-warning"><?= $izin ?></h4>
                </div>
                <i class="bi bi-exclamation-circle-fill text-warning fs-2"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            <div class="d-flex justify-content-between">
                <div>
                    <small>Sakit</small>
                    <h4 class="text-info"><?= $sakit ?></h4>
                </div>
                <i class="bi bi-heart-pulse-fill text-info fs-2"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            <div class="d-flex justify-content-between">
                <div>
                    <small>Alpa</small>
                    <h4 class="text-danger"><?= $alpa ?></h4>
                </div>
                <i class="bi bi-x-circle-fill text-danger fs-2"></i>
            </div>
        </div>
    </div>

</div>

<!-- TABEL -->
<div class="table-responsive">
<table class="table table-hover text-center align-middle">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
    <?php $no=1; while($row=$result->fetch_assoc()){ ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
            <td><?= htmlspecialchars($row['kelas']) ?></td>
            <td><?= $row['tanggal'] ?></td>
            <td>
                <?php
                $badge = match($row['status']) {
                    'Hadir' => 'success',
                    'Izin' => 'warning',
                    'Sakit' => 'info',
                    'Alpa' => 'danger',
                };
                ?>
                <span class="badge bg-<?= $badge ?>">
                    <?= $row['status'] ?>
                </span>
            </td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</div>

</div>
</div>

</body>
</html>