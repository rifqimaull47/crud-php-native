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

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
}

.edit-container {
    width: 430px;
}

.card {
    border: none;
    border-radius: 25px;
    padding: 25px;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    animation: fadeIn 0.5s ease;
}

.title-icon {
    font-size: 50px;
    color: #4e54c8;
}

.form-label {
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control,
.form-select {
    border-radius: 12px;
    padding: 12px;
    border: 1px solid #ddd;
    transition: 0.3s;
}

.form-control:focus,
.form-select:focus {
    border-color: #6c63ff;
    box-shadow: 0 0 10px rgba(108,99,255,0.2);
}

.input-group-text {
    border-radius: 12px 0 0 12px;
    background: #f3f4ff;
    border: 1px solid #ddd;
}

.btn {
    border-radius: 12px;
    padding: 10px;
    font-weight: 500;
    transition: 0.3s;
}

.btn-warning {
    background: linear-gradient(90deg, #f7971e, #ffd200);
    border: none;
    color: white;
}

.btn-warning:hover {
    transform: translateY(-2px);
    color: white;
}

.btn-light:hover {
    background: #ececec;
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

    <div class="edit-container">

        <div class="card shadow-lg">

            <div class="text-center mb-4">

                <i class="bi bi-pencil-square title-icon"></i>

                <h3 class="fw-bold mt-2">
                    Edit Absensi
                </h3>

                <small class="text-muted">
                    Perbarui data kehadiran siswa
                </small>

            </div>

            <form method="POST">

                <div class="mb-3">

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
                            value="<?= htmlspecialchars($data['nama_siswa']); ?>"
                            required
                        >

                    </div>

                </div>

                <div class="mb-3">

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
                            value="<?= htmlspecialchars($data['kelas']); ?>"
                            required
                        >

                    </div>

                </div>

                <div class="mb-3">

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
                            value="<?= $data['tanggal']; ?>"
                            required
                        >

                    </div>

                </div>

                <div class="mb-4">

                    <label class="form-label">
                        Status Kehadiran
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-ui-checks-grid"></i>
                        </span>

                        <select name="status" class="form-select">

                            <option value="Hadir" <?= $data['status']=='Hadir'?'selected':''; ?>>
                                Hadir
                            </option>

                            <option value="Izin" <?= $data['status']=='Izin'?'selected':''; ?>>
                                Izin
                            </option>

                            <option value="Sakit" <?= $data['status']=='Sakit'?'selected':''; ?>>
                                Sakit
                            </option>

                            <option value="Alpa" <?= $data['status']=='Alpa'?'selected':''; ?>>
                                Alpa
                            </option>

                        </select>

                    </div>

                </div>

                <button type="submit" class="btn btn-warning w-100">

                    <i class="bi bi-save-fill"></i>
                    Update Data

                </button>

                <a href="index.php" class="btn btn-light w-100 mt-2">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>