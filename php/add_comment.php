<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User belum login"]);
    exit();
}

if (isset($_POST['id_pabrik']) && isset($_POST['comment'])) {
    $userId = $_SESSION['user_id'];
    $idPabrik = intval($_POST['id_pabrik']);
    $comment = trim($_POST['comment']);

    $query = "INSERT INTO comments (user_id, id_pabrik, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $userId, $idPabrik, $comment);

    if ($stmt->execute()) {
        header("Location: komentar.php?id_pabrik=" . $idPabrik);
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Gagal menambahkan komentar"]);
    }
}
?>






