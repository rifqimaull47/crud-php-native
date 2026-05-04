<?php
require_once 'config/koneksi.php';

// Query ambil data
$query = "SELECT * FROM tb_absensi ORDER BY id DESC";
$result = $conn->query($query);

// Cek error query
if (!$result) {
    die("Query error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Absensi Siswa</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            color: #333;
        }
        .container-box {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .table thead {
            background: #4e54c8;
            color: white;
        }
        .btn-custom {
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="container-box">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Data Absensi Siswa</h3>
            <a href="tambah.php" class="btn btn-success">+ Tambah Data</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_siswa']); ?></td>
                        <td><?= htmlspecialchars($row['kelas']); ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td>
                            <?php
                                $status = $row['status'];
                                $badge = match($status) {
                                    'Hadir' => 'success',
                                    'Izin' => 'warning',
                                    'Sakit' => 'info',
                                    'Alpa' => 'danger',
                                };
                            ?>
                            <span class="badge bg-<?= $badge; ?>">
                                <?= $status; ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm btn-custom">Edit</a>
                            <a href="hapus.php?id=<?= $row['id']; ?>" 
                               class="btn btn-danger btn-sm btn-custom"
                               onclick="return confirm('Yakin hapus data?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
                </body>
            </table>
        </div>

    </div>
</div>

</body>
</html>