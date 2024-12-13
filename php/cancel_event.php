<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit();
}

$userId = $_SESSION['user_id'];
$eventId = $_POST['event_id'] ?? null;

if ($eventId) {
    $query = "DELETE FROM user_events WHERE user_id = ? AND event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $eventId);

    if ($stmt->execute()) {
        header("Location: daftarkegiatan.php");
        exit();
    } else {
        echo "Gagal membatalkan partisipasi.";
    }

    $stmt->close();
}

$conn->close();
?>
