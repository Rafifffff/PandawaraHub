<?php
// Mendapatkan data dari form
require 'koneksi.php';
$nama_lengkap = $_POST['nama_lengkap'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$nomor_telepon = $_POST['nomor_telepon'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hash password sebelum menyimpan
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query untuk memasukkan data ke tabel
$sql = "INSERT INTO users (nama_lengkap, tanggal_lahir, jenis_kelamin, nomor_telepon, alamat, email, password)
VALUES ('$nama_lengkap', '$tanggal_lahir', '$jenis_kelamin', '$nomor_telepon', '$alamat', '$email', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    header("Location: login.html");
} else {
    echo "Pendaftaran Gagal: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi
$conn->close();
?>