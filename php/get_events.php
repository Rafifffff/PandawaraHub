<?php
include 'koneksi.php';

header('Content-Type: application/json');

$query = "SELECT event_id, title, date, description, image FROM events ORDER BY date DESC";
$result = $conn->query($query);

if (!$result) {
    echo json_encode(["error" => "Error executing query: " . $conn->error]);
    http_response_code(500); 
    exit;
}

$events = [];

while ($row = $result->fetch_assoc()) {
    $date = date('l, d/m/Y', strtotime($row['date']));
    $events[] = [
        'event_id' => $row['event_id'],
        'title' => $row['title'],
        'date' => $date,
        'description' => $row['description'],
        'image' => $row['image']
    ];
}

echo json_encode($events);
$conn->close();

