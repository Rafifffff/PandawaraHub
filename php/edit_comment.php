<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.html");
    exit();
}

if (isset($_GET['id'])) {
    $commentId = intval($_GET['id']);
    $userId = $_SESSION['user_id'];

    $query = "SELECT * FROM comments WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $commentId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Komentar tidak ditemukan atau Anda tidak memiliki izin untuk mengedit.");
    }

    $comment = $result->fetch_assoc();
} else {
    die("ID komentar tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newComment = $_POST['comment'];
    $query = "UPDATE comments SET comment = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $newComment, $commentId, $userId);

    if ($stmt->execute()) {
        header("Location: komentar.php?id_pabrik=" . $comment['id_pabrik']);
        exit();
    } else {
        echo "Gagal mengupdate komentar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Komentar</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(180deg, #1F5F8B 17%, #253B6E 50%, black 110%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white; 
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); 
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 80%;
            max-width: 600px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .container:hover {
            transform: translateY(-5px); 
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3); 
        }

        h3 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        textarea {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            resize: none;
            min-height: 120px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        textarea:focus {
            border-color: #5c9bdf; 
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
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
            margin-bottom: 20px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #1F2B4D;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="../php/komentar.php?id_pabrik=<?php echo $comment['id_pabrik']; ?>" class="back-button">🔙 Kembali</a>
        <h3>Edit Komentar</h3>
        <form action="" method="POST">
            <textarea name="comment" rows="4" cols="50"><?php echo htmlspecialchars($comment['comment']); ?></textarea>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>


