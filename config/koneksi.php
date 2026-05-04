<?php
// Mendefinisikan konstanta koneksi
define('DB_HOST', 'localhost'); // Server database
define('DB_USER', 'root');      // Username
define('DB_PASS', '');          // Password
define('DB_NAME', 'db_absensi_siswa'); // Nama database

// Membuat koneksi
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set karakter
$conn->set_charset("utf8");
?>