<?php

include '../php/koneksi.php';

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $date = $_POST['date'];
    $description = $_POST['description'];
    
    $targetDir = "../uploads/";
    
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $query = "INSERT INTO events (title, date, description, image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $title, $date, $description, $fileName);
            if ($stmt->execute()) {
                echo "Data dan gambar berhasil diunggah.";
            } else {
                echo "Gagal menyimpan data ke database.";
            }
        } else {
            echo "Gagal mengunggah gambar ke server.";
        }
    } else {
        echo "Format file tidak didukung. Gunakan file JPG, JPEG, PNG, atau GIF.";
    }
}
?>
