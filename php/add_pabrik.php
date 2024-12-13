<?php
include '../php/koneksi.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $deskripsi_pabrik = $_POST['deskripsi_pabrik'];
    $lokasi = $_POST['lokasi'];
    
    $targetDir = "../uploads/";
    
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $query = "INSERT INTO pabrik (nama, deskripsi_pabrik, lokasi, image_url) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $nama, $deskripsi_pabrik, $lokasi, $fileName);
            if ($stmt->execute()) {
                echo "Data pabrik dan gambar berhasil diunggah.";
            } else {
                echo "Gagal menyimpan data pabrik ke database.";
            }
        } else {
            echo "Gagal mengunggah gambar ke server.";
        }
    } else {
        echo "Format file tidak didukung. Gunakan file JPG, JPEG, PNG, atau GIF.";
    }
}
?>






