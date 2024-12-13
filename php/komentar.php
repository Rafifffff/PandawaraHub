<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit();
}

if (isset($_GET['id_pabrik'])) {
    $idPabrik = intval($_GET['id_pabrik']);
} else {
    header("Location: ../php/buy.php");
    exit();
}

try {
    $query = "SELECT c.id, c.comment, c.created_at, u.nama_lengkap AS nama_user
              FROM comments c
              JOIN users u ON c.user_id = u.user_id
              WHERE c.id_pabrik = ?
              ORDER BY c.created_at ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idPabrik);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
    } else {
        $comments = [];
    }

    $queryPabrik = "SELECT nama, deskripsi_pabrik FROM pabrik WHERE id_pabrik = ?";
    $stmtPabrik = $conn->prepare($queryPabrik);
    $stmtPabrik->bind_param("i", $idPabrik);
    $stmtPabrik->execute();
    $resultPabrik = $stmtPabrik->get_result();
    
    if ($resultPabrik->num_rows > 0) {
        $pabrik = $resultPabrik->fetch_assoc();
    } else {
        die("Pabrik tidak ditemukan.");
    }

} catch (mysqli_sql_exception $e) {
    die("Error: " . $e->getMessage());
}

$userId = $_SESSION['user_id']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komentar - <?php echo htmlspecialchars($pabrik['nama']); ?></title>
    <link rel="stylesheet" href="../css/komentar.css">

    <style>
        html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    background: linear-gradient(180deg, #1F5F8B 17%, #253B6E 50%, black 110%);
    background-repeat: no-repeat; 
    background-attachment: fixed; 
    background-size: cover;
    font-family: Arial, sans-serif; 
}

body {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}


form textarea {
    width: 100%; 
    max-width: 780px; 
    height: 100px; 
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    resize: none; 
    margin: 0 auto; 
    display: block; 
}


.logo-container {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 10px;
}


.back-button {
    display: inline-block;
    background-color: #2A3A6A; 
    color: white; 
    padding: 10px 20px; 
    font-size: 16px; 
    text-decoration: none; 
    border-radius: 5px;
    font-family: Arial, sans-serif; 
    transition: background-color 0.3s ease; 
}

.back-button:hover {
    background-color: #1F2B4D; 
}

.comment {
    background-color: white; 
    border-radius: 10px; 
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3); 
    padding: 15px; 
    margin: 15px auto; 
    max-width: 800px; 
    transition: transform 0.3s, box-shadow 0.3s; 
}

.comment:hover {
    transform: translateY(-5px); 
    box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.4); 
}

form {
    background-color: white;
    border-radius: 10px; 
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3); 
    padding: 20px; 
    margin: 20px auto; 
    max-width: 800px; 
    transition: transform 0.3s, box-shadow 0.3s; 
}

form:hover {
    transform: translateY(-5px); 
    box-shadow: 0px 12px 20px rgba(0, 0, 0, 0.4); 
}

.comment p {
    word-wrap: break-word; 
    white-space: normal; 
}

form textarea {
    width: 100%; 
    max-width: 780px; 
    height: 100px; 
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
    resize: none; 
    margin: 0 auto; 
    display: block;
    overflow-wrap: break-word; 
}



    </style>
</head>
<body>

<header>
    <div class="logo-container">
        <a href="../php/buy.php" class="back-button">🔙 Kembali</a>
    </div>
</header>


<section>
    <h3>Komentar untuk <?php echo htmlspecialchars($pabrik['nama']); ?></h3>
    <div id="comments-list">
        <?php if (empty($comments)): ?>
            <p>Belum ada komentar.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <strong><?php echo htmlspecialchars($comment['nama_user']); ?></strong>
                    <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                    <small>Diposting pada: <?php echo $comment['created_at']; ?></small>

                    <?php if ($comment['nama_user'] == $_SESSION['nama_lengkap']): ?>
                        <div class="comment-actions">
                            <a href="edit_comment.php?id=<?php echo $comment['id']; ?>" class="edit-link">✏️ Edit</a>
                            <a href="delete_comment.php?id=<?php echo $comment['id']; ?>&id_pabrik=<?php echo $idPabrik; ?>" class="delete-link" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">🗑️ Hapus</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

    <section>
        <h3>Tambahkan Komentar</h3>
        <form action="add_comment.php" method="POST">
            <textarea name="comment" placeholder="Tulis komentar Anda"></textarea>
            <input type="hidden" name="id_pabrik" value="<?php echo $idPabrik; ?>">
            <button type="submit">Kirim Komentar</button>
        </form>
    </section>

</body>
</html>
