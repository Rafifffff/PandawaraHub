<?php
// Koneksi ke database
$servername = "localhost"; // ganti dengan nama server Anda
$username = "root"; // ganti dengan username database Anda
$password = ""; // ganti dengan password database Anda
$dbname = "user_registration"; // nama database yang telah dibuat

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysql_connect_error());
} else {
    echo "Koneksi Berhasil";
}