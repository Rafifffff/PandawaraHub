<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];
$eventId = $_POST['event_id'];

$query = "SELECT COUNT(*) AS count FROM user_events WHERE user_id = ? AND event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $userId, $eventId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $query = "INSERT INTO user_events (user_id, event_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $eventId);
    $stmt->execute();
}

$stmt->close();
$conn->close();

header("Location: daftarkegiatan.php");
exit();
?>
