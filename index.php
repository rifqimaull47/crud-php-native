<?php
require_once 'config/koneksi.php';

// Query data
$query = "SELECT * FROM tb_absensi ORDER BY nama_siswa ASC";
$result = $conn->query($query);

// Statistik
$hadir = $conn->query("SELECT COUNT(*) as total FROM tb_absensi WHERE status='Hadir'")->fetch_assoc()['total'];
$izin  = $conn->query("SELECT COUNT(*) as total FROM tb_absensi WHERE status='Izin'")->fetch_assoc()['total'];
$sakit = $conn->query("SELECT COUNT(*) as total FROM tb_absensi WHERE status='Sakit'")->fetch_assoc()['total'];
$alpa  = $conn->query("SELECT COUNT(*) as total FROM tb_absensi WHERE status='Alpa'")->fetch_assoc()['total'];
$total = $conn->query("SELECT COUNT(*) as total FROM tb_absensi")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Absensi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family: 'Poppins', sans-serif;
}

body{
    background: #0f172a;
    min-height: 100vh;
    overflow-x: hidden;
}

/* SIDEBAR */

.sidebar{
    width: 250px;
    height: 100vh;
    position: fixed;
    background: rgba(15,23,42,0.95);
    backdrop-filter: blur(10px);
    padding: 30px 20px;
    border-right: 1px solid rgba(255,255,255,0.1);
}

.logo{
    color: white;
    font-size: 25px;
    font-weight: 700;
    margin-bottom: 40px;
}

.menu a{
    display: flex;
    align-items: center;
    gap: 12px;
    color: #cbd5e1;
    text-decoration: none;
    padding: 14px;
    border-radius: 12px;
    margin-bottom: 10px;
    transition: 0.3s;
}

