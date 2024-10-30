<?php
require 'koneksi.php';
$email = $_POST['email'];
$password = $_POST['password'];

$query_sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query_sql);

if (mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
        header("Location: homepage.html");
        exit();
    } else {
        echo "<center><h1>Email atau Password Anda Salah. Silahkan Coba Login Kembali.</h1><button><strong><a href='login.html'>Kembali</a></strong></button></center>";
    }
} else {
    echo "<center><h1>Email atau Password Anda Salah. Silahkan Coba Login Kembali.</h1><button><strong><a href='login.html'>Kembali</a></strong></button></center>";
}
