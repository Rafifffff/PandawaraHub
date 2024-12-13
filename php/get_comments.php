<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id_pabrik'])) {
    $idPabrik = intval($_GET['id_pabrik']);

    $query = "
        SELECT 
            c.comment, 
            c.created_at, 
            u.nama_lengkap AS nama_user 
        FROM 
            comments c 
        JOIN 
            users u 
        ON 
            c.user_id = u.id 
        WHERE 
            c.id_pabrik = ?
        ORDER BY 
            c.created_at ASC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idPabrik);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    echo json_encode($comments);
} else {
    echo json_encode(["error" => "ID pabrik tidak valid"]);
}
?>


