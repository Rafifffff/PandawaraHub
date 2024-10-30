<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "user_registration"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysql_connect_error());
} else {
    echo "Koneksi Berhasil";
}