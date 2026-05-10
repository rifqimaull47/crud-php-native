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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Absensi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    min-height: 50vh;
    background:
        radial-gradient(circle at top left, #2563eb 0%, transparent 30%),
        radial-gradient(circle at bottom right, #7c3aed 0%, transparent 30%),
        #0f172a;
    overflow: hidden;
    position: relative;
}

/* BACKGROUND BLUR */

.blur1,
.blur2{
    position: absolute;
    border-radius: 50%;
    filter: blur(120px);
    opacity: .4;
}

.blur1{
    width: 300px;
    height: 300px;
    background: #3b82f6;
    top: -80px;
    left: -80px;
}

.blur2{
    width: 350px;
    height: 350px;
    background: #8b5cf6;
    bottom: -100px;
    right: -100px;
}

/* CONTAINER */

.main-container{
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    position: relative;
    z-index: 2;
}

/* CARD */

.form-card{
    width: 100%;
    max-width: 380px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    border-radius: 28px;
    padding: 22px;
    box-shadow:
        0 15px 40px rgba(0,0,0,.30),
        inset 0 1px 0 rgba(255,255,255,.05);
    animation: fadeIn .7s ease;
}

@keyframes fadeIn{

    from{
        opacity: 0;
        transform: translateY(20px);
    }

    to{
        opacity: 1;
        transform: translateY(0);
    }

}

/* HEADER */

.form-header{
    margin-bottom: 18px;
}
.logo-icon{
    width: 75px;
    height: 75px;
    margin: auto;
    border-radius: 20px;
    background: linear-gradient(135deg,#3b82f6,#8b5cf6);
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 30px;
    color: white;
    margin-bottom: 16px;
    box-shadow: 0 10px 30px rgba(59,130,246,.35);
}

.form-header h2{
    color: white;
    font-weight: 700;
    margin-bottom: 6px;
}

.form-header p{
    color: #cbd5e1;
    font-size: 14px;
}

/* INPUT */

.form-label{
    color: white;
    font-weight: 500;
    margin-bottom: 10px;
}

.input-group{
    margin-bottom: 16px;
}

.input-group-text{
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.08);
    color: #cbd5e1;
    border-radius: 14px 0 0 14px;
    padding: 10px 14px;
}

.form-control,
.form-select{
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.08);
    color: white;
    border-radius: 0 14px 14px 0;
    padding: 10px 14px;
}   

.form-control::placeholder{
    color: #94a3b8;
}

.form-control:focus,
.form-select:focus{
    background: rgba(255,255,255,0.08);
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59,130,246,.15);
    color: white;
}

.form-select option{
    color: black;
}

/* BUTTON */

.btn-save{
    width: 100%;
    border: none;
    padding: 11px;
    border-radius: 14px;
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    color: white;
    font-weight: 600;
    transition: .3s;
    margin-top: 10px;
    box-shadow: 0 10px 25px rgba(37,99,235,.35);
}

.btn-save:hover{
    transform: translateY(-3px);
}

.btn-back{
    width: 100%;
    display: inline-block;
    text-align: center;
    padding: 11px;
    border-radius: 14px;
    margin-top: 14px;
    text-decoration: none;
    color: white;
    background: rgba(255,255,255,0.08);
    transition: .3s;
    border: 1px solid rgba(255,255,255,0.08);
}

.btn-back:hover{
    background: rgba(255,255,255,0.12);
    color: white;
}

/* MOBILE */

@media(max-width:576px){

.form-card{
    padding: 28px 22px;
}

.logo-icon{
    width: 65px;
    height: 65px;
    font-size: 26px;
    border-radius: 18px;
    margin-bottom: 12px;
}
}

</style>

</head>

<body>

<div class="blur1"></div>
<div class="blur2"></div>

<div class="main-container">

    <div class="form-card">

        <!-- HEADER -->

        <div class="form-header">

            <div class="logo-icon">
                <i class="bi bi-clipboard-plus-fill"></i>
            </div>

            <h2>Tambah Absensi</h2>

            <p>
                Input data kehadiran siswa dengan mudah
            </p>

        </div>

        <!-- FORM -->

        <form method="POST">

            <!-- NAMA -->

            <label class="form-label">
                Nama Siswa
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-person-fill"></i>
                </span>

                <input 
                    type="text"
                    name="nama_siswa"
                    class="form-control"
                    placeholder="Masukkan nama siswa..."
                    required
                >

            </div>

            <!-- KELAS -->

            <label class="form-label">
                Kelas
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>

                <input 
                    type="text"
                    name="kelas"
                    class="form-control"
                    placeholder="Contoh: XI PPLG 3"
                    required
                >

            </div>

            <!-- TANGGAL -->

            <label class="form-label">
                Tanggal
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-calendar-event-fill"></i>
                </span>

                <input 
                    type="date"
                    name="tanggal"
                    class="form-control"
                    required
                >

            </div>

            <!-- STATUS -->

            <label class="form-label">
                Status Kehadiran
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="bi bi-ui-checks-grid"></i>
                </span>

                <select name="status" class="form-select">

                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alpa">Alpa</option>

                </select>

            </div>

            <!-- BUTTON -->

            <button type="submit" class="btn-save">

                <i class="bi bi-save-fill"></i>
                Simpan Data

            </button>

            <a href="index.php" class="btn-back">

                <i class="bi bi-arrow-left"></i>
                Kembali ke Dashboard

            </a>

        </form>

    </div>

</div>

</body>
</html>