.menu a:hover{
    background: linear-gradient(135deg,#3b82f6,#8b5cf6);
    color: white;
}

/* CONTENT */

.main{
    margin-left: 250px;
    padding: 30px;
}

/* HEADER */

.topbar{
    background: rgba(255,255,255,0.08);
    padding: 20px;
    border-radius: 20px;
    color: white;
    margin-bottom: 30px;
    backdrop-filter: blur(10px);
}

.topbar h2{
    font-weight: 700;
}

/* CARD */

.stat-card{
    border-radius: 20px;
    padding: 25px;
    color: white;
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}

.stat-card:hover{
    transform: translateY(-5px);
}

.stat-card i{
    position: absolute;
    right: 20px;
    bottom: 15px;
    font-size: 45px;
    opacity: 0.3;
}

.bg1{
    background: linear-gradient(135deg,#3b82f6,#2563eb);
}

.bg2{
    background: linear-gradient(135deg,#10b981,#059669);
}

.bg3{
    background: linear-gradient(135deg,#f59e0b,#d97706);
}

.bg4{
    background: linear-gradient(135deg,#ef4444,#dc2626);
}

.bg5{
    background: linear-gradient(135deg,#8b5cf6,#7c3aed);
}

/* TABLE */

/* TABLE MODERN */

.table-box{
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 28px;
    padding: 28px;
    margin-top: 35px;
    backdrop-filter: blur(18px);
    box-shadow:
        0 10px 40px rgba(0,0,0,0.25),
        inset 0 1px 0 rgba(255,255,255,0.04);
}

.table-box h5{
    font-weight: 600;
    font-size: 24px;
}

.table-responsive{
    border-radius: 22px;
    overflow: hidden;
}

.table{
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0 12px;
    color: white;
}

.table thead tr{
    background: transparent;
}

.table thead th{
    border: none;
    color: #94a3b8;
    font-size: 14px;
    font-weight: 600;
    padding: 18px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.table tbody tr{
    background: rgba(255,255,255,0.06);
    transition: 0.3s;
    border-radius: 18px;
}

.table tbody tr:hover{
    transform: scale(1.01);
    background: rgba(59,130,246,0.12);
}

.table tbody td{
    border: none;
    padding: 22px 18px;
    vertical-align: middle;
    font-size: 15px;
    color: #000000;
}

/* biar rounded per row */

.table tbody tr td:first-child{
    border-radius: 16px 0 0 16px;
}

.table tbody tr td:last-child{
    border-radius: 0 16px 16px 0;
}

/* BADGE */

.badge{
    padding: 10px 18px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .5px;
}

/* BUTTON */

.btn-modern{
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    border: none;
    border-radius: 14px;
    padding: 12px 22px;
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: .3s;
    box-shadow: 0 10px 20px rgba(37,99,235,.25);
}

.btn-modern:hover{
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 15px 30px rgba(37,99,235,.35);
}

/* AKSI BUTTON */

.btn-warning,
.btn-danger{
    border: none;
    border-radius: 12px;
    width: 42px;
    height: 42px;
    padding: 0;
    transition: .3s;
}

.btn-warning:hover,
.btn-danger:hover{
    transform: scale(1.08);
}

/* ICON */

.bi-pencil-square,
.bi-trash{
    font-size: 16px;
}

/* MOBILE */

@media(max-width:768px){

.table thead{
    display: none;
}

.table tbody tr{
    display: block;
    margin-bottom: 20px;
    border-radius: 18px;
    padding: 10px;
}

.table tbody td{
    display: flex;
    justify-content: space-between;
    padding: 14px;
}

}
.badge{
    padding: 8px 12px;
    border-radius: 10px;
}

.search-box{
    background: rgba(255,255,255,0.08);
    border: none;
    color: white;
    border-radius: 12px;
    padding: 12px;
}

.search-box::placeholder{
    color: #cbd5e1;
}

/* CHART */

.chart-box{
    background: rgba(255,255,255,0.08);
    padding: 20px;
    border-radius: 20px;
    margin-top: 30px;
    backdrop-filter: blur(10px);
}

/* BUTTON */

.btn-modern{
    border: none;
    border-radius: 12px;
    padding: 10px 18px;
    color: white;
    text-decoration: none;
    transition: 0.3s;
}

.btn-modern:hover{
    transform: scale(1.05);
    color: white;
}

/* RESPONSIVE */

@media(max-width:992px){

.sidebar{
    width: 100%;
    height: auto;
    position: relative;
}

.main{
    margin-left: 0;
}

}

</style>

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">
        📚 Absensi
    </div>

    <div class="menu">

        <a href="#">
            <i class="bi bi-house-door"></i>
            Dashboard
        </a>

        <a href="tambah.php">
            <i class="bi bi-plus-circle"></i>
            Tambah Data
        </a>

        <a href="#">
            <i class="bi bi-bar-chart"></i>
            Statistik
        </a>

    </div>

</div>

<!-- MAIN -->

<div class="main">

    <!-- HEADER -->

    <div class="topbar d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h2>Dashboard Absensi</h2>
            <small class="text-light">
                Sistem Kehadiran Siswa Modern
            </small>
        </div>

        <div id="clock" class="fw-bold"></div>

    </div>

    <!-- SEARCH -->

    <div class="row mb-4">

        <div class="col-md-4">

            <input 
                type="text"
                id="searchInput"
                class="form-control search-box"
                placeholder="🔍 Cari siswa..."
            >

        </div>

    </div>

    <!-- STAT -->

    <div class="row g-4">

        <div class="col-md-3">
            <div class="stat-card bg1">
                <h6>Total</h6>
                <h2><?= $total ?></h2>
                <i class="bi bi-people-fill"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg2">
                <h6>Hadir</h6>
                <h2><?= $hadir ?></h2>
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg3">
                <h6>Izin</h6>
                <h2><?= $izin ?></h2>
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card bg4">
                <h6>Alpa</h6>
                <h2><?= $alpa ?></h2>
                <i class="bi bi-x-circle-fill"></i>
            </div>
        </div>

    </div>

    <!-- CHART -->

    <div class="chart-box">

        <h5 class="text-white mb-4">
            📊 Statistik Kehadiran
        </h5>

        <div style="max-width:500px; height:300px; margin:auto;">
            <canvas id="myChart"></canvas>
        </div>

    </div>

    <!-- TABLE -->

    <div class="table-box">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="text-white">
                📋 Data Siswa
            </h5>

            <a href="tambah.php" class="btn-modern bg-primary">
                + Tambah
            </a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle text-center">

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

                        <td>
                            <?= htmlspecialchars($row['nama_siswa']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['kelas']) ?>
                        </td>

                        <td>
                            <?= $row['tanggal'] ?>
                        </td>

                        <td>

                        <?php

                        if ($row['status'] == 'Hadir') {
                            $badge = 'success';
                        }
                        elseif ($row['status'] == 'Izin') {
                            $badge = 'warning';
                        }
                        elseif ($row['status'] == 'Sakit') {
                            $badge = 'info';
                        }
                        else {
                            $badge = 'danger';
                        }

                        ?>

                        <span class="badge bg-<?= $badge ?>">
                            <?= $row['status'] ?>
                        </span>

                        </td>

                        <td>

                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- SEARCH -->

<script>

document.getElementById('searchInput').addEventListener('keyup', function() {

    let filter = this.value.toLowerCase();

    let rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {

        let nama = row.cells[1].textContent.toLowerCase();

        if (nama.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});

</script>

<!-- CLOCK -->

<script>

function updateClock(){

    const now = new Date();

    document.getElementById('clock').innerHTML =
        now.toLocaleTimeString('id-ID') + ' WIB';

}

setInterval(updateClock,1000);

updateClock();

</script>

<!-- CHART -->

<script>

const ctx = document.getElementById('myChart');

new Chart(ctx, {

    type: 'doughnut',

    data: {

        labels: ['Hadir','Izin','Sakit','Alpa'],

        datasets: [{

            data: [
                <?= $hadir ?>,
                <?= $izin ?>,
                <?= $sakit ?>,
                <?= $alpa ?>
            ],

            backgroundColor: [
                '#3b82f6',
                '#f59e0b',
                '#ec4899',
                '#facc15'
            ],

            borderWidth: 0

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            legend: {
                labels: {
                    color: 'white'
                }
            }

        }

    }

});

</script>

</body>
</html>